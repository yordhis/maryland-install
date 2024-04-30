<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInscripcioneRequest;
use App\Http\Requests\UpdateInscripcioneRequest;
use App\Models\{
    Concepto,
    DataDev,
    Cuota,
    Grupo,
    GrupoEstudiante,
    Helpers,
    Inscripcione,
    Pago,
    Plane
};
use Barryvdh\DomPDF\Facade\PDF;
use Carbon\Carbon;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class InscripcioneController extends Controller
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
    public function index(HttpRequest $request)
    {
        try {
            // Retorna la lista de inscripciones
            // donde el estatus es 3 = completado que hace referencia a que los pagos de
            // de la inscripción estan listo
            $notificaciones = $this->data->notificaciones;
            $respuesta = $this->data->respuesta;
            $metodos = $this->data->metodosPagos;
            $codigoDePago = Helpers::getCodigo('pagos');
            $conceptos = Concepto::where("estatus", 1)->get();

            $inscripciones = Helpers::getInscripciones($request->filtro);
            // return $inscripciones;
            return view(
                'admin.inscripciones.lista',
                compact(
                    'inscripciones',
                    'notificaciones',
                    'respuesta',
                    'request',
                    'codigoDePago',
                    'conceptos',
                    'metodos'
                )
            );
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al Consultar Inscripciones en el método index,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }

    /**
     * VISTA DE INGRESAR CEDULA DEL ESTUDIANTE
     * SI EXISTE REDIRECCIONA A PROCESAR INSCRIPCIÓN
     * SI NO SE DESPLIEGA EL FORMULARIO DE REGISTRO DE ESTUDIANTE
     */
    public function createEstudiante()
    {
        try {

            $notificaciones = $this->data->notificaciones;
            $respuesta = $this->data->respuesta;
            return view('admin.inscripciones.crearEstudiante', compact('notificaciones', 'respuesta'));
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al Consultar Inscripciones en el método create,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }

    public function create()
    {
        try {
            $respuesta = $this->data->respuesta;
            $notificaciones = $this->data->notificaciones;
            $codigo = Helpers::getCodigo('inscripciones');
            $planes = Plane::where("estatus", 1)->get();
            $grupos = Helpers::setMatricula(Grupo::where("estatus", 1)->get());

            return view('admin.inscripciones.crear', compact('planes', 'grupos', 'codigo', 'notificaciones', 'respuesta'));
        } catch (\Throwable $th) {

            $mensaje = Helpers::getMensajeError($th, "Error al Consultar Inscripciones en el método create,");
            $estatus = Response::HTTP_INTERNAL_SERVER_ERROR;
            return  redirect()->route('admin.inscripciones.index')->with([
                "mensaje" => $mensaje,
                "estatus" => $estatus
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreInscripcioneRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInscripcioneRequest $request)
    {
        try {
            /** quitamos las comas de codigos y cedulas estudiantes */
            $request['estudiantes'] = substr($request->estudiantes, 0, strlen($request->estudiantes) -1 );
            $request['codigo'] = substr($request->codigo, 0, strlen($request->codigo) -1 );
         
            /** Convertimos los estudiantes a un array */
            $datosCuotas = [];
            $estudiantes = explode(',', $request->estudiantes);
            $codigos = explode(',', $request->codigo);
            $datosCuotas = Helpers::getInputsEnArray($request, ['monto_', 'fecha_']);

            /** Declaramos variables globales */
            $estatusCreate = false;
            $estudianteCapturado = [];
            $mensajeDeEstudiantesCapturados = "";
            $preMensaje = "El estudiante ya esta inscrito en este grupo de estudio.";

            /** Buscamos en el grupo asignado si el estudiante ya esta incluido */
            foreach ($estudiantes as $key => $cedula) {
                $capturado = Inscripcione::where([
                    "cedula_estudiante" => $cedula,
                    "codigo_grupo" =>  $request->codigo_grupo
                ])->get();
                if (count($capturado)) {
                    array_push(
                        $estudianteCapturado,
                        $capturado
                    );

                    $mensajeDeEstudiantesCapturados .= "(Código del grupo: {$capturado[0]->codigo_grupo} - Estudiante: {$capturado[0]->cedula_estudiante})";
                }
            }

            /** Cambiamos el mensaje de estudiantes encontrados */
            if (count($estudianteCapturado) > 1) $preMensaje = "Los estudiantes ya están registrados en el grupo seleccionado.";

            /** Validamos si este estudiante ya esta inscrito en ese grupo de estudio */
            if (count($estudianteCapturado) == 0) {
                // Estraemos los datos extras de la planilla de inscripcion
                $request['extras'] = implode(',', Helpers::getArrayInputs($request->request, 'ext'));

                /** Registramos la incripcion, asignamosel grupo y registramos las cuotas */
                foreach ($estudiantes as $keyCedula => $cedulaEstudiante) {

                    $estatusCreate = Inscripcione::create([
                        "codigo" => $codigos[$keyCedula] ?? $codigos[0],
                        "cedula_estudiante" => $cedulaEstudiante,
                        "codigo_grupo" => $request->codigo_grupo,
                        "codigo_plan" => $request->codigo_plan,
                        "fecha" => $request->fecha,
                        "extras" => $request->extras,
                        "total" => floatval($request->total) ?? 0
                    ]);

                    GrupoEstudiante::create([
                        "cedula_estudiante" => $cedulaEstudiante,
                        "codigo_grupo" => $request->codigo_grupo,
                    ]);

                    foreach ($datosCuotas as $cuota) {

                        Cuota::create([
                            "cedula_estudiante" => $cedulaEstudiante,
                            "codigo_inscripcion" => $codigos[$keyCedula] ?? $codigos[0],
                            "fecha" =>  $cuota['fecha'],
                            "cuota" => $cuota['monto'], // monto
                        ]);
                    }
                }
            }


            $mensaje = $this->data->respuesta['mensaje'] = $estatusCreate ? "¡La inscripción del estudiante se proceso correctamente!"
                : "{$preMensaje} {$mensajeDeEstudiantesCapturados}";

            $estatus = $this->data->respuesta['estatus'] = $estatusCreate ? 200 : 301;

            return $estatusCreate   ? redirect()->route('admin.inscripciones.index')->with([
                "mensaje" => $mensaje,
                "estatus" => $estatus
            ])
                : redirect()->route('admin.inscripciones.create')->with([
                    "mensaje" => $mensaje,
                    "estatus" => $estatus
                ]);
        } catch (\Throwable $th) {
            $mensaje = Helpers::getMensajeError($th, "Error al Procesar Inscripción en el método store,");
            $estatus = Response::HTTP_INTERNAL_SERVER_ERROR;
            return  redirect()->route('admin.inscripciones.create')->with([
                "mensaje" => $mensaje,
                "estatus" => $estatus
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inscripcione  $inscripcione
     * @return \Illuminate\Http\Response
     */
    public function show(Inscripcione $inscripcione)
    {
        try {

            $estudiante = Helpers::getEstudiante($inscripcione['cedula_estudiante']);
            foreach ($estudiante->inscripciones as $inscripcion) {
                if ($inscripcion->codigo == $inscripcione->codigo) $inscripcione = $inscripcion;
            }
            $inscripcione = Helpers::setFechasHorasNormalizadas($inscripcione);
            $notificaciones = $this->data->notificaciones;
            return view('admin.inscripciones.planilla', compact('estudiante', 'inscripcione', 'notificaciones'));
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al mostrar Planilla de Inscripción en el método show,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }

    public function planillapdf($cedula, $codigo)
    {

        try {
            $estudiantes=[];
            $inscripciones = Inscripcione::join('grupos', 'grupos.codigo', '=', 'inscripciones.codigo_grupo')
            ->join('estudiantes', 'estudiantes.cedula', '=', 'inscripciones.cedula_estudiante')
            ->join('planes', 'planes.codigo', '=', 'inscripciones.codigo_plan')
            ->join('profesores', 'profesores.cedula', '=', 'grupos.cedula_profesor')
            ->join('niveles', 'niveles.codigo', '=', 'grupos.codigo_nivel')
            ->select(
                'inscripciones.id', 
                'inscripciones.codigo', 
                'inscripciones.cedula_estudiante', 
                'inscripciones.codigo_grupo', 
                'inscripciones.codigo_plan', 
                'inscripciones.nota', 
                'inscripciones.extras', 
                'inscripciones.total', 
                'inscripciones.abono', 
                'inscripciones.fecha', 
                'inscripciones.estatus', 
                'grupos.codigo_nivel',
                'grupos.cedula_profesor',
                'grupos.nombre as grupo_nombre',
                'grupos.dias as grupo_dias',
                'grupos.hora_inicio as grupo_hora_inicio',
                'grupos.hora_fin as grupo_hora_fin',
                'grupos.fecha_inicio as grupo_fecha_inicio',
                'grupos.fecha_fin as grupo_fecha_fin',
                'profesores.nombre as grupo_profesor_nombre',
                'profesores.nacionalidad as grupo_profesor_nacionalidad',
                'profesores.edad as grupo_profesor_edad',
                'profesores.telefono as grupo_profesor_telefono',
                'niveles.nombre as nivel_nombre',
                'niveles.precio as nivel_precio',
                'niveles.libro as nivel_libro',
                'niveles.duracion as nivel_duracion',
                'niveles.tipo_duracion as nivel_tipo_duracion',
                'planes.nombre as plan_nombre',
                'planes.cantidad_cuotas as plan_cantidad_cuotas',
                'planes.plazo as plan_plazo',
                'planes.descripcion as plan_descripcion',
                'estudiantes.nombre as estudiante_nombre',
                'estudiantes.nacionalidad as estudiante_nacionalidad',
                'estudiantes.telefono as estudiante_telefono',
                'estudiantes.correo as estudiante_correo',
                'estudiantes.nacimiento as estudiante_nacimiento',
                'estudiantes.edad as estudiante_edad',
                'estudiantes.direccion as estudiante_direccion',
                'estudiantes.grado as estudiante_grado',
                'estudiantes.ocupacion as estudiante_ocupacion',
                'estudiantes.foto as estudiante_foto'
            )
            ->where('inscripciones.codigo', $codigo)
            ->orderBy('inscripciones.codigo' , 'desc')
            ->get();

            foreach ($inscripciones as $key => $inscripcion) {
                array_push( $estudiantes, Helpers::getEstudiante($inscripcion->cedula_estudiante)[0] );
            }
            /** normalizar fecha y horas */
            Helpers::setFechasHorasNormalizadas($inscripciones[0]);

            /**
             * [0] = ¿promoción? @values si o no
             * [1] = explique @values @string
             * [2] = ¿Se entrego material? @values si o no
             * [3] = ¿cómo se enteró del curso? @values @string
             * [4] = observación @values @string
             */
            $inscripciones[0]->extras = explode(',', $inscripciones[0]->extras);

            // return view(
            //     'admin.inscripciones.planillapdf',
            //     compact(
            //         'inscripciones',
            //         'estudiantes'
            //     )
            // );
            // Se genera el pdf
            $pdf = PDF::loadView(
                'admin.inscripciones.planillapdf',
                compact(
                    'inscripciones',
                    'estudiantes',
                  
                )
            );
            return $pdf->download("{$inscripciones[0]->codigo}-{$inscripciones[0]->cedula_estudiante}-{$inscripciones[0]->fecha}.pdf");
        } catch (\Throwable $th) {
            dd();
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inscripcione  $inscripcione
     * @return \Illuminate\Http\Response
     */
    public function edit(Inscripcione $inscripcione)
    {
        return redirect()->route('admin.inscripciones.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInscripcioneRequest  $request
     * @param  \App\Models\Inscripcione  $inscripcione
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInscripcioneRequest $request, Inscripcione $inscripcione)
    {
        try {
            $estatusUpdate = 0;
            // Editamos la observación
            $datosExtras = explode(",", $inscripcione->extras);
            $datosExtras[4] = $request->observacion;
            $datosExtras = implode(",", $datosExtras);
            $estatusUpdate = $inscripcione->update(["extras" => $datosExtras]);
            $estudiante = Helpers::getEstudiante($inscripcione->cedula_estudiante);

            $mensaje = $this->data->respuesta['mensaje'] = $estatusUpdate
                ? "¡La Oservación de la planilla de inscripción del estudiante {$estudiante->nombre} de cédula: {$estudiante->cedula} se proceso correctamente!"
                : "La observación No registro correctamente, por favor vuelva a intentar y si el error persiste llame a soporte.";
            $estatus = $this->data->respuesta['estatus'] = $estatusUpdate ? 200 : 404;
            $respuesta = $this->data->respuesta;

            return redirect("inscripciones/?mensaje={$mensaje}&estatus={$estatus}");
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al Actulizar la Oservación de la Planilla de Inscripción en el método update,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inscripcione  $inscripcione
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inscripcione $inscripcione)
    {
        try {

            Helpers::destroyData($inscripcione->cedula_estudiante, $inscripcione->codigo, $inscripcione->codigo_grupo,[
                "pagos" => true,
                "cuotas" => true,
                "inscripcione" => false,
                "grupoEstudiante" => true,
            ]);

            // Borramos la inscripción
            $inscripcione->delete();

            $mensaje = "Datos de Inscripción Eliminado correctamente.";
            $estatus = Response::HTTP_OK;
            return redirect()->route('admin.inscripciones.index')->with([
                "mensaje" => $mensaje,
                "estatus" => $estatus
            ]);
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al Eliminar datos de Inscripción en el método destroy,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }
}
