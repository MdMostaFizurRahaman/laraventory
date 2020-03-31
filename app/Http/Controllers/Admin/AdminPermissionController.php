<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPermissionRequest;
use App\PermissionGroup;
use Illuminate\Support\Facades\DB;
use App\Permission;
use Illuminate\Support\Facades\Auth;

class AdminPermissionController extends Controller
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
    public function index()
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['read-admin-permissions'])) {

            $permissions = PermissionGroup::where('type', 'admin')->where('status', true)->paginate(20);
            return view('admin.pages.admin-permissions.index', compact('permissions'));
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
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['create-admin-permissions'])) {

            $used = DB::table('permission_group_permission')->distinct('permission_id')->pluck('permission_id')->toArray();
            $permissions = Permission::whereNotIn('id', $used)->where('type', 'admin')->get();
            return view('admin.pages.admin-permissions.create', compact('permissions'));
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
    public function store(AdminPermissionRequest $request)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['create-admin-permissions'])) {

            $permission = PermissionGroup::create([
                'name' => $request->name,
                'description' => $request->description,
                'status' => $request->status ? 1 : 0,
                'type' => 'admin'
            ]);
            $permission->permissions()->sync($request->permissions);
            return redirect()->route('admin-permissions.index')->with('success', 'Permission group created successfully');
        } else {
            return view('error.unauthorized');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(PermissionGroup $admin_permission)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['update-admin-permissions'])) {
            $permission = $admin_permission;
            return view('admin.pages.admin-permissions.edit', compact('permission'));
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
    public function update(AdminPermissionRequest $request, PermissionGroup $admin_permission)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['update-admin-permissions'])) {

            $admin_permission->update([
                'name' => $request->name,
                'description' => $request->description,
                'status' => $request->status ? 1 : 0,
            ]);

            $admin_permission->permissions()->sync($request->permissions);
            return redirect()->route('admin-permissions.index')->with('success', 'Permission group updated successfully');
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
    public function destroy(PermissionGroup $admin_permission)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['delete-admin-permissions'])) {

            $admin_permission->permissions()->sync([]);
            $admin_permission->delete();
            return redirect()->route('admin-permissions.index')->with('success', 'Permission group deleted successfully');
        } else {
            return view('error.unauthorized');
        }
    }
}
