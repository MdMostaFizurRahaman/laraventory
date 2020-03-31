<?php

namespace App\Models;

use App\User;
use App\Models\BaseModel as Model;

class Branch extends Model
{

    protected $guarded = [];


    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'branch_users', 'user_id', 'branch_id');
    }
}
