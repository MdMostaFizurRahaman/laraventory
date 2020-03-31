<?php

namespace App\Observers;

use App\Models\Material;
use Illuminate\Support\Facades\Auth;

class MaterialObserver
{
    /**
     * Handle the material "created" event.
     *
     * @param  \App\Material  $material
     * @return void
     */
    public function creating(Material $material)
    {
        $material->clientId = Auth::user() ? Auth::user()->clientId : '0';
        $material->quantity = $material->openingStock;
        $material->createdBy = Auth::user() ? Auth::user()->id : '0';
    }

    /**
     * Handle the material "updated" event.
     *
     * @param  \App\Material  $material
     * @return void
     */
    public function updating(Material $material)
    {
        $material->updated_by = Auth::user()->id;
    }

    /**
     * Handle the material "deleted" event.
     *
     * @param  \App\Material  $material
     * @return void
     */
    public function deleting(Material $material)
    {
        $material->deleted_by = Auth::user()->id;
        $material->save();
    }

    /**
     * Handle the material "restored" event.
     *
     * @param  \App\Material  $material
     * @return void
     */
    public function restored(Material $material)
    {
        //
    }

    /**
     * Handle the material "force deleted" event.
     *
     * @param  \App\Material  $material
     * @return void
     */
    public function forceDeleted(Material $material)
    {
        //
    }
}
