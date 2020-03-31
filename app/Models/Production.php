<?php

namespace App\Models;

use App\Models\BaseModel as Model;

class Production extends Model
{
    protected $fillable = ['name', 'client_id', 'production_number', 'quantity', 'production_date', 'finish_date', 'note', 'production_cost', 'status', 'created_by', 'updated_by', 'deleted_by'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productionMaterials()
    {
        return $this->hasMany(ProductionMaterial::class);
    }

    public function batchQuantities()
    {
        return $this->hasMany(BatchQuantity::class, 'production_id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function costs()
    {
        return $this->hasMany(ProductionCost::class);
    }

    /**
     * Calculate total costs of production materials
     * @return double
     */
    public function getMaterialCostAttribute()
    {
        return $this->productionMaterials->sum(function ($material) {
            return $material->quantity * $material->rate;
        });
    }

    /**
     * Calculate total related costs of production
     * @return double
     */
    public function getCostAttribute()
    {
        return $this->costs()->sum('amount');
    }

    /**
     * Calculate total costs of production
     * @return double
     */
    public function getTotalCostAttribute()
    {
        return $this->cost + $this->materialCost;
    }
}
