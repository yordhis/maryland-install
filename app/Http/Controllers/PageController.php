<?php

namespace App\Http\Controllers;

use App\Models\Helpers;
use App\Models\Nivele;
use App\Models\Plane;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $planes = Plane::all();
        $niveles = Nivele::all();
        return view('page.index', compact('planes', 'niveles'));
    }

    /**
     * PÁGINA DE PREINCRIPCIÓN
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $niveles = Nivele::all();
        $planes = Plane::where('estatus', 2)->get();
        $nivelSolicitado = Nivele::where('codigo', $request->codigo_nivel)->get();
        return view('page.preinscripcion', compact('niveles', 'planes', 'request', 'nivelSolicitado'));
    }

    public function createEstudiante(Request $request)
    {
        try {
       
            $nivelSolicitado = Nivele::where('codigo', $request->codigo_nivel)->get();
            $planSolicitado = Plane::where('codigo', $request->codigo_plan)->get();
            return view('page.estudiantePreinscripcion', compact('request', 'nivelSolicitado', 'planSolicitado'));
            
        } catch (\Throwable $th) {
           $estatus = Response::HTTP_INTERNAL_SERVER_ERROR;
           $mensaje = Helpers::getMensajeError($th, ", ¡Error interno al intentar acceder a la vista de preincripción!");
           return back()->with(compact('estatus', 'mensaje'));
        }
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
