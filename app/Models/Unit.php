<?php

namespace App\Models;

use App\Traits\HasClientScope;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    // use SoftDeletes;
    // use HasClientScope;

    protected $guarded = [];


    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
