<?php

namespace App;

use App\Traits\HasClientScope;
use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    protected $fillable = [
        'name', 'display_name', 'description', 'type', 'user_id', 'client_id'
    ];
}
