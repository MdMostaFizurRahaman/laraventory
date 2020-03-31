<?php

namespace App\Observers;
use App\Models\BranchProductInventory;
use Illuminate\Support\Facades\Auth;

class BranchProductInventoryObserver {
    /**
     * Handle the branch "created" event.
     *
     * @param  \App\Models\BranchProductInventory $branchProductInventory
     * @return void
     */
    public function creating(BranchProductInventory $branchProductInventory) {
        $branchProductInventory->client_id = Auth::user()->client_id;
        $branchProductInventory->created_by = Auth::user()->id;
    }

    /**
     * Handle the branch "updated" event.
     *
     * @param  \App\Models\BranchProductInventory $branchProductInventory
     * @return void
     */
    public function updating(BranchProductInventory $branchProductInventory) {
        $branchProductInventory->updated_by = Auth::user()->id;
    }

    /**
     * Handle the branch "deleted" event.
     *
     * @param  \App\Models\BranchProductInventory $branchProductInventory
     * @return void
     */
    public function deleting(BranchProductInventory $branchProductInventory) {
        $branchProductInventory->deleted_by = Auth::user()->id;
        $branchProductInventory->save();
    }

    /**
     * Handle the branch "restored" event.
     *
     * @param  \App\Models\BranchProductInventory $branchProductInventory
     * @return void
     */
    public function restored(BranchProductInventory $branchProductInventory) {
        //
    }

    /**
     * Handle the branch "force deleted" event.
     *
     * @param  \App\Models\BranchProductInventory $branchProductInventory
     * @return void
     */
    public function forceDeleted(BranchProductInventory $branchProductInventory) {
        //
    }
}
