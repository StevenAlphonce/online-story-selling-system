<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\Payment;
use App\Models\Purchase;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // Get stories owned by the logged-in user
        $stories = Story::all();

        // Initialize total earned amount
        $totalEarned = 0;

        // Calculate total amount earned from all chapters of user's stories
        foreach ($stories as $story) {
            foreach ($story->chapters as $chapter) {
                // Calculate total payments received for this chapter
                $totalPayments = Payment::all()->sum('amount');

                // Calculate 90% of total payments received
                $userEarned = $totalPayments * 0.1;

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
            $userCount = Purchase::All()->count();

            // Store the result for this story
            $purchaseStats[$story->title] = $userCount;
        }

        return view('dashboard.index', compact('formattedTotalEarned', 'purchaseStats'));
    }
}
