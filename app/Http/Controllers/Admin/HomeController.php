<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function index()
    {
        return view('admin.home');
    }

    public function password()
    {
        return view('admin.change-password');
    }

    public function passwordUpdate(Request $request)
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
            'old_password' => 'required|old_password:' . Auth::guard('admin')->user()->password,
            'password' => 'required|confirmed|min:6|max:255',
        ], $messages);

        $admin = Auth::guard('admin')->user();

        $admin['password'] = bcrypt($request->get('password'));

        $admin->save();

        Session::flash('success', 'Your password has been updated');

        return redirect()->route('admin.editPassword');
    }
}
