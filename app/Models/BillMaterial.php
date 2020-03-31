<?php

namespace App\Models;

use App\Traits\HasClientScope;
use Illuminate\Database\Eloquent\Model;

class BillMaterial extends Model
{

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
   public function purchaseMaterial()
   {
       return $this->belongsTo(PurchaseMaterial::class, 'purchase_material_id');
   }
}
