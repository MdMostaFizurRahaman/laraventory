<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Currency;
use App\Models\Account;
use App\Models\Purchase;
use App\Models\BillMaterial;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PurchaseBillRequest;


class PurchaseBillController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:web');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($subdomain, Purchase $purchase)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-bills'])) {
            $currencies = Currency::pluck('name', 'id')->toArray();
            $accounts = Account::pluck('account_name', 'id')->toArray();
            return view('client.pages.purchase-bills.create', compact('subdomain', 'purchase', 'currencies', 'accounts'));
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($subdomain, PurchaseBillRequest $request, Purchase $purchase)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-bills'])) {

            dd($request->all());
            DB::transaction(function () use ($request, $purchase) {
                $bill = Bill::create([
                    'supplier_id' => $purchase->supplier_id,
                    'currency_id' => $request->currency_id,
                    'purchase_id' => $purchase->id,
                    'account_id' => $request->account_id,
                    'reference' => $request->reference,
                    'bill_date' => $request->bill_date,
                    'due_date' => $request->due_date,
                    'note' => $request->note,

                ]);

                foreach ($purchase->purchaseMaterials as $key => $purchaseMaterial) {
                    // Create Bill Material as Like Purchase Materials
                    $billMaterial = BillMaterial::create([
                        'bill_id' => $bill->id,
                        'material_id' => $purchaseMaterial->materialId,
                        'purchase_material_id' => $purchaseMaterial->id,
                        'quantity' => $request->bill_quantity[$key],
                        'rate' => $request->rate[$key],
                        'total' => $request->rate[$key] * $request->bill_quantity[$key],
                    ]);

                    //Increase total bill amount
                    $bill->increment('total', $billMaterial->total);

                    // Increment Purchase Material Billed Quantity
                    $purchaseMaterial->increment('billed_quantity', $request->bill_quantity[$key]);
                }
                //Icrement Supplier Balance
                $bill->supplier->increment('balance', $bill->total);

                //Decrement Account Balance
                $bill->account->decrement('balance', $bill->total);
            });

            return redirect()->route('purchases.index', $subdomain)->with('success', 'Purchase received successfully');
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain, Purchase $purchase, Bill $bill)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['delete-bills'])) {
            DB::transaction(function () use ($purchase, $bill) {

                //adjust billed quantity in purchase table
                $this->returnBillQuantity($bill);

                //decrement supplier balance
                $bill->supplier->decrement('balance', $bill->total);

                //Increment Account Balance
                $bill->account->increment('balance', $bill->total);

                //removes the bill
                $bill->delete();
            });


            return redirect()->route('purchases.edit', [$subdomain, $purchase->id])->with('success', 'Bill deleted successfully');
        } else {
            return view('error.client-unauthorized');
        }
    }



    /**
     * Decrement the PurchaseMaterial bill quantity
     */
    public function returnBillQuantity($bill)
    {
        foreach ($bill->billMaterials as $billMaterial) {
            $billMaterial->purchaseMaterial->decrement('billed_quantity', $billMaterial->quantity);
        }
    }
}
