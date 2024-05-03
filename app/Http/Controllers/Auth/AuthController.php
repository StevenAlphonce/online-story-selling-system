<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Mail\VerifyEmail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordEmail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    //Function to show (view) user registration form
    public function show_registration_form()
    {

        return view('auth.register');
    }

    //Function to store and send verification (token) to registered user
    public function store_user(Request $request)
    {

        $request->validate([
            'name' => 'required|min:2|max:20',
            'email' => 'required|email|unique:users',
            'password' => [
                'required', 'confirmed', Password::min(6)
                // ->mixedCase()
                // ->letters()
                // ->numbers()
                // ->symbols()
                // ->uncompromised(),

            ],
        ]);

        $save = new User();

        $save->name = trim($request->name);
        $save->email = trim($request->email);
        $save->password = Hash::make($request->password);

        //Generating remember token to verify registered user
        $save->remember_token = Str::random(40);

        $save->save();

        //Sending verification email to a user during registration
        Mail::to($save->email)->send(new VerifyEmail($save));

        return redirect('login')->with('success', "Your account registered sucessfuly,Please check your inbox to verify your Account.");
    }

    //Function to verify user (token) after registration
    public function verify_user($token)
    {

        $user = User::where('remember_token', '=', $token)->first();

        if (!empty($user)) {
            //Save the time that the user(Token) was verified
            $user->email_verified_at = date('Y-m-d H:i:s');
            $user->remember_token = Str::random(40); //Changes the remeber token
            $user->save();

            return redirect('login')->with('success', "Your account was verified.");
        } else {

            abort(404);
        }
    }

    //Function to show login(view) form
    public function show_login_form()
    {

        return view('auth.login');
    }

    //Function Login user
    public function login(Request $request)
    {

        $remember = !empty($request->remember) ? true : false;

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            if (!empty(Auth::user()->email_verified_at)) {

                return  redirect('/');
            } else {

                //Send verification email(Token) to user
                $user = User::getSingle(Auth::user()->id); //Get user in mixed form to send the email.
                Auth::logout(); // withdraw the token

                //Generating remember token to verify registered user
                $user->remember_token = Str::random(40);

                $user->save();

                //Sending verification email to a user during registration
                Mail::to($user->email)->send(new VerifyEmail($user));

                return redirect()->back()->with('warning', "Please verify your account!!,check your inbox");
            }
        } else {

            return redirect()->back()->with('error', "Please enter correct credentials");
        }
    }


    //Function to show (view) reset password form
    public function reset_password_form()
    {

        return view('auth.reset-password');
    }


    //Function to locate user account that need to be reset.
    public function reset_password(Request $request)
    {

        $user = User::where('email', '=', $request->email)->first();

        if (!empty($user)) {
            //Send reset email with reset token
            $user->remember_token = Str::random(40);
            $user->save();

            //Sending email to user
            Mail::to($user->email)->send(new ResetPasswordEmail($user));

            return redirect()->back()->with('success', "Reset password sent successfully");
        } else {
            return redirect()->back()->with('error', "We cant find " . $request->email . " email address.");
        }
    }

    //Function to show change password form
    public function changePasswordForm($token)
    {
        $user = User::where('remember_token', '=', $token)->first();

        if (!empty($user)) {
            $data['user'] = $user;

            return view('auth.change-password', $data);
        } else {
            abort(404);
        }
    }

    //Function to change password
    public function changePassword(Request $request, $token)
    {

        $user = User::where('remember_token', '=', $token)->first();

        if (!empty($user)) {

            $request->validate([
                'password' => [
                    'required', 'confirmed', Password::min(6)
                    // ->mixedCase()
                    // ->letters()
                    // ->numbers()
                    // ->symbols()
                    // ->uncompromised(),

                ],
            ]);

            $user->password = Hash::make($request->password);
            if (empty($user->email_verified_at)) {
                $user->email_verified_at = date('Y-m-d H:i:s');
            }
            $user->remember_token = Str::random(40);
            $user->save();

            return redirect('login')->with('success', "Your password was changed successfully");
        } else {
            abort(404);
        }
    }


    //Function to logout user

    public function logout()
    {

        Auth::logout();

        return redirect('/');
    }
}
