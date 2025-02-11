<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        return view('admin.dashboard', compact('user'));
    }

    public function login()
    {
        return view('admin.login');
    }

    public function adminauthenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }
    
        try {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
    
                if (in_array($user->role, [1, 2])) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Logged in successfully',
                        'redirect_url' => route('dashboard') // Send back URL
                    ]);
                } else {
                    Auth::logout();
                    return response()->json([
                        'success' => false,
                        'message' => 'You are not authorized to access the dashboard.'
                    ]);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid email or password.'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during login. Please try again later.'
            ]);
        }
    }
    

    public function forgotPassword()
    {
        return view('admin.forgotPassword');
    }

    public function processForgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required | email | exists:users,email'
        ]);

        if ($validator->passes()) {
            $token = Str::random(60);
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => now()
            ]);

            $user = User::where('email', $request->email)->first();

            $mailData = [
                'subject' => 'Password Reset Token',
                'token' => $token,
                'user' => $user
            ];

            Mail::to($request->email)->send(new ResetPasswordEmail($mailData));

            return redirect()->route('forgotPassword')->with('success', 'Please check your inbox to reset password');
        } else {
            return redirect()->route('forgotPassword')->withInput()->withErrors($validator);
        }
    }


    public function resetPassword($token)
    {
        $tokenExists = DB::table('password_reset_tokens')->where('token', $token)->first();
        if (empty($tokenExists)) {
            return redirect()->route('forgotPassword')->with('error', 'Invalid Request');
        }
        return view('admin.resetPassword', compact('token'));
    }

    public function processResetPassword(Request $request)
    {
        $token = $request->token;
        $tokenObject = DB::table('password_reset_tokens')->where('token', $token)->first();
        if (empty($tokenObject)) {
            return redirect()->route('forgotPassword')->with('error', 'Invalid Request');
        }
        $validator = Validator::make($request->all(), [
            'new_password' => 'required',
            'confirm_password' => 'required | same:new_password'
        ]);
        if ($validator->passes()) {
            $user = User::where('email', $tokenObject->email)->first();
            $user->password = Hash::make($request->new_password);
            $user->save();
            return redirect()->route('login')->with('success', 'You have successfully updated your password');
        } else {
            return redirect()->route('resetPassword', $token)->withErrors($validator);
        }
    }

}
