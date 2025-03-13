<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\Session;



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
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->passes()) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password); 
            $user->role = 3; 
            $user->save();
    
            session([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'user_role' => $user->role,
            ]);
    
            return response()->json([
                'status' => 'success',
                'message' => 'Registration is successful',
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
        return view('account.dashboard',compact('userDetails', 'userAddress'));
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

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('message', 'You have been logged out successfully.');
    }




}
