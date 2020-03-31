<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['logout']]);
    }

    public function showLogin($subdomain)
    {
        $client = Client::where([['status', 1], ['client_url', $subdomain]])->first();
        return view('auth.login', compact('subdomain', 'client'));
        // return view('auth.login', compact('subdomain'));
    }

    public function login($subdomain, Request $request)
    {
        // Validate the form data
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);


        $client = Client::where([['status', 1], ['client_url', $subdomain]])->first();
        if ($client) {
            // Attempt to log the user in
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1, 'client_id' => $client->id], $request->remember)) {
                // if successful, then redirect to their intended location
                return redirect()->intended(route('client.home', $subdomain));
            }

            // if unsuccessful, then redirect back to the login with the form data
            $errors = ['email' => trans('auth.failed')];
            return redirect()->back()->withInput($request->only('email', 'remember'))->withErrors($errors);
        } else {
            return view('error.client-unauthorized');
        }
    }

    public function logout($subdomain)
    {
        Auth::logout();
        return redirect()->route('client.login', $subdomain);
    }
}
