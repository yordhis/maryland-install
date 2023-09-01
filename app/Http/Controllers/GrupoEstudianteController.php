<?php

namespace App\Http\Controllers;

use App\Models\{
    Grupo,
    GrupoEstudiante,
    Nivele,
    Profesore,
    DataDev,
    Helpers
};
use App\Http\Requests\StoreGrupoEstudianteRequest;
use App\Http\Requests\UpdateGrupoEstudianteRequest;

class GrupoEstudianteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('admin.grupos.index');
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
     * @param  \App\Http\Requests\StoreGrupoEstudianteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGrupoEstudianteRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GrupoEstudiante  $grupoEstudiante
     * @return \Illuminate\Http\Response
     */
    public function show(GrupoEstudiante $grupoEstudiante)
    {
        return redirect()->route('admin.grupos.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GrupoEstudiante  $grupoEstudiante
     * @return \Illuminate\Http\Response
     */
    public function edit(GrupoEstudiante $grupoEstudiante)
    {
        return redirect()->route('admin.grupos.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGrupoEstudianteRequest  $request
     * @param  \App\Models\GrupoEstudiante  $grupoEstudiante
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGrupoEstudianteRequest $request, GrupoEstudiante $grupoEstudiante)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GrupoEstudiante  $grupoEstudiante
     * @return \Illuminate\Http\Response
     */
    public function destroy(GrupoEstudiante $grupoEstudiante)
    {
        if($grupoEstudiante->update(["estatus" => 0])){
            $data = new DataDev();
            $notificaciones = $data->notificaciones;
            $usuario = $data->usuario;
            $data->respuesta['activo'] = true;
            $data->respuesta['estatus'] = 404;
            $data->respuesta['mensaje'] = "Estudiante eliminado del Grupo correctamente";
            $respuesta = $data->respuesta;
            $grupos = Grupo::where('codigo', $grupoEstudiante->codigo_grupo)->get();

            // Agregar info de los grupos
            foreach ($grupos as $grupo) {
                $grupo['profesor'] = Profesore::where('cedula', $grupo->cedula_profesor)->get()[0];
                $grupo['nivel'] = Nivele::where('codigo', $grupo->codigo_nivel)->get()[0];
                $grupo['matricula'] = GrupoEstudiante::where([
                    'codigo_grupo' => $grupo->codigo, 
                    'estatus' => 1
                ])
                ->get()->count();
                $grupo['estudiantes'] = GrupoEstudiante::where([
                    'codigo_grupo' => $grupo->codigo, 
                    'estatus' => 1
                ])->get();
                foreach ($grupo->estudiantes as $key => $est) {
                    $grupo->estudiantes[$key] = Helpers::getEstudiante($est->cedula_estudiante);
                    $grupo->estudiantes[$key]['id'] = $est->id; // se le asigna el id asignado en la tabla pibote para poceder a eliminar
                }
            }
            return view('admin.grupos.ver', compact('grupo', 'usuario', 'notificaciones', 'respuesta'));
        }
        return redirect()->route('admin.grupos.index');
    }
}
