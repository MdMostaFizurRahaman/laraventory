<?php

namespace App\Providers;

use App\Models\Account;
use App\Models\Bill;
use App\Models\Branch;
use App\Models\BranchProductInventory;
use App\Models\BranchUser;
use App\Models\Expense;
use App\Models\Material;
use App\Models\Product;
use App\Models\Production;
use App\Models\ProductTransfer;
use App\Models\Purchase;
use App\Models\Receive;
use App\Observers\AccountObserver;
use App\Observers\BillObserver;
use App\Observers\BranchObserver;
use App\Observers\BranchProductInventoryObserver;
use App\Observers\BranchUserObserver;
use App\Observers\ExpenseObserver;
use App\Observers\MaterialObserver;
use App\Observers\ProductionObserver;
use App\Observers\ProductObserver;
use App\Observers\ProductTransferObserver;
use App\Observers\PurchaseObserver;
use App\Observers\ReceiveObserver;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        //For old password Check
        Validator::extend('old_password', function ($attribute, $value, $parameters, $validator) {
            return Hash::check($value, current($parameters));
        });

        Schema::defaultStringLength(191);
        Material::observe(MaterialObserver::class);
        Product::observe(ProductObserver::class);
        Branch::observe(BranchObserver::class);
        Account::observe(AccountObserver::class);
        Expense::observe(ExpenseObserver::class);
        Purchase::observe(PurchaseObserver::class);
        Receive::observe(ReceiveObserver::class);
        Bill::observe(BillObserver::class);
        Production::observe(ProductionObserver::class);
        BranchUser::observe(BranchUserObserver::class);
        ProductTransfer::observe(ProductTransferObserver::class);
        BranchProductInventory::observe(BranchProductInventoryObserver::class);
    }
}
