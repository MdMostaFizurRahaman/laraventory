<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct() {
        $this->middleware('guest:admin', ['except' => ['logout']]);
    }

    public function showLogin() {
        return view('auth.admin.login');
    }

    public function login(Request $request) {
        // Validate the form data
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Attempt to log the user in
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1], $request->remember)) {
            // if successful, then redirect to their intended location
            return redirect()->intended(route('admin.home'));
        }

        // if unsuccessful, then redirect back to the login with the form data
        $errors = ['email' => trans('auth.failed')];
        return redirect()->back()->withInput($request->only('email', 'remember'))->withErrors($errors);
    }

    public function logout() {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
