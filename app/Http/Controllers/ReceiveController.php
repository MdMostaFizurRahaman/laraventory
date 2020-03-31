<?php

namespace App\Http\Controllers;

use App\Models\Receive;
use App\Models\Purchase;
use App\Models\ReceiveMaterial;
use App\Models\PurchaseMaterial;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ReceiveRequest;
use Illuminate\Support\Facades\Session;

class ReceiveController extends Controller
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-receives'])) {

            if (!in_array($purchase->status, [2, 3])) {
                Session::flash('warning', 'Something went wrong, Please Check Purchase status.');
                return redirect()->route('purchases.show', [$subdomain, $purchase->id]);
            }

            return view('client.pages.purchase-receives.create', compact('subdomain', 'purchase'));
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($subdomain, Purchase $purchase, ReceiveRequest $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-receives'])) {

            if (!in_array($purchase->status, [2, 3])) {
                Session::flash('warning', 'Something went wrong, Please Check Purchase status.');
                return redirect()->route('purchases.show', [$subdomain, $purchase->id]);
            }
            // DB::transaction(function () use ($request, $purchase) {

            //     $receive = Receive::create([
            //         'receive_date' => $request->receive_date,
            //         'note' => $request->note,
            //         'supplier_id' => $purchase->supplierId,
            //         'purchase_id' => $purchase->id,
            //     ]);

            //     foreach ($purchase->purchaseMaterials as $key => $purchaseMaterial) {
            //         // Create Receive Material as Like Purchase Materials
            //         $receiveMaterial = ReceiveMaterial::create([
            //             'receive_id' => $receive->id,
            //             'material_id' => $purchaseMaterial->material_id,
            //             'purchase_material_id' => $purchaseMaterial->id,
            //             'quantity' => $request->receive_quantity[$key],
            //             'rate' => $purchaseMaterial->rate,
            //             'total' => $purchaseMaterial->rate * $request->receive_quantity[$key],
            //             'client_id' => Auth::user()->clientId,
            //         ]);

            //         // Increment Purchase Material Receive Quantity
            //         $purchaseMaterial->increment('received_quantity', $request->receive_quantity[$key]);

            //         //Increment Receive Material Quantity
            //         $receiveMaterial->material->increment('quantity', $receiveMaterial->quantity);
            //     }
            //     // Update Purchase Status to Partially Received/Received
            //     $this->changePurchaseStatus($receive);
            // });

            DB::beginTransaction();
            try {

                $receive = Receive::create([
                    'receive_date' => $request->receive_date,
                    'note' => $request->note,
                    'supplier_id' => $purchase->supplierId,
                    'purchase_id' => $purchase->id,
                ]);

                foreach ($request->receive_quantity as $key => $value) {
                    $purchaseMaterial = PurchaseMaterial::find($key);

                    // Create Receive Material as Like Purchase Materials
                    $receiveMaterial = ReceiveMaterial::create([
                        'purchase_material_id' => $key,
                        'receive_id' => $receive->id,
                        'material_id' => $purchaseMaterial->material_id,
                        'quantity' => $value,
                        'rate' => $purchaseMaterial->rate,
                        'total' => $purchaseMaterial->rate * $value,
                        'client_id' => Auth::user()->clientId,
                    ]);

                    // Increment Purchase Material Receive Quantity
                    $purchaseMaterial->increment('received_quantity', $value);
                }

                // Update Purchase Status to Partially Received/Received
                $this->changePurchaseStatus($receive);

                DB::commit();

                Session::flash('success', 'Purchase receive successfully.');
                return redirect()->back();
            } catch (\Exception $e) {
                DB::rollback();
                // dd($e);
                Session::flash('warning', 'Something went wrong');
                return redirect()->back()->withInput();
            }

            return redirect()->route('purchases.show', [$subdomain, $purchase])->with('success', 'Purchase received successfully');
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Receive  $receive
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain, Purchase $purchase, Receive $receive)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['delete-receives'])) {

            if (!in_array($purchase->status, [3, 4])) {
                Session::flash('warning', 'Something went wrong, Please Check Purchase status.');
                return redirect()->route('purchases.show', [$subdomain, $purchase->id]);
            }

            DB::transaction(function () use ($receive, $purchase) {

                // Return the receive quantity
                $this->returnReceiveQuantity($receive);

                // Update Purchase Status to Partially Received/Received
                $this->changePurchaseStatus($receive);

                // Remove the specified receive from storage
                $receive->delete();
            });

            return redirect()->route('purchases.show', [$subdomain, $purchase->id])->with('success', 'Receive deleted successfully');
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    /**
     * This method will change the Purchase Status
     * Status: Receive or Partially Received
     */
    public function changePurchaseStatus($receive)
    {
        foreach ($receive->purchase->purchaseMaterials as $material) {
            if ($material->quantity !== $material->receivedQuantity) {
                $receive->purchase->status = 3;
                $receive->purchase->save();
                break;
            } else {
                $receive->purchase->status = 4;
                $receive->purchase->save();
            }
        }
    }

    /**
     * Decrement the Material quantity
     * Decrement the PurchaseMaterial receive quantity
     */
    public function returnReceiveQuantity($receive)
    {
        foreach ($receive->receiveMaterials as $receiveMaterial) {
            // $receiveMaterial->material->decrement('quantity', $receiveMaterial->quantity);
            $receiveMaterial->purchaseMaterial->decrement('received_quantity', $receiveMaterial->quantity);
        }
    }
}
