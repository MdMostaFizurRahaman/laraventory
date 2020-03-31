<?php

namespace App\Observers;

use App\Http\Requests\ExpenseRequest;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;

class ExpenseObserver
{
    /**
     * Handle the expense "creating" event.
     *
     * @param  \App\Models\Expense  $expense
     * @return void
     */
    public function creating(Expense $expense)
    {
        $expense->clientId = Auth::user()->clientId;
        $expense->createdBy = Auth::user()->id;
    }

    /**
     * Handle the expense "updated" event.
     *
     * @param  \App\Models\Expense  $expense
     * @return void
     */
    public function updating(Expense $expense)
    {
        $expense->updatedBy = Auth::user()->id;
    }

    /**
     * Handle the expense "deleted" event.
     *
     * @param  \App\Models\Expense  $expense
     * @return void
     */
    public function deleting(Expense $expense)
    {
        $expense->deletedBy = Auth::user()->id;
        $expense->save();
    }

    /**
     * Handle the expense "restored" event.
     *
     * @param  \App\Models\Expense  $expense
     * @return void
     */
    public function restored(Expense $expense)
    {
        //
    }

    /**
     * Handle the expense "force deleted" event.
     *
     * @param  \App\Models\Expense  $expense
     * @return void
     */
    public function forceDeleted(Expense $expense)
    {
        //
    }
}
