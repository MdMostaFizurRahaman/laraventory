<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $subdomain)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['read-users'])) {

            $users = User::where('client_id', Auth::user()->client_id)->orderBy('name', 'ASC');

            if ($request->get('name')) {
                $users->where('name', 'LIKE', '%' . $request->get('name') . '%');
            }

            if ($request->get('email')) {
                $users->where('email', 'LIKE', '%' . $request->get('email') . '%');
            }

            if ($request->get('mobile')) {
                $users->where('mobile', 'LIKE', '%' . $request->get('mobile') . '%');
            }

            if ($request->get('role_id')) {
                $users->where('role_id',  $request->get('role_id'));
            }

            $users = $users->with('role')->paginate(20);
            $roles = Role::where('client_id', Auth::user()->client_id)->pluck('display_name', 'id')->toArray();
            return view('client.pages.users.index', compact('users', 'roles', 'subdomain'));
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($subdomain)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-users'])) {

            $roles = Role::where('client_id', Auth::user()->client_id)->pluck('display_name', 'id')->toArray();
            return view('client.pages.users.create', compact('subdomain', 'roles'));
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($subdomain, UserRequest $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-users'])) {

            $data = $request->all();
            unset($data['password_confirmation']);

            $data['password'] = bcrypt($request->password);
            $data['user_id'] = Auth::user()->id;
            $data['client_id'] = Auth::user()->client_id;

            if ($request->file('image')) {
                $imagePath = Helper::uploadFile($request->file('image'), null, Config::get('constant.USER_IMAGE'));
                $data['image'] = $imagePath;
            }
            $user = User::create($data);
            $user->attachRole($data['role_id']);
            return redirect()->route('users.index', $subdomain)->with('success', 'User created successfully');
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($subdomain, User $user)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['read-users'])) {
            if (!Helper::idIsAuthorized($user)) {
                return redirect()->route('users.index', $subdomain);
            }

            return view('client.pages.users.show', compact('subdomain', 'user'));
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($subdomain, User $user)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-users'])) {

            if (!Helper::idIsAuthorized($user)) {
                return redirect()->route('users.index', $subdomain);
            }

            $roles = Role::where('client_id', Auth::user()->client_id)->pluck('display_name', 'id')->toArray();
            return view('client.pages.users.edit', compact('subdomain', 'roles', 'user'));
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($subdomain, UserRequest $request, User $user)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-users'])) {

            if (!Helper::idIsAuthorized($user)) {
                return redirect()->route('users.index', $subdomain);
            }

            $data = $request->all();
            if (!$request->has('status')) {
                $data['status'] = 0;
            }
            $data['user_id'] = Auth::user()->id;

            if ($request->file('image')) {
                $imagePath = Helper::uploadFile($request->file('image'), null, Config::get('constant.USER_IMAGE'));
                $data['image'] = $imagePath;
            }

            $user->update($data);
            $user->syncRoles([$request->role_id]);
            return redirect()->route('users.index', $subdomain)->with('success', 'User updated successfully');
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain, User $user)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['delete-users'])) {

            if (!Helper::idIsAuthorized($user)) {
                return redirect()->route('users.index', $subdomain);
            } else if (Auth::user()->id == $user->id) {
                Session::flash('error', 'You cannot delete your own account');
                return redirect()->route('users.index', $subdomain);
            }

            $user->syncRoles([]);
            $user->delete();
            return redirect()->route('users.index', $subdomain)->with('success', 'User deleted successfully');
        } else {
            return view('error.client-unauthorized');
        }
    }


    public function changePassword($subdomain, User $user)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-users'])) {

            if (!Helper::idIsAuthorized($user)) {
                return redirect()->route('users.index', $subdomain);
            }

            return view('client.pages.users.change-password', compact('user', 'subdomain'));
        } else {
            return view('error.client-unauthorized');
        }
    }

    public function changePasswordStore($subdomain, User $user, Request $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-users'])) {

            if (!Helper::idIsAuthorized($user)) {
                return redirect()->route('users.index', $subdomain);
            }

            $this->validate(
                $request,
                [
                    'password' => 'required|min:6|confirmed',
                    'password_confirmation' => 'required|min:6',
                ]
            );

            $data = $request->only('password');
            $data['password'] = bcrypt($request->get('password'));
            $user->update($data);
            return redirect()->route('users.index', $subdomain)->with('success', 'User password changed successfully');
        } else {
            return view('error.client-unauthorized');
        }
    }
}
