<?php

namespace App\Models;

use App\Traits\HasClient;
use App\Traits\HasClientScope;
use Eloquence\Behaviours\CamelCasing;
use Illuminate\Database\Eloquent\Model;

class ProductionCost extends Model
{
    use HasClientScope, CamelCasing, HasClient;

    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(ProductionCostCategory::class, 'category_id');
    }
}
