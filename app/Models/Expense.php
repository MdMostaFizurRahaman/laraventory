<?php

namespace App\Models;

use App\Models\BaseModel as Model;

class Expense extends Model
{
    protected $guarded = [];


    public function account()
    {
        return $this->belongsTo(Account::class)->withTrashed();
    }


}
