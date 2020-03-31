<?php

namespace App\Models;

use App\Currency;
use App\Models\BaseModel as Model;

class Purchase extends Model
{
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchaseMaterials()
    {
        return $this->hasMany(PurchaseMaterial::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function receives()
    {
        return $this->hasMany(Receive::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    /**
     * Get total payment of a purchase
     * @return double
     */

    public function getTotalPaymentAttribute()
    {
        return $this->transactions()->sum('amount');
    }


    /**
     * Get total due of a purchase
     * @return double
     */

    public function getTotalDueAttribute()
    {
        return $this->total - $this->transactions()->sum('amount');
    }

    /**
     * Check purchase can receive
     * @return boolean
     */
    public function isReceivable()
    {
        if($this->status == 3)
        {
            return false;
        }
        return true;
    }

    /**
     * Check purchase can bill
     * @return boolean
     */
    public function isBillable()
    {
        foreach($this->purchaseMaterials as $material)
        {
            if($material->quantity !== $material->billedQuantity)
            {
                return true;
            }
        }

        return false;
    }
}
