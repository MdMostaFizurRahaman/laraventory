<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaterialCategoryRequest;
use App\Models\MaterialCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialCategoryController extends Controller
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
    public function index($subdomain, Request $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['read-material-categories'])) {
            $categories = MaterialCategory::orderBy('name', 'ASC');

            if ($request->get('name')) {
                $categories->where('name', 'LIKE', '%' . $request->get('name') . '%');
            }
            $categories = $categories->paginate(20);
            return view('client.pages.material-categories.index', compact('categories', 'subdomain'));
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
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-material-categories'])) {

            return view('client.pages.material-categories.create', compact('subdomain'));
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
    public function store($subdomain, MaterialCategoryRequest $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['create-material-categories'])) {

            MaterialCategory::create($request->all() + ['client_id' => Auth::user()->clientId]);
            return redirect()->route('material-categories.index', compact('subdomain'))->with('success', 'Material category created Successfully');
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MaterialCategory  $materialCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($subdomain, MaterialCategory $materialCategory)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-material-categories'])) {

            $categories = MaterialCategory::findOrFail($materialCategory->id);
            return view('client.pages.material-categories.edit', compact('categories', 'materialCategory', 'subdomain'));
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MaterialCategory  $materialCategory
     * @return \Illuminate\Http\Response
     */
    public function update($subdomain, Request $request, MaterialCategory $materialCategory)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['update-material-categories'])) {

            $materialCategory->update($request->all());
            return redirect()->route('material-categories.index', compact('subdomain'))->with('success', 'Material category updated Successfully');
        } else {
            return view('error.client-unauthorized');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MaterialCategory  $materialCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain, MaterialCategory $materialCategory)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['delete-material-categories'])) {
            $materialCategory->delete();
            return redirect()->route('material-categories.index', compact('subdomain'))->with('success', 'Material category deleted Successfully');
        } else {
            return view('error.client-unauthorized');
        }
    }
}
