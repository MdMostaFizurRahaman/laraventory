<?php

namespace App\Http\Controllers;

use App\Models\PurchaseMaterial;
use Illuminate\Http\Request;

class PurchaseMaterialController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PurchaseMaterial  $purchaseMaterial
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseMaterial $purchaseMaterial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PurchaseMaterial  $purchaseMaterial
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseMaterial $purchaseMaterial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurchaseMaterial  $purchaseMaterial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchaseMaterial $purchaseMaterial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurchaseMaterial  $purchaseMaterial
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseMaterial $purchaseMaterial)
    {
        //
    }
}
