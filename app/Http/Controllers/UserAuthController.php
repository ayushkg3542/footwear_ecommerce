<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\UserAddress;
use Auth;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;


class UserAuthController extends Controller
{
    public function getLogin(){
        return view('account.login');
    }

    public function authenticate(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required'
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('account.login')->withErrors($validator)->withInput($request->only('name'));
        }
    
        $users = User::where('name', $request->name)->first();
    
        if ($users) {
            if (Auth::attempt(['name' => $request->name, 'password' => $request->password]) && $users->role == 3) {
    
                Session::flash('message', 'You are successfully logged in');
                Session::flash('alert-type', 'success');
    
                return redirect()->route('account.dashboard');
            } else {
                return redirect()->route('account.login')
                                 ->withErrors(['password' => 'The provided password is incorrect.'])
                                 ->withInput($request->only('name'));
            }
        } else {
            return redirect()->route('account.login')
                             ->withErrors(['name' => 'No account found with this name.'])
                             ->withInput($request->only('name'));
        }
    }

    public function getRegister(){
        return view('account.register');
    }

    public function processSignup(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->passes()) {
            $verificationToken = Str::random(64);

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = bcrypt($request->password); 
            $user->role = 3; 
            $user->remember_token = $verificationToken;
            $user->save();

            Mail::to($user->email)->send(new \App\Mail\VerifyEmail($user));
    
            session([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'user_phone' => $user->phone,
                'user_role' => $user->role,
            ]);
    
            return response()->json([
                'status' => 'success',
                'message' => 'Registration is successful! Please verify your email.',
                'registerid' => $user->id,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle Google Callback
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            // dd($googleUser); 

            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                $user = User::create([
                    'name'     => $googleUser->getName(),
                    'email'    => $googleUser->getEmail(),
                    'password' => bcrypt(str()->random(16)),
                    'role' => 3
                ]);
            }

            Auth::login($user);

            return redirect('/account/dashboard');

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }


    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();

            $user = User::where('email', $facebookUser->getEmail())->first();

            if (!$user) {
               
                $user = User::create([
                    'name'     => $facebookUser->getName(),
                    'email'    => $facebookUser->getEmail(),
                    'password' => bcrypt(str()->random(16)), 
                    'role'     => 3, 
                ]);
            }

            Auth::login($user);

            return redirect('/account/dashboard'); 

        } catch (Exception $e) {
            return redirect('/account/login')->with('error', 'Facebook login failed: ' . $e->getMessage());
        }
    }

    public function dashboard(Request $request){
        $userDetails = Auth::user();
        $userAddress = $userDetails->address;

        $orders = Orders::where('user_id', $userDetails->id)
        ->with(['orderItems.product.images']) 
        ->orderBy('created_at', 'desc')
        ->get();
        // dd($orders);
        return view('account.dashboard',compact('userDetails', 'userAddress','orders'));
    }


    public function updateProfile(Request $request)
    {
        // dd($request->all());
        // die();
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|digits:10',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'gender' => 'required|in:Male,Female',
        ]);


        $user = Auth::user();
        // dd($request->all(), $user);
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'gender' => $request->gender,
        ]);
        // dd($user);

        return response()->json(['success' => true, 'message' => 'Profile updated successfully']);
    }

    public function updateAddress(Request $request)
    {
        $request->validate([
            'street' => 'required|string|max:255',
            'pincode' => 'required|digits:6',
            'locality' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
        ]);

        $user = Auth::user();
        $address = UserAddress::updateOrCreate(
            ['user_id' => $user->id],
            [
                'address' => $request->street,
                'pincode' => $request->pincode,
                'locality' => $request->locality,
                'city' => $request->city,
                'state' => $request->state,
            ]
        );

        return response()->json(['success'=> true,'message' => 'Address updated successfully']);
    }

    public function verifyEmail($token){
        $user = User::where('remember_token', $token)->first();

        if(!$user){
            return "Invalid or expired verification link.";
        }

        $user->email_verified_at = now();
        $user->remember_token = null;
        $user->save();

        return redirect()->route('home')->with('message','Email verified successfully! You can now log in.');
    }

    public function forgetPassword(){
        return view('account.forgetPassword');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('message', 'You have been logged out successfully.');
    }

// 


}
