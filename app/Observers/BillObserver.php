<?php

namespace App\Observers;

use App\Models\Bill;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;

class BillObserver
{
    /**
     * Handle the bill "created" event.
     *
     * @param  \App\Model\Bill  $bill
     * @return void
     */
    public function creating(Bill $bill)
    {
        $bill->clientId = Auth::user()->clientId;
        $bill->billNumber = Helper::generateNumber(Auth::user()->client->bills()->count() + 1, 'BL');
        $bill->createdBy = Auth::user()->id;
    }

    /**
     * Handle the bill "updated" event.
     *
     * @param  \App\Model\Bill  $bill
     * @return void
     */
    public function deleting(Bill $bill)
    {
        $bill->deletedBy = Auth::user()->id;
    }
}
