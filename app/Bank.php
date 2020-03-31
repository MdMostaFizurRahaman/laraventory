<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'address', 'deleted_at'
    ];

    // public function accounts()
    // {
    //     return $this->hasMany(Account::class, 'bank_id', 'id');
    // }
}
