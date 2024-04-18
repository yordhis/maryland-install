<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\{
    Estudiante,
    Helpers,
    Grupo
};

class ApiController extends Controller
{

    /** Obtenemos un nuevo codigo de inscripcion */
    public function getCodigoInscripcion($incrementar = 0){
        try {
            $codigo = Helpers::getCodigo('inscripciones', intval($incrementar));
            return Helpers::getRespuestaJson("Consulta de nuevo código exitosa", $codigo);
        } catch (\Throwable $th) {
            return Helpers::getRespuestaJson("¡Error interno!: " . $th->getMessage(), $codigo, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getRepresentante($cedula)
    {
        try {
            
            $representante = Helpers::getRepresentante($cedula);
            $mensaje = count($representante) ? "Consulta exitosa" : "No hay resultados";
            $estatus = count($representante) ?  Response::HTTP_OK : Response::HTTP_NOT_FOUND;
            if(count($representante)) $representante = $representante[0];
            return Helpers::getRespuestaJson($mensaje, $representante, $estatus);
            
        } catch (\Throwable $th) {
            return Helpers::getRespuestaJson(
                "¡Error interno!:" . $th->getMessage(), 
                [], 
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
           
        }
    }

    public function getEstudiante($cedula)
    {
        try {
            $estudiante = Helpers::getEstudiante($cedula);

            $mensaje = count($estudiante) ? "Consulta exitosa" : "No hay resultados";
            $estatus = count($estudiante) ?  Response::HTTP_OK : Response::HTTP_NOT_FOUND;
            if(count($estudiante)) $estudiante = $estudiante[0];
            return Helpers::getRespuestaJson($mensaje, $estudiante,$estatus);

        } catch (\Throwable $th) {
            return Helpers::getRespuestaJson("¡Error interno!: " .  $th->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function getGrupo($codigo)
    {
        try {
            $grupo = Helpers::addDatosDeRelacion(Grupo::where('codigo', $codigo)->get(), [
                "niveles" => "codigo_nivel",
                "profesores" => "cedula_profesor"
            ]);
            $mensaje = count($grupo) ? "Consulta exitosa" : "No hay resultados";
            $estatus = count($grupo) ? Response::HTTP_OK : Response::HTTP_NOT_FOUND;

            if(count($grupo)) $grupo = Helpers::setMAtricula($grupo)[0];

            return Helpers::getRespuestaJson($mensaje, $grupo, $estatus);
           
        } catch (\Throwable $th) {
            return Helpers::getRespuestaJson("¡Error interno!: " .  $th->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    
}
