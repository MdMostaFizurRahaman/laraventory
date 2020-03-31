<?php

namespace App\Observers;

use App\Models\Receive;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;

class ReceiveObserver
{
    /**
     * Handle the receive "creating" event.
     *
     * @param  \App\Models\Receive  $receive
     * @return void
     */
    public function creating(Receive $receive)
    {
        $receive->clientId = Auth::user()->clientId;
        $receive->roNumber = Helper::generateNumber(Auth::user()->client->receives()->count() + 1, 'RO');
        $receive->createdBy = Auth::user()->id;
    }

    /**
     * Handle the receive "deleted" event.
     *
     * @param  \App\Models\Receive  $receive
     * @return void
     */
    public function deleting(Receive $receive)
    {
        $receive->deletedBy = Auth::user()->id;
    }

    /**
     * Handle the receive "restored" event.
     *
     * @param  \App\Models\Receive  $receive
     * @return void
     */
    public function restored(Receive $receive)
    {
        //
    }

    /**
     * Handle the receive "force deleted" event.
     *
     * @param  \App\Models\Receive  $receive
     * @return void
     */
    public function forceDeleted(Receive $receive)
    {
        //
    }
}
