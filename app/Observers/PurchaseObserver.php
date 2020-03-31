<?php

namespace App\Observers;

use App\Models\Purchase;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;

class PurchaseObserver
{
    /**
     * Handle the purchase "created" event.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return void
     */
    public function creating(Purchase $purchase)
    {
        $purchase->poNumber = Helper::generateNumber(Auth::user()->client->purchases()->count() + 1, 'PO');
        $purchase->clientId = Auth::user()->clientId;
        $purchase->createdBy = Auth::user()->id;
    }

    /**
     * Handle the purchase "updated" event.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return void
     */
    public function updating(Purchase $purchase)
    {
        $purchase->updatedBy = Auth::user()->id;
    }

    /**
     * Handle the purchase "deleted" event.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return void
     */
    public function deleting(Purchase $purchase)
    {
        $purchase->deletedBy = Auth::user()->id;
        $purchase->save();
    }

    /**
     * Handle the purchase "restored" event.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return void
     */
    public function restored(Purchase $purchase)
    {
        //
    }

    /**
     * Handle the purchase "force deleted" event.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return void
     */
    public function forceDeleted(Purchase $purchase)
    {
        //
    }
}
