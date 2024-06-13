<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all users from the database
        $users = User::where('type', 'user')->get();

        return view('manage_users.index', compact('users'));
    }



    /**
     * Display the specified resource.
     */
    public function toggleStatus(User $user)
    {
        $user->is_enabled = !$user->is_enabled;
        $user->save();

        return response()->json(['message' => 'User status updated successfully.']);
    }
}
