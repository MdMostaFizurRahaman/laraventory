<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Role;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientUserRequest;
use Illuminate\Http\Request;

class ClientUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['read-client-users'])) {

            $users = User::orderBy('name', 'ASC');

            if ($request->get('name')) {
                $users->where('name', 'LIKE', '%' . $request->get('name') . '%');
            }

            if ($request->get('email')) {
                $users->where('email', 'LIKE', '%' . $request->get('email') . '%');
            }

            if ($request->get('client_id')) {
                $users->where('client_id',  $request->get('client_id'));
                $roles = Role::where([['type', 'client'], ['client_id', $request->get('client_id')]])->pluck('display_name', 'id')->all();
            } else {
                $roles = [];
            }

            if ($request->get('role_id')) {
                $users->where('role_id',  $request->get('role_id'));
            }

            $users = $users->with('client', 'role')->paginate(50);

            $clients = Client::orderBy('created_at', 'DESC')->pluck('name', 'id')->all();

            return view('admin.pages.client-users.index', compact('users', 'clients', 'roles'));
        } else {
            return view('error.unauthorized');
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['create-client-users'])) {

            $clients = Client::where('status', 1)->orderBy('created_at', 'DESC')->pluck('name', 'id')->all();
            $roles = [];

            if (old('client_id')) {
                $roles = Role::where([['type', 'client'], ['client_id', old('client_id')]])->pluck('display_name', 'id')->all();
            }

            return view('admin.pages.client-users.create', compact('clients', 'roles'));
        } else {
            return view('error.unauthorized');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientUserRequest $request)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['create-client-users'])) {

            $data = $request->all();
            unset($data['password_confirmation']);
            $data['password'] = bcrypt($request->get('password'));
            $user = User::create($data);
            $user->attachRole($data['role_id']);
            return redirect()->route('client-users.index')->with('success', 'Client user created successfully');
        } else {
            return view('error.unauthorized');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $client_user)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['update-client-users'])) {

            $roles = Role::where([['type', 'client'], ['client_id', $client_user->client_id]])->pluck('display_name', 'id')->all();

            return view('admin.pages.client-users.edit', compact('roles'))->with('user', $client_user);
        } else {
            return view('error.unauthorized');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClientUserRequest $request, User $client_user)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['update-client-users'])) {

            $data = $request->all();
            if (!$request->has('status')) {
                $data['status'] = 0;
            }
            $client_user->update($data);
            $client_user->syncRoles([$data['role_id']]);
            return redirect()->route('client-users.index')->with('success', 'Client user updated successfully');
        } else {
            return view('error.unauthorized');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $client_user)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['delete-client-users'])) {

            $client_user->delete();
            return redirect()->route('client-users.index')->with('success', 'Client user deleted successfully');
        } else {
            return view('error.unauthorized');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function changePassword(User $user)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['update-client-users'])) {

            return view('admin.pages.client-users.change-password', compact('user'));
        } else {
            return view('error.unauthorized');
        }
    }

    public function changePasswordStore(User $user, Request $request)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['update-client-users'])) {

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

            return redirect()->route('client-users.index')->with('success', 'Client user password changed successfully');
        } else {
            return view('error.unauthorized');
        }
    }
}
