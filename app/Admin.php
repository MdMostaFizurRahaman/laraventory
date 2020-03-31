<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable, SoftDeletes, LaratrustUserTrait;

    protected $fillable = [
        'user_id', 'name', 'email', 'password', 'status', 'email_verified_at', 'role_id'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
