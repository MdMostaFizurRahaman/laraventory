<?php

namespace App\Models;

use App\User;
use App\Models\BaseModel as Model;

class ProductTransfer extends Model
{
    protected $fillable = ['pt_number', 'client_id', 'branch_id', 'processing_date', 'process_completed_date', 'expected_receive_date', 'received_date', 'received_by', 'note', 'rejection_note', 'rejected_by', 'status', 'created_by', 'updated_by', 'deleted_by'];

    public function branch()
    {
        return $this->belongsTo(Branch::class)->withTrashed();
    }
    public function receivedBy()
    {
        return $this->belongsTo(User::class, 'received_by')->withTrashed();
    }
    public function rejectedBy()
    {
        return $this->belongsTo(User::class, 'rejected_by')->withTrashed();
    }
    public function productTransferItems()
    {
        return $this->hasMany(ProductTransferItem::class, 'product_transfer_id');
    }

}
