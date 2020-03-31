<?php

namespace App\Observers;

use App\Helpers\Helper;
use App\Models\ProductTransfer;
use Illuminate\Support\Facades\Auth;

class ProductTransferObserver
{
    /**
     * Handle the product transfer "created" event.
     *
     * @param  \App\Models\ProductTransfer  $productTransfer
     * @return void
     */
    public function creating(ProductTransfer $productTransfer)
    {
        $productTransfer->pt_number = Helper::generateNumber(Auth::user()->client->productTransfers()->count() + 1, 'PT');
        $productTransfer->client_id = Auth::user()->client_id;
        $productTransfer->created_by = Auth::user()->id;
    }

    /**
     * Handle the product transfer "updated" event.
     *
     * @param  \App\Models\ProductTransfer  $productTransfer
     * @return void
     */
    public function updating(ProductTransfer $productTransfer)
    {
        $productTransfer->updated_by = Auth::user()->id;
    }

    /**
     * Handle the product transfer "deleted" event.
     *
     * @param  \App\Models\ProductTransfer  $productTransfer
     * @return void
     */
    public function deleting(ProductTransfer $productTransfer)
    {
        $productTransfer->deleted_by = Auth::user()->id;
        $productTransfer->save();
    }

    /**
     * Handle the product transfer "restored" event.
     *
     * @param  \App\Models\ProductTransfer  $productTransfer
     * @return void
     */
    public function restored(ProductTransfer $productTransfer)
    {
        //
    }

    /**
     * Handle the product transfer "force deleted" event.
     *
     * @param  \App\Models\ProductTransfer  $productTransfer
     * @return void
     */
    public function forceDeleted(ProductTransfer $productTransfer)
    {
        //
    }
}
