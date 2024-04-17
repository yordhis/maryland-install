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




            // return $inscripciones;
            return view('admin.inscripciones.lista', compact('inscripciones', 'notificaciones'));
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
            return view('admin.inscripciones.crearEstudiante', compact('notificaciones'));
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al Consultar Inscripciones en el método create,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }

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
            /** Datos para la vista */
            $planes = Plane::where("estatus", 1)->get();
            $grupos = Helpers::setMatricula(Grupo::where("estatus", 1)->get());

            /** Convertimos los estudiantes a un array */
            $request['estudiantes'] = explode(',', $request->estudiantes);

            /** Declaramos variables globales */
            $estatusCreate = false;
            $idInscripciones = [];

            /** Buscamos en el grupo asignado si el estudiante ya esta incluido */
            $datoExiste = Helpers::datoExiste($request, [
                "inscripciones" => [
                    "cedula_estudiante",
                    "AND codigo_grupo = {$request['codigo_grupo']}",
                    "cedula_estudiante",
                ],
            ]);
            /** Validamos si este estudiante ya esta inscrito en ese grupo de estudio */
            if (!$datoExiste) {
                // Estraemos los datos extras de la planilla de inscripcion
                $request['extras'] = implode(',', Helpers::getArrayInputs($request->request, 'ext'));

                /** Registramos la incripcion */
                foreach ($request->estudiantes as $key => $cedulaEstudiante) {
                    $estatusCreate = Inscripcione::create([
                        "codigo" => $request->codigo, 
                        "cedula_estudiante" => $cedulaEstudiante,
                        "codigo_grupo" => $request->codigo_grupo, 
                        "codigo_plan" => $request->codigo_plan,
                        "fecha" => $request->fecha ,
                        "extras" => $request->extras,
                        "total" => $request->total ?? 0,
                        "abono" => $request->abono ?? 0,
                    ]);

                    array_push( $idInscripciones, $estatusCreate->id );

                    GrupoEstudiante::create([
                        "cedula_estudiante" => $cedulaEstudiante,
                        "codigo_grupo" => $request->codigo_grupo,
                    ]);
                }

              
            }


            $mensaje = $this->data->respuesta['mensaje'] = $estatusCreate ? "¡La inscripción del estudiante se proceso correctamente!"
                : "El estudiante ya esta inscrito en este grupo de estudio (Código del grupo: {$datoExiste->codigo_grupo} - {$datoExiste->cedula_estudiante})";

            $estatus = $this->data->respuesta['estatus'] = $estatusCreate ? 200 : 301;

            $respuesta = $this->data->respuesta;
            $notificaciones = $this->data->notificaciones;

            return $idInscripciones;
            return $estatusCreate ? redirect("inscripciones/{$id}")->with([
                "mensaje" => $mensaje,
                "estatus" => $estatus
            ])
                : view(
                    'admin.inscripciones.crear',
                    compact('request', 'respuesta', 'planes', 'grupos', 'notificaciones')
                );
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
