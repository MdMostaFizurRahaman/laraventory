<?php

namespace App\Models;

use App\User;
use App\Traits\HasClientScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BranchUser extends Model
{
    use HasClientScope, SoftDeletes;
    protected $fillable = [
        'client_id', 'branch_id', 'user_id', 'action_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }
}
