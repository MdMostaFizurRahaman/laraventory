<?php

namespace App\Models;

use App\Models\BaseModel as Model;

class Cost extends Model
{
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function costType()
    {
        return $this->belongsTo(CostType::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function purchase()
    {
        return $this->belongsTo(Purchase::class)->withTrashed();
    }
}
