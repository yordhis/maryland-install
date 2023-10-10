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
    public function index()
    {
        try {
            $notificaciones = $this->data->notificaciones;
            $usuario = $this->data->usuario;
            $grupos = Grupo::where('estatus', 1)->get();

            // Agregar info de los grupos
            foreach ($grupos as $grupo) {
                $grupo['profesor'] = Profesore::where('cedula', $grupo->cedula_profesor)->get()[0];
                $grupo['nivel'] = Nivele::where('codigo', $grupo->codigo_nivel)->get()[0];
                $grupo['matricula'] = GrupoEstudiante::where([
                    'codigo_grupo' => $grupo->codigo,
                    'estatus' => 1
                ])->get()->count();
            }

            return view('admin.grupos.lista', compact('grupos', 'usuario', 'notificaciones'));
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al Consultar Grupos en el método index,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $notificaciones = $this->data->notificaciones;
            $usuario = $this->data->usuario;
            $dias = $this->data->dias;
            $niveles = Nivele::where("estatus", 1)->get();
            $profesores = Profesore::where('estatus', 1)->get();
            $codigo = Helpers::getCodigo('grupos');
            return view('admin.grupos.crear', compact('usuario', 'notificaciones', 'niveles', 'profesores', 'codigo', 'dias'));
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al Consultar datos para crear grupo en el método create,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
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
            $notificaciones = $this->data->notificaciones;
            $usuario = $this->data->usuario;
            $dias = $this->data->dias;
            $niveles = Nivele::where("estatus", 1)->get();
            $profesores = Profesore::where('estatus', 1)->get();
            $estatusCreate = 0;
            $diasGrupo = Helpers::getArrayInputs($request->request, "dia") ?? [];
          
            $request['dias'] =  implode(',', $diasGrupo);
            $datoExiste = Helpers::datoExiste($request, ["grupos" => ["nombre", "", "nombre"]]);
            if(count($diasGrupo)){
                if (!$datoExiste) {
                    $estatusCreate = Grupo::create($request->all());
                }
            }
          
            $mensaje = $this->data->respuesta['mensaje'] = $estatusCreate ? "El Grupo se Creó correctamente."
                                                                          :"El nombre del Grupo ya existe, Cambie el nombre.";  
            $mensaje = $this->data->respuesta['mensaje'] = count($diasGrupo) ?  $mensaje 
                                                                             :  "Debe ingresar los Días de clases para el grupo de estudio";                                                                                       
            $estatus = $this->data->respuesta['estatus'] = $estatusCreate ? 200 : 301;

            $respuesta = $this->data->respuesta;

            return $estatusCreate ? redirect()->route('admin.grupos.index', compact('mensaje', 'estatus'))
                : view(
                    'admin.grupos.crear',
                    compact('request', 'notificaciones', 'usuario', 'respuesta', 'dias', 'niveles', 'profesores')
                );
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al intentar Registrar grupo en el método store,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function show(Grupo $grupo)
    {
        try {
      
            $grupo['profesor'] = Profesore::where('cedula', $grupo->cedula_profesor)->get()[0];
            $grupo['nivel'] = Nivele::where('codigo', $grupo->codigo_nivel)->get()[0];
            $grupo['matricula'] = GrupoEstudiante::where([
                'codigo_grupo' => $grupo->codigo,
                'estatus' => 1
            ])->get()->count();

            $grupo['estudiantes'] = GrupoEstudiante::where([
                'codigo_grupo' => $grupo->codigo,
                'estatus' => 1,
            ])->get();

            foreach ($grupo->estudiantes as $key => $est) {
                $grupo->estudiantes[$key] = Helpers::getEstudiante($est->cedula_estudiante);
                $grupo->estudiantes[$key]['id'] = $est->id; // se le asigna el id asignado en la tabla pibote para poceder a eliminar
            }
            // return $grupo;
            return view("admin.grupos.ver", compact('grupo'));
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error de Consulta de grupo en el método show,");
            return response()->view('errors.404', compact("errorInfo"), 404);
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
            $usuario = $this->data->usuario;
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
            return view('admin.grupos.editar', 
            compact('usuario', 'notificaciones', 'niveles', 'profesores', 'grupo', 'dias'));
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
            $request['dias'] = implode(',', Helpers::getArrayInputs($request->request, "dia"));
            
            $notificaciones = $this->data->notificaciones;
            $usuario = $this->data->usuario;
            $dias = $this->data->dias;
            $niveles = Nivele::where("estatus", 1)->get();
            $profesores = Profesore::where('estatus', 1)->get();
            $estatusUpdate = $grupo->update($request->all());
           
            $mensaje = $this->data->respuesta['mensaje'] = $estatusUpdate ? "El Grupo se Actualizó correctamente."
                : "El Grupo no sufrió ninguncambio.";
            $estatus = $this->data->respuesta['estatus'] = $estatusUpdate ? 200
                : 301;
            $respuesta = $this->data->respuesta;

            return $estatusUpdate ? redirect()->route('admin.grupos.index', compact('mensaje', 'estatus'))
                : view('admin.grupos.editar', 
                compact('request', 'notificaciones', 'usuario', 'respuesta', 'dias', 'profesores', 'niveles'));   
     
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al Actualizar grupo en el método update,");
            return response()->view('errors.404', compact("errorInfo"), 404);
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
            if ($grupo->update(["estatus" => 0])) {
                $mensaje = "Grupo Eliminado correctamente.";
                $estatus = 200;
                return redirect()->route( 'admin.grupos.index', compact('mensaje', 'estatus') );
            }
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al Eliminar grupo en el método destroy,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }
}
