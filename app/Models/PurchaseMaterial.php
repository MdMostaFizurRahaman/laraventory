<?php

namespace App\Models;

use App\Traits\HasClientScope;
use Eloquence\Behaviours\CamelCasing;
use Illuminate\Database\Eloquent\Model;

class PurchaseMaterial extends Model
{
    use CamelCasing;
    use HasClientScope;

    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productionMaterials()
    {
        return $this->hasMany(ProductionMaterial::class, 'purchase_material_id');
    }

    /**
     * Get total production quantity of the purchase material
     *
     * @return double
     */
    public function getPurchaseProductionQuantityAttribute()
    {
        return $this->productionMaterials()->sum('quantity');
    }

    /**
     * Get purchase item remaining quantity after adding to production
     *
     * @return double
     */
    public function getRemainingQuantityAttribute()
    {
        return $this->receivedQuantity - $this->productionMaterials()->sum('quantity');
    }

    /**
     * @return string
     */
    public function getUnitAttribute()
    {
        return $this->material->unit->name;
    }


    /**
     * Get dropdown options
     *
     * @return array
     */
    public static function productionMaterialDropdown()
    {
        $materials =  self::get();

        $materials = $materials->filter(function ($value, $key) {
            return $value->remainingQuantity > 0;
        });

        return $materials->mapWithKeys(function ($material) {
            return [$material->id => $material->purchase->poNumber . "-" . $material->material->name . "-" . $material->remainingQuantity . "-" . $material->unit,];
        })->toArray();
    }
}
