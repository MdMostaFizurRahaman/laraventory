<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductObserver
{
    /**
     * Handle the product "creating" event.
     *
     * @param  \App\Product  $product
     * @return void
     */
    public function creating(Product $product)
    {
        $product->clientId = Auth::user()->clientId;
        $product->quantity = $product->openingQuantity ?? 0;
        $product->created_by = Auth::user()->id;
    }

    /**
     * Handle the product "updating" event.
     *
     * @param  \App\Product  $product
     * @return void
     */
    public function updating(Product $product)
    {
        $product->updated_by = Auth::user()->id;
    }

    /**
     * Handle the product "deleted" event.
     *
     * @param  \App\Product  $product
     * @return void
     */
    public function deleted(Product $product)
    {
        $product->deleted_by = Auth::user()->id;
        $product->save();
    }

    /**
     * Handle the product "restored" event.
     *
     * @param  \App\Product  $product
     * @return void
     */
    public function restored(Product $product)
    {
        //
    }

    /**
     * Handle the product "force deleted" event.
     *
     * @param  \App\Product  $product
     * @return void
     */
    public function forceDeleted(Product $product)
    {
        //
    }
}
