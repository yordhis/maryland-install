<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDashboardRequest;
use App\Http\Requests\UpdateDashboardRequest;
use App\Models\{
    Cuota,
    Dashboard,
    DataDev,
    Estudiante,
    Grupo,
    GrupoEstudiante,
    Pago,
    Profesore
};

class DashboardController extends Controller
{
    public $data;

    public function __construct()
    {
        $this->data = new DataDev;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notificaciones = $this->data->notificaciones;
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

        return view('admin.dashboard', compact('dataTarjetas', 'notificaciones'));
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
