<?php

namespace App\Models;

use App\Bank;
use App\Models\BaseModel as Model;
use Illuminate\Support\Facades\Auth;

class Account extends Model
{
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function transaction()
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }

    /**
     * Scope by Client id
     * @param $query
     * @return mixed
     */
    public function scopeClient($query)
    {
        return $query->where('client_id', Auth::user()->clientId);
    }
}
