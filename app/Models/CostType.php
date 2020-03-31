<?php

namespace App\Models;

use App\Traits\HasClientScope;
use Illuminate\Database\Eloquent\Model;

class CostType extends Model
{
    use HasClientScope;

    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function costs()
    {
        return $this->hasMany(Cost::class);
    }
}
