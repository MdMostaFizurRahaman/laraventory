<?php

namespace App\Observers;

use App\Models\BranchUser;
use Illuminate\Support\Facades\Auth;

class BranchUserObserver
{
    /**
     * Handle the branch user "created" event.
     *
     * @param  App\Models\BranchUser  $branchUser
     * @return void
     */
    public function creating(BranchUser $branchUser)
    {
        $branchUser->client_id = Auth::user()->client_id;
        $branchUser->action_by = Auth::user()->id;
    }

    /**
     * Handle the branch user "updated" event.
     *
     * @param  App\Models\BranchUser  $branchUser
     * @return void
     */
    public function updating(BranchUser $branchUser)
    {
        $branchUser->action_by = Auth::user()->id;
    }

    /**
     * Handle the branch user "deleted" event.
     *
     * @param  App\Models\BranchUser  $branchUser
     * @return void
     */
    public function deleting(BranchUser $branchUser)
    {
        $branchUser->action_by = Auth::user()->id;
    }

    /**
     * Handle the branch user "restored" event.
     *
     * @param  App\Models\BranchUser  $branchUser
     * @return void
     */
    public function restored(BranchUser $branchUser)
    {
        //
    }

    /**
     * Handle the branch user "force deleted" event.
     *
     * @param  App\Models\BranchUser  $branchUser
     * @return void
     */
    public function forceDeleted(BranchUser $branchUser)
    {
        //
    }
}
