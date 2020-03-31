<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Production;
use Illuminate\Http\Request;
use App\Models\BatchQuantity;
use App\Models\ReceiveMaterial;
use App\Models\PurchaseMaterial;
use App\Models\ProductionMaterial;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\ProductionRequest;
use App\Http\Requests\ProductionMaterialRequest;

class ProductionController extends Controller
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['read-productions'])) {
            $productions = Production::orderBy('name', 'asc');

            if ($request->get('name')) {
                $productions->where('name', 'LIKE', '%' . $request->get('name') . '%');
            }

            if ($request->get('production_number')) {
                $productions->where('production_number', 'LIKE', '%' . $request->get('production_number') . '%');
            }

            if ($request->get('production_start_date')) {
                $productions->whereDate('production_date', '>=', $request->get('production_start_date'));
            }

            if ($request->get('production_end_date')) {
                $productions->whereDate('production_date', '<=', $request->get('production_end_date'));
            }

            if ($request->get('finish_start_date')) {
                $productions->whereDate('finish_date', '>=', $request->get('finish_start_date'));
            }

            if ($request->get('finish_end_date')) {
                $productions->whereDate('finish_date', '<=', $request->get('finish_end_date'));
            }


            $productions = $productions->with('productionMaterials', 'batchQuantities', 'costs')->paginate(50);

            return view('client.pages.productions.index', compact('subdomain', 'productions'));
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($subdomain)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-productions'])) {

            return view('client.pages.productions.create', compact('subdomain'));
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
    public function store($subdomain, ProductionRequest $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-productions'])) {
            $input = $request->all();

            $input['status'] = 0;
            $production = Production::create($input);
            return redirect()->route('productions.materials.add', [$subdomain, $production]);
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function show($subdomain, Production $production)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-productions'])) {

            return view('client.pages.productions.show', compact('subdomain', 'production'));
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    public function issued($subdomain, Production $production)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-productions'])) {

            if ($production->productionMaterials->count() == 0) {
                Session::flash('warning', 'Please add at least one material to issue this.');
                return redirect()->route('productions.show', [$subdomain, $production]);
            }

            if ($production->status <> 0) {
                Session::flash('warning', 'Sorry! Something went wrong, Please check production status.');
                return redirect()->route('productions.show', [$subdomain, $production]);
            }
            $production->update([
                'status' => 1,
            ]);
            Session::flash('success', 'Production Issued Successfully.');
            return redirect()->route('productions.show', [$subdomain, $production]);
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    public function cancelIssued($subdomain, Production $production)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-productions'])) {
            if ($production->status <> 1) {
                Session::flash('warning', 'Sorry! Something went wrong, Please check production status.');
                return redirect()->route('productions.show', [$subdomain, $production]);
            }
            $production->update([
                'status' => 0,
            ]);

            Session::flash('success', 'Production Issue Canceled Successfully.');
            return redirect()->route('productions.show', [$subdomain, $production]);
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function edit($subdomain, Production $production)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-productions'])) {
            if ($production->status > 1) {
                Session::flash('warning', 'Sorry! Something went wrong, Please check production status.');
                return redirect()->route('productions.index', [$subdomain]);
            }
            return view('client.pages.productions.edit', compact('subdomain', 'production'));
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function update($subdomain, Request $request, Production $production)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-productions'])) {
            if ($production->status > 1) {
                Session::flash('warning', 'Sorry! Something went wrong, Please check production status.');
                return redirect()->route('productions.index', [$subdomain]);
            }
            $production->update($request->all());

            return redirect()->route('productions.index', $subdomain)->with('success', "Production updated successfully");
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain, Production $production)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['delete-productions'])) {

            if ($production->status <> 0) {
                Session::flash('warning', 'Sorry! Something went wrong, Please check production status.');
                return redirect()->route('productions.index', [$subdomain]);
            }

            $production->delete();
            return redirect()->back()->with('success', 'Production deleted successfully.');
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addMaterial($subdomain, Production $production)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-productions'])) {
            if ($production->status <> 0) {
                Session::flash('warning', 'Sorry! Something went wrong, Please check production status.');
                return redirect()->route('productions.show', [$subdomain, $production->id]);
            }
            $purchaseMaterials = PurchaseMaterial::productionMaterialDropdown();
            return view('client.pages.productions.add-material', compact('subdomain', 'production', 'purchaseMaterials'));
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    /**
     * Store the material againste a production
     * @return \Illuminate\Http\Response
     */
    public function storeMaterial($subdomain, ProductionMaterialRequest $request, Production $production)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-productions'])) {
            if ($production->status <> 0) {
                Session::flash('warning', 'Sorry! Something went wrong, Please check production status.');
                return redirect()->back()->withInput();
            }
            $purchaseMaterial = PurchaseMaterial::find($request->purchase_material_id);

            DB::transaction(function () use ($purchaseMaterial, $production, $request) {
                ProductionMaterial::create([
                    'client_id' => Auth::user()->clientId,
                    'production_id' => $production->id,
                    'purchase_id' => $purchaseMaterial->purchaseId,
                    'material_id' => $purchaseMaterial->materialId,
                    'purchase_material_id' => $purchaseMaterial->id,
                    'quantity' => $request->quantity,
                    'rate' => $purchaseMaterial->rate,
                    'note' => $request->note,
                ]);
            });

            return redirect()->route('productions.show', [$subdomain, $production->id])->with('success', 'Production material added successfully');
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }


    /**
     * Show the material update form
     * @return \Illuminate\Http\Response
     */
    public function editMaterial($subdomain, Production $production, ProductionMaterial $material)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-productions'])) {
            return view('client.pages.productions.edit-material', compact('subdomain', 'production', 'material'));
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    /**
     * Update the material
     * @return \Illuminate\Http\Response
     */
    public function updateMaterial($subdomain, ProductionMaterialRequest $request, Production $production, ProductionMaterial $material)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-productions'])) {

            $purchaseMaterial = PurchaseMaterial::find($request->purchase_material_id);

            DB::transaction(function () use ($purchaseMaterial, $production, $request, $material) {
                $material->update([
                    'quantity' => $request->quantity,
                    'rate' => $purchaseMaterial->rate,
                    'note' => $request->note,
                ]);
            });

            return redirect()->route('productions.edit', [$subdomain, $production->id])->with('success', 'Production material updated successfully');
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    /**
     * removes material form the production
     * @return \Illuminate\Http\Response
     */
    public function removeMaterial($subdomain, Production $production, ProductionMaterial $material)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-productions'])) {
            if ($production->status <> 0) {
                Session::flash('warning', 'Sorry! Something went wrong, Please check production status.');
                return redirect()->route('productions.show', [$subdomain, $production->id]);
            }
            $material->delete();
            return redirect()->back()->with('success', 'Material removed successfully.');
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function showCompleteForm($subdomain, Production $production)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-productions'])) {
            if ($production->status <> 1) {
                Session::flash('warning', 'Sorry! Something went wrong, Please check production status.');
                return redirect()->route('productions.show', [$subdomain, $production->id]);
            }
            return view('client.pages.productions.complete', compact('subdomain', 'production'));
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function complete($subdomain, ProductionRequest $request, Production $production)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-productions'])) {

            if ($production->status <> 1) {
                Session::flash('warning', 'Sorry! Something went wrong, Please check production status.');
                return redirect()->route('productions.show', [$subdomain, $production->id]);
            }

            DB::transaction(function () use ($request, $production) {
                $production->update([
                    'finish_date' => $request->finish_date,
                    'quantity' => $request->quantity,
                    'production_cost' => $production->cost,
                    'status' => 2,
                ]);

                // $production->product->increment('quantity', $request->quantity);
            });

            return redirect()->route('productions.index', $subdomain)->with('success', "Production updated successfully");
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    //Add to inventory

    public function addToInventory($subdomain, Production $production)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-productions'])) {

            $products = Product::get()->pluck('name_code_batch_quantity', 'id')->all();
            return view('client.pages.productions.addToInventory', compact('subdomain', 'production', 'products'));
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    //Add to inventory Store

    public function addToInventoryStore($subdomain, Request $request, Production $production)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-productions'])) {

            if ($production->status <> 2) {
                Session::flash('warning', 'Sorry! Something went wrong, Please check production status.');
                return redirect()->route('productions.show', [$subdomain, $production->id]);
            }

            $messages = [
                'product_id.required' => 'The Product field is required',
            ];

            $product  = Product::find($request->product_id);

            $this->validate($request, [
                'product_id' => 'required',
                'input_quantity' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($production, $product) {
                        $available = $production->quantity - $production->batchQuantities->sum('input_quantity');
                        // dd($product->batch_quantity);
                        if ($product) {
                            $mod = ($value % $product->batch_quantity);
                            // dd(fmod($value,1) !== 0.00);
                            if ($value > $available) {
                                $fail('You can input max ' . $available);
                            } elseif ($product->is_numeric == 0 && fmod($value, 1) !== 0.00) {
                                $fail('Input quantity should be integer multiplier.');
                            } elseif ($product->is_numeric == 0 && $mod != 0) {
                                $fail('Input quantity should be integer multiplier.');
                            }
                        }
                    },
                ],


            ], $messages);

            $input = $request->all();
            $input['client_id'] =  Auth::user()->client_id;
            $input['production_id'] = $production->id;
            $input['batch_quantity'] = $product->batch_quantity;
            $input['product_quantity'] = $request->input_quantity / $product->batch_quantity;
            $input['created_by'] = Auth::user()->id;
            // dd($input);

            BatchQuantity::create($input);
            Session::flash('success', 'Input Quantity added successfully.');
            return redirect()->back();
            ///
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    public function batchQuantityDestroy($subdomain, Request $request, $id)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-productions'])) {

            $batchQuantity = BatchQuantity::findOrFail($id);

            if ($batchQuantity->production && $batchQuantity->production->first()->status <> 2) {
                Session::flash('warning', 'Sorry You can not delete, please check production status.');
                return redirect()->back();
            }

            $batchQuantity->delete();
            Session::flash('success', 'Input Quantity deleted successfully.');
            return redirect()->back();
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    public function completedInventory($subdomain, Request $request, Production $production)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-productions'])) {

            if ($production->status <> 2) {
                Session::flash('warning', 'Sorry! You can not add, please check production status.');
                return redirect()->back();
            } else if ($production->batchQuantities->count() == 0) {
                Session::flash('warning', 'Please add at least one item.');
                return redirect()->back();
            } else if ($production->batchQuantities->sum('input_quantity') < $production->quantity) {
                Session::flash('warning', 'Please add all production quantity to batch.');
                return redirect()->back();
            }


            DB::beginTransaction();
            try {

                foreach ($production->batchQuantities as $batchQuantity) {
                    // dd($batchQuantity->product_quantity);
                    $batchQuantity->product->increment('quantity', $batchQuantity->product_quantity);
                }

                $production->status = 3;
                $production->update();

                DB::commit();

                Session::flash('success', 'Products added to the inventory successfully.');
                return redirect()->back();
            } catch (\Exception $e) {
                DB::rollback();
                // dd($e);
                Session::flash('warning', 'Something went wrong');
                return redirect()->back()->withInput();
            }
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }
}
