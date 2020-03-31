<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($subdomain)
    {
        return view('client.home', compact('subdomain'));
    }

    public function password($subdomain)
    {
        return view('client.change-password', compact('subdomain'));
    }

    public function passwordUpdate($subdomain, Request $request)
    {
        $messages = [
            'old_password.required' => 'Current password is required',
            'old_password.old_password' => 'Current password is wrong',
            'password.required' => 'New Password is required',
            'password.confirmed' => 'New Passwords does not match',
            'password.min' => 'New Password must be at least 6 char long',
            'password.max' => 'New Password can be maximum 200 char long',
        ];

        $this->validate($request, [
            'old_password' => 'required|old_password:' . Auth::user()->password,
            'password' => 'required|confirmed|min:6|max:255',
        ], $messages);

        $client = Auth::user();

        $client['password'] = bcrypt($request->get('password'));

        $client->save();

        Session::flash('success', 'Your password has been updated');

        return redirect()->route('client.editPassword', $subdomain);
    }
}
