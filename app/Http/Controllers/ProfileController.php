<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\Chapter;
use App\Models\Payment;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = Auth::user();

        return view('profile.index', compact('user'));
    }

    public function analytic()
    {

        // Get stories owned by the logged-in user
        $stories = Story::where('user_id', Auth::id())->get();

        // Initialize total earned amount
        $totalEarned = 0;

        // Calculate total amount earned from all chapters of user's stories
        foreach ($stories as $story) {
            foreach ($story->chapters as $chapter) {
                // Calculate total payments received for this chapter
                $totalPayments = Payment::where('chapter_id', $chapter->id)->sum('amount');

                // Calculate 90% of total payments received
                $userEarned = $totalPayments * 0.9;

                // Add to total earned amount
                $totalEarned += $userEarned;
            }
        }

        // Optionally, you can format the total amount if needed
        $formattedTotalEarned = number_format($totalEarned, 2);

        // Initialize an array to store purchase counts for each story
        $purchaseStats = [];

        foreach ($stories as $story) {
            // Count distinct users who purchased this story
            $userCount = Purchase::where('story_id', $story->id)
                ->distinct('user_id')
                ->count();

            // Store the result for this story
            $purchaseStats[$story->title] = $userCount;
        }

        return view('profile.analytic', compact('formattedTotalEarned', 'purchaseStats'));
    }


    /**
     * Update the profile information.
     */
    public function update(Request $request)
    {
        $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'about' => 'nullable|max:500',
            'country' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'social_media' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $profileData = $request->only(['country', 'address', 'about', 'phone', 'social_media']);

        if ($request->hasFile('photo')) {
            if ($user->profile && $user->profile->photo) {
                Storage::delete('public/' . $user->profile->photo);
            }
            $profileData['photo'] = $request->file('photo')->store('profile_images', 'public');
        }

        if ($user->profile) {

            $user->profile->update($profileData);
        } else {
            $user->profile()->create($profileData);
        }

        return back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Update paypal Account iformation information.
     */
    public function updatePaymentInfo(Request $request)
    {
        $request->validate([
            'paypal_account' => 'required|email',
        ]);

        $user = auth()->user();
        $user->paypal_account = $request->paypal_account;

        $user->save();

        return redirect()->back()->with('success', 'PayPal account updated successfully.');
    }
}
