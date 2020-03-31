<?php

namespace App\Models;

use App\Traits\HasClientScope;
use Illuminate\Database\Eloquent\Model;

class ProductionCostCategory extends Model
{
    use HasClientScope;

    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productionCosts()
    {
        return $this->hasMany(ProductionCost::class, 'category_id');
    }

}
