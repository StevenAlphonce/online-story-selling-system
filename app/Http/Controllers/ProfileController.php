<?php

namespace App\Http\Controllers;

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
     * Update Password from profile.
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'newpassword' => 'required|min:8',
            'renewpassword' => 'required|same:newpassword',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {

            return back()->with(['error' => 'Current password does not match']);
        }

        $user->password = Hash::make($request->newpassword);

        $user->save();

        // Send notification email
        $this->sendPasswordChangeNotification($user);

        return back()->with('success', 'Password changed successfully');
    }

    protected function sendPasswordChangeNotification($user)
    {
        $resetLink = route('password.reset');
        $details = [
            'email' => $user->email,
            'resetLink' => $resetLink,
        ];

        Mail::send('emails.password-change-notification', $details, function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Password Changed Notification');
        });
    }
}
