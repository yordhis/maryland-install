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
use App\Http\Requests\StoreGrupoRequest;
use App\Http\Requests\UpdateGrupoRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GrupoController extends Controller
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
    public function index(Request $request)
    {
        try {
            $notificaciones = $this->data->notificaciones;
            $respuesta = $this->data->respuesta;
            $niveles = Nivele::where("estatus", 1)->get();
            $profesores = Profesore::where('estatus', 1)->get();
            $codigo = Helpers::getCodigo('grupos');
            $dias = $this->data->dias;

            $grupos = Helpers::getGrupos($request->filtro);



            return view('admin.grupos.lista', compact('grupos', 'notificaciones', 'request', 'respuesta', 'niveles', 'profesores', 'codigo', 'dias'));
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al Consultar Grupos en el método index,");
            return back()->with([
                "mensaje" => $errorInfo,
                "estatus" => Response::HTTP_INTERNAL_SERVER_ERROR
            ]);
        }
    }

    /** imprimir matricula del grupo de estudio */
    public function imprimirMatriculaDelGrupo($codigoGrupo)
    {
        $grupos = Helpers::getGrupos($codigoGrupo);

        return $grupos;
    }
 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGrupoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGrupoRequest $request)
    {
        try {

            $estatusCreate = 0;
            $diasGrupo = Helpers::getArrayInputs($request->request, "dia") ?? [];

            $request['dias'] =  implode(',', $diasGrupo);
            $datoExiste = Helpers::datoExiste($request, ["grupos" => ["nombre", "", "nombre"]]);
            if (count($diasGrupo)) {
                if (!$datoExiste) {
                    $estatusCreate = Grupo::create($request->all());
                }
            }

            $mensaje = $this->data->respuesta['mensaje'] = $estatusCreate ? "El Grupo se Creó correctamente."
                : "El nombre del Grupo ya existe, Cambie el nombre.";
            $mensaje = $this->data->respuesta['mensaje'] = count($diasGrupo) ?  $mensaje
                :  "Debe ingresar los Días de clases para el grupo de estudio";
            $estatus = $this->data->respuesta['estatus'] = $estatusCreate ? 200 : 301;

            $respuesta = $this->data->respuesta;

            return redirect()->route('admin.grupos.index')->with([
                "mensaje" => $mensaje,
                "estatus" => $estatus
            ]);
        } catch (\Throwable $th) {
            $mensaje = Helpers::getMensajeError($th, "Error al crear un grupo en el método store,");
            return redirect()->route('admin.grupos.index')->with([
                "mensaje" => $mensaje,
                "estatus" => Response::HTTP_INTERNAL_SERVER_ERROR
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function edit(Grupo $grupo)
    {
        try {
            $diasGrupo = explode(',', $grupo->dias);
            $notificaciones = $this->data->notificaciones;
            $respuesta = $this->data->respuesta;
            $dias = $this->data->dias;
            $niveles = Nivele::where("estatus", 1)->get();
            $profesores = Profesore::where('estatus', 1)->get();

            foreach ($dias as $key => $dia) {
                foreach ($diasGrupo as $diaG) {
                    if ($diaG == $dia) {
                        $dias[$key] = [
                            "dia" => $dia,
                            "activo" => "checked"
                        ];
                        break;
                    } else {
                        $dias[$key] = [
                            "dia" => $dia,
                            "activo" => null
                        ];
                    }
                }
            }

            return view(
                'admin.grupos.editar',
                compact('notificaciones', 'niveles', 'profesores', 'grupo', 'dias', 'respuesta')
            );
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error de Consulta de grupo en el método Edit,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGrupoRequest  $request
     * @param  \App\Models\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGrupoRequest $request, Grupo $grupo)
    {
        try {
            $estatusUpdate = false;
            $diasGrupo = Helpers::getArrayInputs($request->request, "dia") ?? [];
            $request['dias'] =  implode(',', $diasGrupo);
            if (count($diasGrupo)) {
                $estatusUpdate = $grupo->update($request->all());
            }

            $mensaje = $this->data->respuesta['mensaje'] = $estatusUpdate ? "El Grupo se Actualizó correctamente."
                : "El Grupo no sufrió ningun cambio.";

            $mensaje = $this->data->respuesta['mensaje'] = count($diasGrupo) ?  $mensaje
                :  "Debe ingresar los Días de clases para el grupo de estudio";

            $estatus = $this->data->respuesta['estatus'] = $estatusUpdate ? 200
                : 301;



            return $estatusUpdate   ? redirect()->route('admin.grupos.index')->with([
                "mensaje" => $mensaje,
                "estatus" => $estatus
            ])
                : back()->with([
                    "mensaje" => $mensaje,
                    "estatus" => $estatus
                ]);
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al Actualizar grupo en el método update,");
            return back()->with([
                "mensaje" => $errorInfo,
                "estatus" => Response::HTTP_INTERNAL_SERVER_ERROR
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grupo $grupo)
    {
        try {
            $grupos = Helpers::getGrupos($grupo->codigo);
 
            if(count($grupos[0]->estudiantes)){
                return back()->with([
                    "mensaje" => "No se puede eliminar el grupo, porque poseé estudiantes inscriptos.",
                    "estatus" => Response::HTTP_UNAUTHORIZED
                ]);
            }else{
                /** Eliminar el grupo */
                $grupo->delete();
                
                return back()->with([
                    "mensaje" => "Grupo eliminado correctamente.",
                    "estatus" => Response::HTTP_OK
                ]);
            }
            
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al Eliminar grupo en el método destroy,");
            return back()->with([
                "mensaje" =>  $errorInfo ,
                "estatus" => Response::HTTP_INTERNAL_SERVER_ERROR
            ]);
        }
    }
}
