<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Material;
use App\Models\MaterialCategory;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MaterialRequest;

class MaterialController extends Controller
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
    public function index($subdomain)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['read-materials'])) {

            $materials = Material::with('unit')->paginate(10);
            return view('client.pages.materials.index', compact('materials', 'subdomain'));
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-materials'])) {
            $categories = MaterialCategory::pluck('name', 'id')->toArray();
            $units = Unit::pluck('name', 'id')->toArray();
            return view('client.pages.materials.create', compact('categories', 'units', 'subdomain'));
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
    public function store($subdomain, MaterialRequest $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-materials'])) {

            Material::create($request->all());
            return redirect()->route('materials.index', $subdomain)->with('success', 'Material created successfully');
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function show(Material $material)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function edit($subdomain, Material $material)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-materials'])) {
            $categories = MaterialCategory::pluck('name', 'id')->toArray();
            $units = Unit::pluck('name', 'id')->toArray();
            return view('client.pages.materials.edit', compact('material', 'subdomain', 'categories', 'units'));
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function update($subdomain, MaterialRequest $request, Material $material)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-materials'])) {

            $material->update($request->all());
            return redirect()->route('materials.index', $subdomain)->with('success', 'Material updated successfully');
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain, Material $material)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['delete-materials'])) {
            $material->delete();
            return redirect()->route('materials.index', $subdomain)->with('success', 'Material deleted successfully');
        } else {
            return view('error.unauthorized', compact('subdomain'));
        }
    }
}
