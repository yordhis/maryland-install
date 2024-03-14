<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInscripcioneRequest;
use App\Http\Requests\UpdateInscripcioneRequest;
use App\Models\{
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
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;

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
    public function index()
    {
        try {
            // Retorna la lista de inscripciones
            // donde el estatus es 3 = completado que hace referencia a que los pagos de
            // de la inscripción estan listo
            $notificaciones = $this->data->notificaciones;

            // Obtenemos todas las inscripciones que poseen el estatus completado
            $inscripciones = Helpers::addDatosDeRelacion(
                Inscripcione::where("estatus", ">=", 1)
                    ->orderBy('codigo', 'desc')
                    ->get(),
                [
                    "estudiantes" => "cedula_estudiante",
                    "grupos" => "codigo_grupo",
                    "planes" => "codigo_plan",
                ]
            );

            // Obtenemos los datos del  grupo de la inscripcion
            foreach ($inscripciones as $key => $inscripcion) {
                $inscripcion['grupo'] = Helpers::addDatosDeRelacion(
                    Helpers::setConvertirObjetoParaArreglo($inscripcion['grupo']),
                    [
                        "niveles" => "codigo_nivel",
                        "profesores" => "cedula_profesor",
                    ]
                );
                $inscripcion['grupo'] = $inscripcion['grupo'][0];
            }

            // Obtenemos toda las cuotas
            foreach ($inscripciones as $key => $inscripcion) {
                $inscripcion['cuotas'] = Cuota::where(
                    [
                        'cedula_estudiante' => $inscripcion['cedula_estudiante'],
                        'codigo_grupo' => $inscripcion['codigo_grupo'],
                    ]
                )->get();
                $totalAbonado = 0;
                foreach ($inscripcion['cuotas'] as $key => $cuota) {
                    if ($cuota['estatus'] == "1") {
                        $totalAbonado += $cuota['cuota'];
                    }
                }
                $inscripcion['totalAbonado'] = $totalAbonado;
                $inscripcion['estatusText'] = $this->data->estatus[$inscripcion['estatus']];

                // activamos para asignar nota
                $inscripcion['estatusDeAsignacionDeNota'] = 0;
                $fechaCulminacionDeCurso = Carbon::createMidnightDate(date('Y-m-d'));
                if ($fechaCulminacionDeCurso->diffInDays($inscripcion['grupo']['fecha_fin'], false) <= 0) {
                    $inscripcion['estatusDeAsignacionDeNota'] = 1;
                }
            }

            // return $inscripciones;
            return view('admin.inscripciones.lista', compact('inscripciones', 'notificaciones'));
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al Consultar Inscripciones en el método index,");
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
            $codigo = Helpers::getCodigo('inscripciones');
            $planes = Plane::where("estatus", 1)->get();
            $grupos = Helpers::setMatricula(Grupo::where("estatus", 1)->get());
            
            $notificaciones = $this->data->notificaciones;
            return view('admin.inscripciones.crear', compact('planes', 'grupos', 'codigo', 'notificaciones'));
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al Consultar Inscripciones en el método create,");
            return response()->view('errors.404', compact("errorInfo"), 404);
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
            $planes = Plane::where("estatus", 1)->get();
            $grupos = Helpers::setMatricula(Grupo::where("estatus", 1)->get());
            $estatusCreate = 0;
            $id = 0;
            // el estudiante existe
            $estudianteExiste = Helpers::datoExiste($request, [
                "estudiantes" => [
                    "cedula",
                    "",
                    "cedula_estudiante",
                ],
            ]);
            // validamos si los datos del estudiante estan en el sistema
            if ($estudianteExiste) {

                // Validamos si este estudiante ya esta inscrito en ese grupo de estudio
                $datoExiste = Helpers::datoExiste($request, [
                    "inscripciones" => [
                        "cedula_estudiante",
                        "AND codigo_grupo = {$request['codigo_grupo']}",
                        "cedula_estudiante",
                    ],
                ]);

                if (!$datoExiste) {
                    // Estraemos los datos extras de la planilla de inscripcion
                    $request['extras'] = implode(',', Helpers::getArrayInputs($request->request, 'ext'));

                    // Registramos la incripcion
                    $estatusCreate = Inscripcione::create($request->all());
                    
                    $id =  $estatusCreate->id;
                    // Asignamos al estudiante al grupo
                    GrupoEstudiante::create([
                        "cedula_estudiante" => $request->cedula_estudiante,
                        "codigo_grupo" => $request->codigo_grupo,
                    ]);
                    
                    // Creamos las cuotas y registramos
                    Helpers::registrarCuotas(Helpers::getCuotas($request));
                    
                }


                $mensaje = $this->data->respuesta['mensaje'] = $estatusCreate ? "¡La inscripción del estudiante se proceso correctamente!"
                    : "El estudiante ya esta inscrito en este grupo de estudio (Código del grupo: {$datoExiste->codigo_grupo} - {$datoExiste->cedula_estudiante})";

                $estatus = $this->data->respuesta['estatus'] = $estatusCreate ? 200 : 301;

                $respuesta = $this->data->respuesta;
                $notificaciones = $this->data->notificaciones;
                return $estatusCreate ? redirect("inscripciones/{$id}?mensaje={$mensaje}&estatus={$estatus}")
                    : view(
                        'admin.inscripciones.crear',
                        compact('request', 'respuesta', 'planes', 'grupos', 'notificaciones')
                    );
            } else {
                // Cuando el estudiante no esta registrado retorna el boton de registrar estudiante
              

                $this->data->respuesta['mensaje'] = "¡El estudiante no esta registrado en el sistema, Por favor proceda a registrarlo!";
                $this->data->respuesta['estatus'] = 404;
                $respuesta = $this->data->respuesta;

                return view(
                    'admin.inscripciones.crear',
                    compact('request', 'respuesta', 'planes', 'grupos')
                );
            }
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al Procesar Inscripción en el método store,");
            return response()->view('errors.404', compact("errorInfo"), 404);
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
            $notificaciones = $this->data->notificaciones;
            $inscripcione = [];
            $data = new DataDev();
            $estudiante = Helpers::getEstudiante($cedula);
            foreach ($estudiante->inscripciones as $inscripcion) {
                if ($inscripcion->codigo == $codigo) $inscripcione = $inscripcion;
            }
           
            $inscripcione = Helpers::setFechasHorasNormalizadas($inscripcione); 
         
            //     return view('admin.inscripciones.planillapdf', 
            //     compact(
            //        'inscripcione', 
            //        'estudiante'
            //    ));
            // Se genera el pdf
            $pdf = PDF::loadView(
                'admin.inscripciones.planillapdf',
                compact(
                    'inscripcione',
                    'estudiante',
                    'notificaciones'
                )
            );
            return $pdf->download("{$inscripcione->codigo}-{$inscripcione->cedula_estudiante}-{$inscripcione->fecha}.pdf");
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

            Helpers::destroyData($inscripcione->cedula_estudiante, $inscripcione->codigo_grupo, [
                "pagos" => true,
                "cuotas" => true,
                "inscripcione" => false,
                "grupoEstudiante" => true,
            ]);

            // Borramos la inscripción
            $inscripcione->delete();

            $mensaje = "Datos de Inscripción Eliminado correctamente.";
            $estatus = 200;
            return redirect()->route('admin.inscripciones.index', compact('mensaje', 'estatus'));
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al Eliminar datos de Inscripción en el método destroy,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }
}
