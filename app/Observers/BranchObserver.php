<?php

namespace App\Observers;

use App\Models\Branch;
use Illuminate\Support\Facades\Auth;

class BranchObserver
{
    /**
     * Handle the branch "created" event.
     *
     * @param  \App\Branch  $branch
     * @return void
     */
    public function creating(Branch $branch)
    {
        $branch->clientId = Auth::user()->clientId;
        $branch->createdBy = Auth::user()->id;
    }

    /**
     * Handle the branch "updated" event.
     *
     * @param  \App\Branch  $branch
     * @return void
     */
    public function updating(Branch $branch)
    {
        $branch->updatedBy = Auth::user()->id;
    }

    /**
     * Handle the branch "deleted" event.
     *
     * @param  \App\Branch  $branch
     * @return void
     */
    public function deleting(Branch $branch)
    {
        $branch->deleted_by = Auth::user()->id;
        $branch->save();
    }

    /**
     * Handle the branch "restored" event.
     *
     * @param  \App\Branch  $branch
     * @return void
     */
    public function restored(Branch $branch)
    {
        //
    }

    /**
     * Handle the branch "force deleted" event.
     *
     * @param  \App\Branch  $branch
     * @return void
     */
    public function forceDeleted(Branch $branch)
    {
        //
    }
}
