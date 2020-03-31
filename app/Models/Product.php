<?php

namespace App\Models;

use App\Currency;
use App\Models\BaseModel as Model;

class Product extends Model {
    protected $fillable = ['name', 'client_id', 'code', 'image', 'sale_price', 'description', 'quantity', 'batch_quantity', 'opening_quantity', 'alert_quantity', 'vat', 'unit_id', 'category_id', 'currency_id', 'created_by', 'updated_by', 'deleted_by', 'is_numeric'];

    protected $append = [
        'image_full_url',
    ];

    public function category() {
        return $this->belongsTo(ProductCategory::class);
    }

    public function unit() {
        return $this->belongsTo(Unit::class);
    }

    // public function getImageFullUrlAttribute()
    // {
    //     return 'storage/'.$this->image;
    // }

    public function getNameCodeAttribute() {
        //name_code
        return $this->name . ' [' . $this->code . ']';
    }

    public function getNameCodeBatchQuantityAttribute() {
        //name_code_batch_quantity
        return $this->name . ' [' . $this->code . '][' . $this->batch_quantity . ']';
    }

    public function getCategoryNameAttribute() {
        //category_name
        return $this->category() ? $this->category->name : '';
    }

    public function currency() {
        return $this->belongsTo(Currency::class);
    }
}
