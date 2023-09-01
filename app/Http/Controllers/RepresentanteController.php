<?php

namespace App\Http\Controllers;

use App\Models\Representante;
use App\Http\Requests\StoreRepresentanteRequest;
use App\Http\Requests\UpdateRepresentanteRequest;

class RepresentanteController extends Controller
{
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
     * @param  \App\Http\Requests\StoreRepresentanteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRepresentanteRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Representante  $representante
     * @return \Illuminate\Http\Response
     */
    public function show(Representante $representante)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Representante  $representante
     * @return \Illuminate\Http\Response
     */
    public function edit(Representante $representante)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRepresentanteRequest  $request
     * @param  \App\Models\Representante  $representante
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRepresentanteRequest $request, Representante $representante)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Representante  $representante
     * @return \Illuminate\Http\Response
     */
    public function destroy(Representante $representante)
    {
        //
    }
}
