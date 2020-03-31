<?php

namespace App\Observers;

use App\Models\Account;
use Illuminate\Support\Facades\Auth;

class AccountObserver
{
    /**
     * Handle the account "created" event.
     *
     * @param  \App\Models\Account  $account
     * @return void
     */
    public function creating(Account $account)
    {
        $account->clientId = Auth::user() ? Auth::user()->clientId : '0';
        $account->balance = $account->openingBalance;
        $account->createdBy = Auth::user() ? Auth::user()->id : '0';
    }

    /**
     * Handle the account "updated" event.
     *
     * @param  \App\Models\Account  $account
     * @return void
     */
    public function updating(Account $account)
    {
        $account->updatedBy = Auth::user()->id;
    }

    /**
     * Handle the account "deleted" event.
     *
     * @param  \App\Models\Account  $account
     * @return void
     */
    public function deleting(Account $account)
    {

        $account->deletedBy = Auth::user()->id;
        $account->save();
    }

    /**
     * Handle the account "restored" event.
     *
     * @param  \App\Models\Account  $account
     * @return void
     */
    public function restored(Account $account)
    {
        //
    }

    /**
     * Handle the account "force deleted" event.
     *
     * @param  \App\Models\Account  $account
     * @return void
     */
    public function forceDeleted(Account $account)
    {
        //
    }
}
