<?php

namespace App\Models;

use App\Traits\HasClientScope;
use Illuminate\Database\Eloquent\Model;

class TransactionCategory extends Model
{
    use HasClientScope;

    protected $guarded  = [];
}
