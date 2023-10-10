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
        try {
            // return url()->previous();
            $estudiante = Helpers::getEstudiante($grupoEstudiante->cedula_estudiante);
            $grupo = Grupo::where('codigo', $grupoEstudiante->codigo_grupo)->get()[0];
         
            if($grupoEstudiante->delete()){
               
                Helpers::destroyData($grupoEstudiante->cedula_estudiante, $grupoEstudiante->codigo_grupo, [
                    "pagos" => true,
                    "cuotas" => true,
                    "inscripcione" => true,
                    "grupoEstudiante" => false,
                ]);

                $mensaje = "El estudiante {$estudiante->nombre}, fue eliminado del grupo correctamente";
                $estatus = 200;
                return redirect(url()->previous()."?mensaje={$mensaje}&estatus={$estatus}");
            }else {
                $mensaje = "No funcionó";
                $estatus = 404;
                return redirect(url()->previous()."?mensaje=not found&estatus=404");
            }
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al Eliminar el estudiante del grupo en el método destroy,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }
}
