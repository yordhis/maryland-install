<?php

namespace App\Http\Controllers;

use App\Models\Cuota;
use App\Http\Requests\StoreCuotaRequest;
use App\Http\Requests\UpdateCuotaRequest;
use App\Models\DataDev;
use App\Models\Helpers;

class CuotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = new DataDev;
        $notificaciones = $data->notificaciones;
        $usuario = $data->usuario;
        //mostramos una lista de cuotas
        $cuotas = Helpers::addDatosDeRelacion(
            Cuota::where('estatus', 0)
            ->whereYear('fecha', date('Y'))
            ->whereMonth('fecha','=' , date('m'))
            ->whereDay('fecha','<', date('d'))
            ->get(),
            [
                "estudiantes" => "cedula_estudiante"
            ]
        );

        // return $cuotas[0]->estudiante['nombre'];
        return view('admin.cuotas.lista', compact('usuario', 'notificaciones', 'cuotas'));
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
     * @param  \App\Http\Requests\StoreCuotaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCuotaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cuota  $cuota
     * @return \Illuminate\Http\Response
     */
    public function show(Cuota $cuota)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cuota  $cuota
     * @return \Illuminate\Http\Response
     */
    public function edit(Cuota $cuota)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCuotaRequest  $request
     * @param  \App\Models\Cuota  $cuota
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCuotaRequest $request, Cuota $cuota)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cuota  $cuota
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cuota $cuota)
    {
        //
    }
}
