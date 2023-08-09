<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            if(Auth::user()->type == 'admin'){
                return redirect()->route('admin.dashboard');
            }
            if(Session::has('previous_url')){
                $url = Session::get('previous_url');
                Session::forget('previous_url');
                return Redirect::to($url);
            }
            return redirect()->route('fe.home.index');
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->first();
            if($finduser){
                Auth::login($finduser);
                if(Session::has('previous_url')){
                    $url = Session::get('previous_url');
                    Session::forget('previous_url');
                    return Redirect::to($url);
                }
                return redirect()->intended('/');
            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'password' => encrypt('123456dummy'),
                    'type' => 'user',
                ]);
                Auth::login($newUser);
                if(Session::has('previous_url')){
                    $url = Session::get('previous_url');
                    Session::forget('previous_url');
                    return Redirect::to($url);
                }
                return redirect()->intended('/');
            }

        } catch (\Exception $e) {
            dd($e->getMessage());
        }

    }
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('fe.home.index');
    }
}
