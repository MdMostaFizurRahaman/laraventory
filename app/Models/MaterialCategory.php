<?php

namespace App\Models;

use App\Traits\HasClientScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialCategory extends Model
{
    use SoftDeletes;
    use HasClientScope;

    protected $guarded = [];
}
