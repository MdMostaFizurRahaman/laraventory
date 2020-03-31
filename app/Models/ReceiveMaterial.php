<?php

namespace App\Models;

use App\Models\Material;
use App\Models\PurchaseMaterial;
use App\Traits\HasClientScope;
use Eloquence\Behaviours\CamelCasing;
use Illuminate\Database\Eloquent\Model;

class ReceiveMaterial extends Model
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
    public function purchaseMaterial()
    {
        return $this->belongsTo(PurchaseMaterial::class, 'purchase_material_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function receive()
    {
        return $this->belongsTo(Receive::class);
    }
}
