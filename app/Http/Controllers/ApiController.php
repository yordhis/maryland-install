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

    public function getRepresentante($cedula)
    {
        try {
            
            $representante = Helpers::getRepresentante($cedula);
            if (count($representante)) {
                // return response()->json($representante[0], Response::HTTP_OK);
                return response()->json([
                    "mensaje" => "Busqueda Exitosa",
                    "data" => $representante[0], 
                    "estatus" => Response::HTTP_OK 
                ], Response::HTTP_OK);
            }else {
                return response()->json([
                    "mensaje" => "No hay Resultados", 
                    "estatus" => Response::HTTP_NOT_FOUND 
                ], Response::HTTP_NOT_FOUND);
            }
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error en la API al retornar los datos del Representante en el método getRepresentante,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }

    public function getEstudiante($cedula)
    {
        try {

           
            $estudiante = Helpers::getEstudiante($cedula);
            $mensaje = $estudiante->id > 0 ? "Consulta exitosa" : "No hay resultados";
            $estatus = $estudiante->id > 0  ?  Response::HTTP_OK : Response::HTTP_NOT_FOUND;
      
            return response()->json([
                "mensaje" =>  $mensaje,
                "estatus" =>  $estatus,
                "data" => $estudiante
            ], $estatus);

        } catch (\Throwable $th) {
            return response()->json([
                "mensaje" =>  "No hay resultado",
                "estatus" =>  Response::HTTP_NOT_FOUND,
                "data" => $th->getMessage()
            ], Response::HTTP_NOT_FOUND);
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
