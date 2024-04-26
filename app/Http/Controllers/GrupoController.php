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

            if ($request->filtro) {
                $grupos = Grupo::join('profesores', 'profesores.cedula', '=', "grupos.cedula_profesor")
                    ->join('niveles', 'niveles.codigo', '=', "grupos.codigo_nivel")
                    ->select(
                        'grupos.*',
                        'niveles.nombre as nivel_nombre',
                        'niveles.precio as nivel_precio',
                        'niveles.libro as nivel_libro',
                        'niveles.duracion as nivel_duracion',
                        'niveles.tipo_duracion as nivel_tipo_duracion',
                        'profesores.nombre as profesor_nombre',
                        'profesores.nacionalidad as profesor_nacionalidad',
                        'profesores.cedula as profesor_cedula',
                        'profesores.telefono as profesor_telefono',
                        'profesores.correo as profesor_correo',
                        'profesores.edad as profesor_edad',
                        'profesores.nacimiento as profesor_nacimiento',
                        'profesores.direccion as profesor_direccion',
                        'profesores.foto as profesor_foto',
                    )
                    ->where('grupos.codigo', $request->filtro)
                    ->orWhere('grupos.nombre', 'like', "%{$request->filtro}%")
                    ->orWhere('grupos.cedula_profesor', 'like', "%{$request->filtro}%")
                    ->orWhere('profesores.nombre', 'like', "%{$request->filtro}%")
                    ->orderBy('id', 'desc')
                    ->paginate(12);
            } else {
                $grupos = Grupo::join('profesores', 'profesores.cedula', '=', "grupos.cedula_profesor")
                    ->join('niveles', 'niveles.codigo', '=', "grupos.codigo_nivel")
                    ->select(
                        'grupos.*',
                        'niveles.nombre as nivel_nombre',
                        'niveles.precio as nivel_precio',
                        'niveles.libro as nivel_libro',
                        'niveles.duracion as nivel_duracion',
                        'niveles.tipo_duracion as nivel_tipo_duracion',
                        'profesores.nombre as profesor_nombre',
                        'profesores.nacionalidad as profesor_nacionalidad',
                        'profesores.cedula as profesor_cedula',
                        'profesores.telefono as profesor_telefono',
                        'profesores.correo as profesor_correo',
                        'profesores.edad as profesor_edad',
                        'profesores.nacimiento as profesor_nacimiento',
                        'profesores.direccion as profesor_direccion',
                        'profesores.foto as profesor_foto',
                    )
                    ->paginate(12);
            }



            /** Agregamos informacion del grupo com lista de estudiantes y matricula total */
            foreach ($grupos as $grupo) {
                $grupoEstudiante = GrupoEstudiante::join('estudiantes', 'estudiantes.cedula', '=', 'grupo_estudiantes.cedula_estudiante')
                    ->select(
                        'grupo_estudiantes.cedula_estudiante',
                        'estudiantes.nombre as estudiante_nombre',
                        'estudiantes.edad as estudiante_edad',
                        'estudiantes.nacionalidad as estudiante_nacionalidad',
                        'estudiantes.telefono as estudiante_telefono',
                        'estudiantes.correo as estudiante_correo',
                        'estudiantes.direccion as estudiante_direccion',
                        'estudiantes.nacimiento as estudiante_nacimiento',
                        'estudiantes.foto as estudiante_foto'
                    )
                    ->where([
                        'grupo_estudiantes.codigo_grupo' => $grupo->codigo
                    ])->get();

                $grupo['matricula'] = $grupoEstudiante->count();
                $grupo['estudiantes'] = $grupoEstudiante;
            }



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
        $grupos = Grupo::join('profesores', 'profesores.cedula', '=', "grupos.cedula_profesor")
            ->join('niveles', 'niveles.codigo', '=', "grupos.codigo_nivel")
            ->select(
                'grupos.*',
                'niveles.nombre as nivel_nombre',
                'niveles.precio as nivel_precio',
                'niveles.libro as nivel_libro',
                'niveles.duracion as nivel_duracion',
                'niveles.tipo_duracion as nivel_tipo_duracion',
                'profesores.nombre as profesor_nombre',
                'profesores.nacionalidad as profesor_nacionalidad',
                'profesores.cedula as profesor_cedula',
                'profesores.telefono as profesor_telefono',
                'profesores.correo as profesor_correo',
                'profesores.edad as profesor_edad',
                'profesores.nacimiento as profesor_nacimiento',
                'profesores.direccion as profesor_direccion',
                'profesores.foto as profesor_foto',
            )
            ->where('grupos.codigo', $codigoGrupo)
            ->orderBy('id', 'desc')
            ->get();

        /** Agregamos informacion del grupo com lista de estudiantes y matricula total */
        foreach ($grupos as $grupo) {
            $grupoEstudiante = GrupoEstudiante::join('estudiantes', 'estudiantes.cedula', '=', 'grupo_estudiantes.cedula_estudiante')
                ->select(
                    'grupo_estudiantes.cedula_estudiante',
                    'estudiantes.nombre as estudiante_nombre',
                    'estudiantes.edad as estudiante_edad',
                    'estudiantes.nacionalidad as estudiante_nacionalidad',
                    'estudiantes.telefono as estudiante_telefono',
                    'estudiantes.correo as estudiante_correo',
                    'estudiantes.direccion as estudiante_direccion',
                    'estudiantes.nacimiento as estudiante_nacimiento',
                    'estudiantes.foto as estudiante_foto'
                )
                ->where([
                    'grupo_estudiantes.codigo_grupo' => $grupo->codigo
                ])->get();

            $grupo['matricula'] = $grupoEstudiante->count();
            $grupo['estudiantes'] = $grupoEstudiante;
        }

        return $grupos;
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
     * Display the specified resource.
     *
     * @param  \App\Models\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function show(Grupo $grupo)
    {
        try {
            $notificaciones = $this->data->notificaciones;
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


            return view("admin.grupos.ver", compact('grupo', 'notificaciones'));
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
                return redirect()->route('admin.grupos.index', compact('mensaje', 'estatus'));
            }
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al Eliminar grupo en el método destroy,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }
}
