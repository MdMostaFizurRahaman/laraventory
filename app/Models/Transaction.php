<?php

namespace App\Models;

use App\Models\BaseModel as Model;

class Transaction extends Model
{
    public function transactionable()
    {
        return $this->morphTo();
    }
}
