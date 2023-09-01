<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\{
    Helpers,
    Grupo
};

class ApiController extends Controller
{

    public function getEstudiante($cedula)
    {
        try {
            $estudiante = Helpers::getEstudiante($cedula);
            return response()->json($estudiante, Response::HTTP_OK);
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error en la API al retornar los datos del Estudiante en el método getEstudiante,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }


    public function getGrupo($codigo)
    {
        try {
            $grupo = Helpers::addDatosDeRelacion(Grupo::where('codigo', $codigo)->get(), [
                "niveles" => "codigo_nivel",
                "profesores" => "cedula_profesor"
            ]);
            $grupo = Helpers::setMAtricula($grupo)[0];
            return response()->json($grupo, Response::HTTP_OK);
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error en la API al retornar los datos del grupo en el método getGrupo,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }

    
}
