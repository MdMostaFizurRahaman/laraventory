<?php

namespace App\Observers;

use App\Models\Production;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;

class ProductionObserver
{
    /**
     * Handle the production "created" event.
     *
     * @param  \App\Models\Production  $production
     * @return void
     */
    public function creating(Production $production)
    {
        $production->productionNumber = Helper::generateNumber(Auth::user()->client->productions()->count() + 1, 'PN');
        $production->clientId = Auth::user() ? Auth::user()->clientId : '0';
        $production->createdBy = Auth::user() ? Auth::user()->id : '0';
    }

    /**
     * Handle the production "updated" event.
     *
     * @param  \App\Models\Production  $production
     * @return void
     */
    public function updating(Production $production)
    {
        $production->updatedBy = Auth::user()->id;
    }

    /**
     * Handle the production "deleted" event.
     *
     * @param  \App\Models\Production  $production
     * @return void
     */
    public function deleted(Production $production)
    {
        $production->deletedBy = Auth::user()->id;
        $production->save();
    }

    /**
     * Handle the production "restored" event.
     *
     * @param  \App\Models\Production  $production
     * @return void
     */
    public function restored(Production $production)
    {
        //
    }

    /**
     * Handle the production "force deleted" event.
     *
     * @param  \App\Models\Production  $production
     * @return void
     */
    public function forceDeleted(Production $production)
    {
        //
    }
}
