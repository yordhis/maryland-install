<?php

namespace App\Http\Controllers;

use App\Models\RepresentanteEstudiante;
use App\Http\Requests\StoreRepresentanteEstudianteRequest;
use App\Http\Requests\UpdateRepresentanteEstudianteRequest;
use App\Models\Helpers;
use Illuminate\Http\Response;

class RepresentanteEstudianteController extends Controller
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
     * @param  \App\Http\Requests\StoreRepresentanteEstudianteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRepresentanteEstudianteRequest $request)
    {

        try {
            RepresentanteEstudiante::create([
                "cedula_estudiante" => $request->rep_cedula_estudiante,
                "cedula_representante" => $request->rep_cedula
            ]);

            $estatus = Response::HTTP_OK;
            $mensaje = "El representante fue asignado correctamente.";
            return back()->with(compact('mensaje', 'estatus'));

        } catch (\Throwable $th) {
            $estatus = Response::HTTP_INTERNAL_SERVER_ERROR;
            $mensaje = Helpers::getMensajeError($th, "¡Error interno al intentar asignar el representante al estudiante.!");
            return back()->with(compact('mensaje', 'estatus'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RepresentanteEstudiante  $representanteEstudiante
     * @return \Illuminate\Http\Response
     */
    public function show(RepresentanteEstudiante $representanteEstudiante)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RepresentanteEstudiante  $representanteEstudiante
     * @return \Illuminate\Http\Response
     */
    public function edit(RepresentanteEstudiante $representanteEstudiante)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRepresentanteEstudianteRequest  $request
     * @param  \App\Models\RepresentanteEstudiante  $representanteEstudiante
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRepresentanteEstudianteRequest $request, RepresentanteEstudiante $representanteEstudiante)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RepresentanteEstudiante  $representanteEstudiante
     * @return \Illuminate\Http\Response
     */
    public function destroy($representanteEstudiante)
    {
        try {
            RepresentanteEstudiante::where('id', $representanteEstudiante)->delete();
            $estatus = Response::HTTP_OK;
            $mensaje = "El representante fue desasignado correctamente.";
            return back()->with(compact('mensaje', 'estatus'));
        } catch (\Throwable $th) {
            $estatus = Response::HTTP_INTERNAL_SERVER_ERROR;
            $mensaje = Helpers::getMensajeError($th, ', ¡Error interno al intentar desasignar el representante!.');
            return back()->with(compact('mensaje', 'estatus'));
        }
    }
}
