<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use App\PermissionGroup;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class RoleController extends Controller
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
    public function index(Request $request,$subdomain)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['read-roles'])) {

            $roles = Role::where([['type', 'client'], ['client_id', Auth::user()->client_id]]);

            if ($request->get('display_name')) {
                $roles->where('display_name', 'LIKE', '%' . $request->get('display_name') . '%');
            }
            $roles = $roles->paginate(10);
            $userRoles = User::where('client_id', Auth::user()->client_id)->pluck('role_id','role_id')->all();

            return view('client.pages.roles.index', compact('roles', 'subdomain','userRoles'));
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-roles'])) {

            $permissionGroups = PermissionGroup::where('type', 'client')->orderBy('name', 'asc')->get();
            return view('client.pages.roles.create', compact('permissionGroups', 'subdomain'));
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
    public function store($subdomain, RoleRequest $request)
    {

        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-roles'])) {

            $input = $request->all();
            $input['user_id'] = Auth::user()->id;
            $input['client_id'] = Auth::user()->client_id;
            $input['name'] = strtolower(Str::slug($input['display_name']));
            $input['type'] = 'client';
            $role = Role::create($input);
            // dd($role);

            if ($request->get('permissions')) {
                $role->permissions()->sync($request->get('permissions'));
            }
            return redirect()->route('roles.index', $subdomain)->with('success', 'Role created successfully');
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
    public function edit($subdomain, $id)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-roles'])) {
            $role = Role::where('id', $id)->where('client_id', Auth::user()->client_id)->where('type', 'client')->first();

            if (is_null($role)) {
                Session::flash('error', 'You Are Unauthorized to access.');
                return redirect()->route('roles.index', $subdomain);
            }
            // dd($role);
            $permissionGroups = PermissionGroup::orderBy('name', 'asc')->get();
            return view('client.pages.roles.edit', compact('role', 'permissionGroups', 'subdomain'));
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
    public function update($subdomain, RoleRequest $request, Role $role)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-roles'])) {

            $role = Role::where('id', $role->id)->where('client_id', Auth::user()->client_id)->where('type', 'client')->first();

            if (is_null($role)) {
                Session::flash('error', 'You Are Unauthorized to access.');
                return redirect()->route('roles.index', $subdomain);
            }
            $input = $request->all();
            $input['user_id'] = Auth::user()->id;
            $role->update($input);

            $role->permissions()->sync($request->get('permissions'));

            return redirect()->route('roles.index', $subdomain)->with('success', 'Role updated successfully');
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
    public function destroy($subdomain, $id)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['delete-roles'])) {

            $role = Role::where('id', $id)->where('client_id', Auth::user()->client_id)->where('type', 'client')->first();

            if (is_null($role)) {
                Session::flash('error', 'You Are Unauthorized to access.');
                return redirect()->route('roles.index', $subdomain);
            }

            if ($role->users()->count() <> 0) {
                Session::flash('warning', 'This role already assign an user, You can not delete now.');
                return redirect()->route('roles.index', $subdomain);
            }

            $role->permissions()->sync([]);
            $role->delete();

            return redirect()->route('roles.index', $subdomain)->with('success', 'Role deleted successfully');
        } else {
            return view('error.client-unauthorized');
        }
    }
}
