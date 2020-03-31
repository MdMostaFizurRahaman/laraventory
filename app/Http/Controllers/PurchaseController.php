<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Currency;
use App\Models\Material;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\PurchaseMaterial;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PurchaseRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\PurchaseMaterialRequest;

class PurchaseController extends Controller
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
    public function index(Request $request, $subdomain)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['read-purchases'])) {
            $purchases = Purchase::orderBy('po_number', 'asc');

            if ($request->get('po_number')) {
                $purchases->where('po_number', $request->get('po_number'));
            }

            if ($request->get('supplier_id')) {
                $purchases->where('supplier_id', $request->get('supplier_id'));
            }

            if ($request->get('account_id')) {
                $purchases->where('account_id', $request->get('account_id'));
            }

            if ($request->get('currency_id')) {
                $purchases->where('currency_id', $request->get('currency_id'));
            }

            if ($request->get('purchase_start_date')) {
                $purchases->whereDate('purchase_date', '>=', $request->get('purchase_start_date'));
            }

            if ($request->get('purchase_end_date')) {
                $purchases->whereDate('purchase_date', '<=', $request->get('purchase_end_date'));
            }

            if ($request->get('receive_start_date')) {
                $purchases->whereDate('receive_date', '>=', $request->get('receive_start_date'));
            }

            if ($request->get('receive_end_date')) {
                $purchases->whereDate('receive_date', '<=', $request->get('receive_end_date'));
            }


            $suppliers = Supplier::whereIn('id', $purchases->pluck('supplier_id', 'supplier_id')->all())->pluck('name', 'id')->all();
            $accounts = Account::whereIn('id', $purchases->pluck('account_id', 'account_id')->all())->pluck('account_name', 'id')->all();

            $currencies = Currency::whereIn('id', $purchases->pluck('currency_id', 'currency_id')->all())->pluck('name', 'id')->all();

            $purchases = $purchases->with('supplier', 'account', 'currency')->paginate(20);

            return view('client.pages.purchases.index', compact('subdomain', 'purchases', 'suppliers', 'accounts', 'currencies'));
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($subdomain)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-purchases'])) {
            $suppliers = Supplier::pluck('name', 'id')->toArray();
            $accounts = Account::pluck('account_name', 'id')->toArray();
            $currencies = Currency::pluck('name', 'id')->toArray();
            $materials = Material::get();
            return view('client.pages.purchases.create', compact('subdomain', 'suppliers', 'accounts', 'materials', 'currencies'));
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
    public function store($subdomain, PurchaseRequest $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-purchases'])) {
            $data = $request->all();
            $data['status'] = 0;
            $purchase = Purchase::create($data);
            return redirect()->route('purchases.index', [$subdomain]);
        } else {
            return view('error.client-unauthorized');
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show($subdomain, Purchase $purchase)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['read-purchases'])) {

            return view('client.pages.purchases.show', compact('subdomain', 'purchase'));
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit($subdomain, Purchase $purchase)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-purchases'])) {

            if (!in_array($purchase->status, [0, 1])) {
                Session::flash('warning', 'Something went wrong, Please Check Purchase status.');
                return redirect()->route('purchases.index', $subdomain);
            }
            $suppliers = Supplier::pluck('name', 'id')->toArray();
            $accounts = Account::pluck('account_name', 'id')->toArray();
            $currencies = Currency::pluck('name', 'id')->toArray();
            return view('client.pages.purchases.edit', compact('subdomain', 'purchase', 'suppliers', 'accounts', 'currencies'));
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update($subdomain, PurchaseRequest $request, Purchase $purchase)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-purchases'])) {

            if (!in_array($purchase->status, [0, 1])) {
                Session::flash('warning', 'Something went wrong, Please Check Purchase status.');
                return redirect()->route('purchases.index', $subdomain);
            }

            if ($request->action === 'save&issue') {

                $purchase->update($request->except('action') + ['status' => 1]);
            } else {
                $purchase->update($request->except('action'));
            }
            return redirect()->route('purchases.index', $subdomain)->with('success', "Purchase updated successfully");
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain, Purchase $purchase)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['delete-purchases'])) {
            if ($purchase->status <> 0) {
                Session::flash('warning', 'Something went wrong, Please Check Purchase status.');
                return redirect()->route('purchases.index', $subdomain);
            }
            $purchase->delete();
            return redirect()->route('purchases.index', $subdomain)->with('success', 'Purchase deleted successfully');
        } else {
            return view('error.client-unauthorized');
        }
    }


    /**
     * This method is for adding materials to a Draft Purchase.
     */
    public function addMaterial($subdomain, Purchase $purchase)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-purchases'])) {
            if (!in_array($purchase->status, [1, 2, 3, 4])) {
                Session::flash('warning', 'Something went wrong, Please Check Purchase status.');
                return redirect()->route('purchases.show', [$subdomain, $purchase->id]);
            }
            $materials = Material::pluck('name', 'id')->toArray();
            return view('client.pages.purchases.add-material', compact('subdomain', 'purchase', 'materials'));
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Store purchase materials details in database.
     *
     *  @param \App\Models\Purchase  $purchase
     *  @param  App\Http\Requests\PurchaseItemRequest  $request
     *  @return \Illuminate\Http\Response
     */
    public function storeMaterial($subdomain, Purchase $purchase, PurchaseMaterialRequest $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-purchases'])) {

            if (!in_array($purchase->status, [1, 2, 3, 4])) {
                Session::flash('warning', 'Something went wrong, Please Check Purchase status.');
                return redirect()->route('purchases.show', [$subdomain, $purchase->id]);
            }

            $purchase->purchaseMaterials()->create($request->all() + ['client_id' => Auth::user()->clientId]);

            return redirect()->route('purchases.show', [$subdomain, $purchase->id])->with('success', "Material added successfully");
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Show the form for editing the specified purchase material.
     *
     * @param  \App\Models\Purchase  $purchase
     * @param  \App\Models\PurchaseMaterial  $material
     * @return \Illuminate\Http\Response
     */
    public function editMaterial($subdomain, Purchase $purchase, PurchaseMaterial $material)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-purchases'])) {
            if (!in_array($purchase->status, [1, 2, 3, 4])) {
                Session::flash('warning', 'Something went wrong, Please Check Purchase status.');
                return redirect()->route('purchases.show', [$subdomain, $purchase->id]);
            }
            $materials = Material::pluck('name', 'id')->toArray();
            return view('client.pages.purchases.edit-item', compact('subdomain', 'purchase', 'materials', 'material'));
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function updateMaterial($subdomain, PurchaseMaterialRequest $request, Purchase $purchase, PurchaseMaterial $material)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-purchases'])) {
            if (!in_array($purchase->status, [1, 2, 3, 4])) {
                Session::flash('warning', 'Something went wrong, Please Check Purchase status.');
                return redirect()->route('purchases.show', [$subdomain, $purchase->id]);
            }
            // DB::transaction(function () use ($purchase, $material, $request) {
            //     // $purchase->decrement('total', $material->total);
            //     $material->update($request->all());
            //     // $purchase->increment('total', $request->total);
            // });

            $material->update($request->all());
            return redirect()->route('purchases.show', [$subdomain, $purchase->id])->with('success', "Material updated successfully");
        } else {
            return view('error.client-unauthorized');
        }
    }


    /**
     * Remove the specified purchase material from storage.
     *
     * @param  \App\Models\PurchaseMaterial  $material
     * @return \Illuminate\Http\Response
     */
    public function removeMaterial($subdomain, Purchase $purchase, PurchaseMaterial $material)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-purchases'])) {
            if (!in_array($purchase->status, [1, 2, 3, 4])) {
                Session::flash('warning', 'Something went wrong, Please Check Purchase status.');
                return redirect()->route('purchases.show', [$subdomain, $purchase->id]);
            }

            $material->delete();

            return redirect()->route('purchases.show', [$subdomain, $purchase->id])->with('success', "Material removed successfully");
        } else {
            return view('error.client-unauthorized');
        }
    }


    public function purchaseSubmit($subdomain, Purchase $purchase)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-purchases'])) {
            if (!in_array($purchase->status, [1, 2, 3, 4])) {
                Session::flash('warning', 'Something went wrong, Please Check Purchase status.');
                return redirect()->route('purchases.show', [$subdomain, $purchase->id]);
            } elseif ($purchase->purchaseMaterials->count() == 0) {
                Session::flash('warning', 'Please add at least one purchase material.');
                return redirect()->route('purchases.show', [$subdomain, $purchase->id]);
            }

            $purchase->update([
                'total' => $purchase->purchaseMaterials->sum('total'),
                'status' => 2,
            ]);

            return redirect()->route('purchases.show', [$subdomain, $purchase->id])->with('success', "Purchase submit successfully");
        } else {
            return view('error.client-unauthorized');
        }
    }


    public function confirmReceived($subdomain, Purchase $purchase)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-purchases'])) {

            if (!in_array($purchase->status, [3, 4])) {
                Session::flash('warning', 'Something went wrong, Please Check Purchase status.');
                return redirect()->route('purchases.show', [$subdomain, $purchase->id]);
            }

            DB::beginTransaction();
            try {

                foreach ($purchase->purchaseMaterials as $purchaseMaterial) {
                    //Increment Receive Material Quantity
                    $purchaseMaterial->material->increment('quantity', $purchaseMaterial->received_quantity);
                }

                $purchase->update([
                    'status' => 5,
                ]);

                DB::commit();

                Session::flash('success', 'Purchase receive confirmed successfully.');
                return redirect()->back();
            } catch (\Exception $e) {
                DB::rollback();
                // dd($e);
                Session::flash('warning', 'Something went wrong');
                return redirect()->back();
            }

            return redirect()->route('purchases.show', [$subdomain, $purchase->id])->with('success', 'Receive deleted successfully');
        } else {
            abort(403);
        }
    }
}
