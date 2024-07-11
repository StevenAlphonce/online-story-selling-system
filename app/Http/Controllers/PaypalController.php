<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Chapter;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaypalController extends Controller
{
  public function paypal(Request $request)
  {
    $chapterId = $request->chapter_id;
    $userId = Auth::user()->id;

    // Check if the user has already purchased the chapter
    $existingPurchase = Purchase::where('chapter_id', $chapterId)
      ->where('user_id', $userId)
      ->first();

    if ($existingPurchase) {
      return response()->json(['error' => 'You have already purchased this chapter.']);
    }

    $user = Auth::user();
    // Check if user has a PayPal account

    $provider = new PayPalClient;
    $provider->setApiCredentials(config('paypal'));
    $paypalTokenData = $provider->getAccessToken();
    Log::info('PayPal Token Data: ', $paypalTokenData);

    $paypalToken = $paypalTokenData['access_token'] ?? null;
    if (!$paypalToken) {
      Log::error('Failed to retrieve PayPal access token.');
      return redirect()->route('cancel')->withErrors('Failed to retrieve PayPal access token.');
    }

    if ($user->paypal_account) {

      $response = $provider->createOrder([
        "intent" => "CAPTURE",
        "application_context" => [
          "return_url" => route('success'),
          "cancel_url" => route('cancel')
        ],
        "purchase_units" => [
          [
            "amount" => [
              "currency_code" => "USD",
              "value" => $request->price
            ]
          ]
        ]
      ]);

      if (isset($response['id']) && $response['id'] != null) {
        foreach ($response['links'] as $link) {
          if ($link['rel'] == 'approve') {
            session()->put('chapter_id', $request->chapter_id);
            session()->put('chapter_title', $request->chapter_title);
            session()->put('amount', $request->price);

            return redirect()->away($link['href']);
          }
        }
      } else {
        return redirect()->route('cancel');
      }
    }
    Log::warning('User does not have a PayPal account', ['user_id' => $user->id]);
    return redirect(route('user.profile'));
  }



  public function success(Request $request)
  {
    $provider = new PayPalClient;
    $provider->setApiCredentials(config('paypal'));
    $paypalTokenData = $provider->getAccessToken();
    Log::info('PayPal Token Data: ', $paypalTokenData);

    $paypalToken = $paypalTokenData['access_token'] ?? null;
    if (!$paypalToken) {
      Log::error('Failed to retrieve PayPal access token.');
      return redirect()->route('cancel')->withErrors('Failed to retrieve PayPal access token.');
    }

    $response = $provider->capturePaymentOrder($request->token);
    Log::info('PayPal Capture Payment Response: ', $response);

    if (isset($response['status']) && $response['status'] == 'COMPLETED') {
      // Retrieve the chapter and story
      $chapterId = session()->get('chapter_id');
      $chapter = Chapter::find($chapterId);
      $story = $chapter->story;
      $creator = $story->user;

      // Insert data into payments table
      $payment = new Payment;
      $payment->payment_id = $response['id'];
      $payment->chapter_id = $chapterId;
      $payment->chapter_title = $chapter->title;
      $payment->amount = $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'];
      $payment->currency = $response['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'];
      $payment->payer_name = $response['payer']['name']['given_name'];
      $payment->payer_email = $response['payer']['email_address'];
      $payment->payment_status = $response['status'];
      $payment->payment_method = "PayPal";
      $payment->save();

      // Create a new purchase record
      $purchase = new Purchase;
      $purchase->story_id = $story->id;
      $purchase->chapter_id = $chapterId;
      $purchase->user_id = Auth::user()->id;
      $purchase->purchase_date = now();
      $purchase->purchase_type = 'chapter';
      $purchase->save();

      // Calculate the amounts
      $amount = $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'];

      $creatorAmount = $amount * 0.90;

      // Handle actual fund transfer to creator's PayPal account
      $this->sendPayout($creator->paypal_account, $creatorAmount, $paypalToken);

      // Preview purchased chapter from reader (buyer library)
      return redirect(route('story.show', $story->id))->with('success', 'You have successfully purchased the chapter');
    } else {
      return redirect()->route('cancel');
    }
  }

  /**
   * Function to create payout request for dividing funds to Author and Online Story Selling System
   */

  private function sendPayout($recipientEmail, $amount, $paypalToken)
  {
    $client = new Client();
    try {
      $response = $client->post('https://api.sandbox.paypal.com/v1/payments/payouts', [
        'headers' => [
          'Authorization' => "Bearer {$paypalToken}",
          'Content-Type' => 'application/json',
        ],
        'json' => [
          'sender_batch_header' => [
            'sender_batch_id' => uniqid(),
            'email_subject' => 'You have a payment',
          ],
          'items' => [
            [
              'recipient_type' => 'EMAIL',
              'amount' => [
                'value' => $amount,
                'currency' => 'USD'
              ],
              'receiver' => $recipientEmail,
              'note' => 'Thanks for your story!',
              'sender_item_id' => uniqid(),
            ]
          ],
        ],
      ]);

      $data = json_decode($response->getBody(), true);
      Log::info("Payout Response: ", $data);
    } catch (\Exception $e) {
      Log::error("Payout Error: ", ['error' => $e->getMessage()]);
    }
  }

  /**
   * Function to cancel the payment process during uncertainty i.e. offline
   */

  public function cancel()
  {
    return redirect()->back()->with("error", "Payment is cancelled.");
  }
}
