<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PermissionGroup extends Model
{
    protected $guarded = [];

    protected $appends = ['permission_for_update'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_group_permission', 'permission_group_id');
    }

    public function getClientPermissionForUpdateAttribute()
    {
        $used = DB::table('permission_group_permission')->where('permission_group_id', '!=', $this->id)->distinct('permission_id')->pluck('permission_id')->toArray();

        return  Permission::whereNotIn('id' , $used)->where('type', 'client')->get();
    }

    public function getAdminPermissionForUpdateAttribute()
    {
        $used = DB::table('permission_group_permission')->where('permission_group_id', '!=', $this->id)->distinct('permission_id')->pluck('permission_id')->toArray();

        return  Permission::whereNotIn('id' , $used)->where('type', 'admin')->get();
    }
}
