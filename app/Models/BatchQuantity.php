<?php

namespace App\Models;

use App\User;
use App\Models\Product;
use App\Models\Production;
use App\Traits\HasClientScope;
use Illuminate\Database\Eloquent\Model;

class BatchQuantity extends Model
{
    use HasClientScope;

    protected $fillable = ['client_id', 'production_id', 'product_id', 'input_quantity', 'batch_quantity', 'created_by', 'product_quantity'];

    public function production()
    {
        return $this->belongsTo(Production::class, 'production_id')->withTrashed();
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id')->withTrashed();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->withTrashed();
    }
}
