<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Role;

class AjaxController extends Controller
{
    /**
     * Return clientwise role.
     */
    public function getClientRoles(Request $request)
    {
        $roles = Role::where('client_id', $request->client_id)->pluck('display_name', 'id');

        $data = '<option value="">Choose an option</option>';
        foreach ($roles as $key => $value) {
            $data .= '<option value="' . $key . '">' . $value . '</option>';
        }
        return $data;
    }
}
