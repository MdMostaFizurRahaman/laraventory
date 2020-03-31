<?php

namespace App\Models;

use App\Traits\HasClientScope;
use Eloquence\Behaviours\CamelCasing;
use Illuminate\Database\Eloquent\Model;

class ProductionMaterial extends Model
{
    use CamelCasing;
    use HasClientScope;

    protected $guarded = [];


    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function getTotalAttribute()
    {
        return $this->rate * $this->quantity;
    }
}
