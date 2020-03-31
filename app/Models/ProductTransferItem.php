<?php

namespace App\Models;

use App\Traits\HasClientScope;
use App\User;
use Illuminate\Database\Eloquent\Model;

class ProductTransferItem extends Model {
    use HasClientScope;

    protected $fillable = ['client_id', 'product_transfer_id', 'product_id', 'quantity', 'rate', 'total', 'received_quantity', 'created_by'];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id')->withTrashed();
    }

    public function createdBy() {
        return $this->belongsTo(User::class, 'created_by')->withTrashed();
    }
}
