<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDashboardRequest;
use App\Http\Requests\UpdateDashboardRequest;
use App\Models\{
    Cuota,
    Dashboard,
    Estudiante,
    Grupo,
    GrupoEstudiante,
    Pago,
    Profesore
};

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $dataTarjetas = [
            "grupos" => Grupo::where('estatus', 1)->count(),
            "estudiantes" => GrupoEstudiante::where('estatus', 1)->count(),
            "profesores" => Profesore::where('estatus', 1)->count(),
            "cuotas" => Cuota::where('estatus', 0)
            ->whereYear('fecha', date('Y'))
            ->whereMonth('fecha','=' , date('m'))
            ->whereDay('fecha','<', date('d'))
            ->count(),
            "pagos" => Pago::whereYear('fecha', date('Y'))
            ->whereMonth('fecha', date('m'))
            ->count()
        ];

        $notificaciones = [
            "total" => 5,
            "data"=>[
                ["descripcion"=>"Franklin Pago", "tipo"=>"Pago"],
                ["descripcion"=>"Franklin 2 Pago", "tipo"=>"Pago"],
                ["descripcion"=>"Franklin 3 Pago", "tipo"=>"Pago"],
                ["descripcion"=>"Franklin 4 Pago", "tipo"=>"Pago"],
                ["descripcion"=>"Franklin 5 Pago", "tipo"=>"Pago"]
            ]
        ];

        $usuario = [
            "nombre" => "admin",
            "rol" => "administrador",
        ];

        return view('admin.dashboard', compact('dataTarjetas', 'notificaciones', 'usuario'));
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
     * @param  \App\Http\Requests\StoreDashboardRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDashboardRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function show(Dashboard $dashboard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function edit(Dashboard $dashboard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDashboardRequest  $request
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDashboardRequest $request, Dashboard $dashboard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dashboard $dashboard)
    {
        //
    }
}
