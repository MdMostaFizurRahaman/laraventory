<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\Admin;
use App\PermissionGroup;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
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
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['read-admins'])) {
            $admins = Admin::orderBy('name', 'ASC');

            if ($request->get('name')) {
                $admins->where('name', 'LIKE', '%' . $request->get('name') . '%');
            }

            if ($request->get('email')) {
                $admins->where('email', 'LIKE', '%' . $request->get('email') . '%');
            }

            if ($request->get('role_id')) {
                $admins->where('role_id', $request->get('role_id'));
            }

            $admins = $admins->with('role')->paginate(50);
            $roles = Role::where('type', 'admin')->pluck('display_name', 'id')->all();
            return view('admin.pages.admins.index', compact('admins', 'roles'));
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
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['create-admins'])) {

            $display = 'none';
            if (old('role_id') && old('role_id') > 1) {
                $display = 'block';
            }
            $permissionGroups = PermissionGroup::where([['status', 1], ['type', 'admin']])->with('permissions')->get();
            $roles = Role::where([['type', 'admin']])->pluck('display_name', 'id')->all();

            return view('admin.pages.admins.create', compact('roles', 'permissionGroups', 'display'));
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
    public function store(Request $request)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['create-admins'])) {
            $messages = [
                'role_id.required' => 'Role field is required',
                'name.required' => 'Name field is required',
                'email.required' => 'Email field is required',
                'email.unique' => 'Email already exists',
                'password.required' => 'Password field is required',
                'password_confirmation.required' => 'Confirm Password field is required',
            ];

            $this->validate($request, [
                'role_id' => 'required',
                'name' => 'required',
                'email' => [
                    'required',
                    Rule::unique('admins', 'email')->whereNull('deleted_at'),
                    'email'
                ],
                'password' => 'required|min:6|confirmed',
                'password_confirmation' => 'required|min:6',
            ], $messages);

            $input = $request->all();

            unset($input['password_confirmation']);

            $input['password'] = bcrypt($request->get('password'));
            $input['user_id'] = Auth::guard('admin')->user()->id;
            $admin = Admin::create($input);

            if ($admin->role_id == 2) {
                if ($request->get('permissions')) {
                    $admin->permissions()->sync($request->get('permissions'));
                }
            }

            $admin->attachRole($input['role_id']);

            Session::flash('success', 'The Admin has been created');

            return redirect()->route('admins.index');
        } else {
            return view('error.unauthorized');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        // if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['read-admins'])) {
        // } else {
        //     return view('error.unauthorized');
        // }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['update-admins'])) {

            $display = 'none';
            if (old('role_id') && old('role_id') > 1 || $admin->role_id > 1) {
                $display = 'block';
            }
            $permissionGroups = PermissionGroup::where([['status', 1], ['type', 'admin']])->with('permissions')->get();
            $roles = Role::where([['type', 'admin']])->pluck('display_name', 'id')->all();

            return view('admin.pages.admins.edit', compact('admin', 'permissionGroups', 'roles', 'display'));
        } else {
            return view('error.unauthorized');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['update-admins'])) {
            $rules = [
                'role_id' => 'required',
                'name' => 'required',
                'email' => [
                    'required',
                    Rule::unique('admins', 'email')->whereNull('deleted_at')->ignore($admin->id),
                    'email'
                ],
            ];

            $messages = [
                'role_id.required' => 'Role field is required',
                'name.required' => 'Name field is required',
                'email.required' => 'Email field is required',
                'email.unique' => 'Email already exists',
            ];

            $this->validate($request, $rules, $messages);

            $input = $request->all();
            if (!$request->has('status')) {
                $input['status'] = 0;
            }
            $input['user_id'] = Auth::guard('admin')->user()->id;

            $admin->update($input);

            if ($admin->role_id == 2) {
                if ($request->get('permissions')) {
                    $admin->permissions()->sync($request->get('permissions'));
                } else {
                    $admin->permissions()->sync([]);
                }
            } else {
                $admin->permissions()->sync([]);
            }

            $admin->syncRoles([$input['role_id']]);

            Session::flash('success', 'The Admin has been updated');
            return redirect()->route('admins.index');
        } else {
            return view('error.unauthorized');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['delete-admins'])) {

            if (Auth::guard('admin')->user()->id == $admin->id) {

                Session::flash('warning', 'You cannot delete your own account');

                return redirect()->route('admins.index');
            } else {
                $admin->update([
                    $input['user_id'] = Auth::guard('admin')->user()->id
                ]);

                $admin->permissions()->sync([]);
                $admin->syncRoles([]);

                $admin->delete();

                Session::flash('success', 'The Admin has been deleted');

                return redirect()->route('admins.index');
            }
        } else {
            return view('error.unauthorized');
        }
    }

    public function changePassword($id)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['update-admins'])) {
            $admin = Admin::findOrFail($id);
            return view('admin.pages.admins.change-password', compact('admin'));
        } else {
            return view('error.unauthorized');
        }
    }

    public function changePasswordStore($id, Request $request)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['update-admins'])) {

            $this->validate(
                $request,
                [
                    'password' => 'required|min:6|confirmed',
                    'password_confirmation' => 'required|min:6',
                ]
            );
            $admin = Admin::findOrFail($id);
            $data = $request->only('password');
            $data['password'] = bcrypt($request->get('password'));
            $admin->update($data);

            return redirect()->route('admins.index')->with('success', 'Admin user password changed successfully');
        } else {
            return view('error.unauthorized');
        }
    }
}
