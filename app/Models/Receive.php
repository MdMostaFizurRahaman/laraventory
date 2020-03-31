<?php

namespace App\Models;

use App\Models\ReceiveMaterial;
use App\Models\BaseModel as Model;

class Receive extends Model
{
    protected $guarded = [];

    public function receiveMaterials()
    {
        return $this->hasMany(ReceiveMaterial::class);
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}
