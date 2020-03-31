<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

use Illuminate\Support\Facades\Route;

//Main Domain Access Deny
Route::domain(env('APP_DOMAIN_URL'))->group(function () {
    Route::any('/', function () {
        return view('error.unauthorized');
    });
});

Route::domain('admin.' . env('APP_DOMAIN_URL'))->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.home');
    });

    Route::group(['namespace' => 'Admin'], function () {
        Route::get('home', 'HomeController@index')->name('admin.home');
        Route::get('login', 'LoginController@showLogin')->name('admin.login');
        Route::post('login', 'LoginController@login')->name('admin.login.submit');
        Route::post('logout', 'LoginController@logout')->name('admin.logout');
        Route::get('editPassword', 'HomeController@password')->name('admin.editPassword');
        Route::post('editPassword', 'HomeController@passwordUpdate')->name('admin.passwordUpdate');

        Route::get('admins/change-password/{id}', 'AdminController@changePassword')->name('admins.change.password');
        Route::patch('admins/change-password/{id}', 'AdminController@changePasswordStore');
        Route::resource('admins', 'AdminController');
        Route::resource('permissions', 'PermissionController');
        Route::resource('admin-permissions', 'AdminPermissionController');
        Route::resource('clients', 'ClientController');
        Route::resource('client-users', 'ClientUserController');
        Route::get('client-users/change-password/{user}', 'ClientUserController@changePassword')->name('client-users.change.password');
        Route::patch('client-users/change-password/{user}', 'ClientUserController@changePasswordStore')->name('client-users.change.password.store');
        Route::post('getClientRoles', 'AjaxController@getClientRoles')->name('client.roles');
        //Bank
        Route::resource('banks', 'BankController');
        //Currency
        Route::resource('currencies', 'CurrencyController');
    });
});

Route::domain('{subdomain}.' . env('APP_DOMAIN_URL'))->group(function () {
    Route::get('/', function ($subdomain) {
        return redirect()->route('client.home', $subdomain);
    });

    Route::get('login', 'LoginController@showLogin')->name('client.login');
    Route::post('login', 'LoginController@login')->name('login.submit');
    Route::post('logout', 'LoginController@logout')->name('logout');
    Route::get('editPassword', 'HomeController@password')->name('client.editPassword');
    Route::post('editPassword', 'HomeController@passwordUpdate')->name('client.passwordUpdate');
    Route::get('home', 'HomeController@index')->name('client.home');

    Route::resource('material-categories', 'MaterialCategoryController');
    Route::resource('product-categories', 'ProductCategoryController');
    Route::resource('materials', 'MaterialController');
    Route::resource('products', 'ProductController');

    Route::post('productions/{production}/issued', 'ProductionController@issued');

    Route::post('productions/{production}/cancelIssued', 'ProductionController@cancelIssued');

    Route::resource('productions', 'ProductionController');
    Route::get('productions/{production}/complete', 'ProductionController@showCompleteForm')->name('productions.showCompleteForm');
    Route::patch('productions/{production}/complete', 'ProductionController@complete')->name('productions.complete');

    Route::get('productions/{production}/addToInventory', 'ProductionController@addToInventory')->name('productions.addToInventory');

    Route::post('productions/{production}/addToInventoryStore', 'ProductionController@addToInventoryStore')->name('productions.addToInventoryStore');
    Route::delete('productions/{production}/batchQuantityDestroy', 'ProductionController@batchQuantityDestroy');
    Route::post('productions/{production}/completedInventory', 'ProductionController@completedInventory');

    Route::group(['prefix' => 'productions'], function () {
        Route::get('{production}/materials/add', 'ProductionController@addMaterial')->name('productions.materials.add');
        Route::post('{production}/materials/store', 'ProductionController@storeMaterial')->name('productions.materials.store');
        Route::get('{production}/materials/{material}/edit', 'ProductionController@editMaterial')->name('productions.materials.edit');
        Route::put('{production}/materials/{material}', 'ProductionController@updateMaterial')->name('productions.materials.update');
        Route::delete('{production}/materials/{material}', 'ProductionController@removeMaterial')->name('productions.materials.destroy');
    });
    Route::prefix('productions/{production}')->name('productions.')->group(function () {
        Route::resource('costs', 'ProductionCostController');
    });
    Route::resource('production-cost-categories', 'ProductionCostCategoryController', [
        'parameters' => ['production-cost-categories' => 'productionCostCategory'],
    ]);

    Route::resource('branches', 'BranchController');
    Route::resource('accounts', 'AccountController');

    Route::resource('purchases', 'PurchaseController');
    Route::group(['prefix' => 'purchases'], function () {
        Route::get('{purchase}/materials/add', 'PurchaseController@addMaterial')->name('purchases.materials.add');
        Route::post('{purchase}/materials', 'PurchaseController@storeMaterial')->name('purchases.materials.store');
        Route::get('{purchase}/materials/{material}/edit', 'PurchaseController@editMaterial')->name('purchases.materials.edit');
        Route::put('{purchase}/materials/{material}', 'PurchaseController@updateMaterial')->name('purchases.materials.update');
        Route::delete('{purchase}/materials/{material}', 'PurchaseController@removeMaterial')->name('purchases.materials.destroy');

        Route::post('{purchase}/purchaseSubmit', 'PurchaseController@purchaseSubmit');

        Route::get('{purchase}/receives/create', 'ReceiveController@create')->name('purchases.receives.create');
        Route::post('{purchase}/receives', 'ReceiveController@store')->name('purchases.receives.store');
        Route::delete('{purchase}/receives/{receive}', 'ReceiveController@destroy')->name('purchases.receives.destroy');
        Route::post('{purchase}/confirmReceived', 'PurchaseController@confirmReceived');

        Route::get('{purchase}/bills/create', 'PurchaseBillController@create')->name('purchases.bills.create');
        Route::post('{purchase}/bills', 'PurchaseBillController@store')->name('purchases.bills.store');
        Route::delete('{purchase}/bills/{bill}', 'PurchaseBillController@destroy')->name('purchases.bills.destroy');
    });
    Route::resource('costs', 'CostController');

    Route::resource('expenses', 'ExpenseController');
    Route::resource('suppliers', 'SupplierController');
    Route::resource('users', 'UserController');
    Route::get('users/change-password/{user}', 'UserController@changePassword')->name('users.change.password');
    Route::patch('users/change-password/{user}', 'UserController@changePasswordStore')->name('users.change.password.store');
    Route::resource('roles', 'RoleController');
    Route::resource('units', 'UnitController');
    Route::resource('cost-types', 'CostTypeController');
    Route::resource('transaction-categories', 'TransactionCategoryController');
    Route::group(['prefix' => '{branchId}'], function () {
        Route::resource('branch-users', 'BranchUserController');
    });
    Route::get('product-transfers/{id}/addProduct', 'ProductTransferController@addProductCreate')->name('product-transfers.addProductCreate');
    Route::post('product-transfers/{id}/addProduct', 'ProductTransferController@addProductStore');
    Route::post('getProductPrice', 'ProductTransferController@getProductPrice')->name('client.getProductPrice');
    Route::delete('product-transfers/{id}/item/{itemId}', 'ProductTransferController@productItemDestroy');
    Route::post('product-transfers/processCompleted/{id} ', 'ProductTransferController@processCompleted');
    Route::get('product-transfers/{id}/transferReject', 'ProductTransferController@transferReject')->name('product-transfers.transferReject');
    Route::post('product-transfers/{id}/transferReject', 'ProductTransferController@transferRejectStore');
    Route::resource('product-transfers', 'ProductTransferController');

    Route::resource('branch-product-inventories', 'BranchProductInventoryController');

    Route::get('product-transfer-receives/{id}/receivedReject', 'ProductTransferReceiveController@receivedReject')->name('product-transfer-receives.receivedReject');
    Route::post('product-transfer-receives/{id}/receivedReject', 'ProductTransferReceiveController@receivedRejectStore');
    Route::resource('product-transfer-receives', 'ProductTransferReceiveController');
});
