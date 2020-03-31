<?php

namespace App\Models;

use App\Models\BaseModel as Model;

class BranchProductInventory extends Model {
    protected $fillable = ['client_id', 'branch_id', 'product_id', 'sale_price', 'quantity', 'alert_quantity', 'vat', 'status', 'created_by', 'updated_by', 'deleted_by'];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id')->withTrashed();
    }

    public function branch() {
        return $this->belongsTo(Branch::class, 'branch_id')->withTrashed();
    }
}
