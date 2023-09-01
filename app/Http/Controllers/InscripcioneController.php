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
    Plane
};
use Barryvdh\DomPDF\Facade\PDF;
use Carbon\Carbon;
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
            $usuario = $this->data->usuario;

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
            return view('admin.inscripciones.lista', compact('notificaciones', 'usuario', 'inscripciones'));
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
            $notificaciones = $this->data->notificaciones;
            $usuario = $this->data->usuario;
            $codigo = Helpers::getCodigo('inscripciones');
            $planes = Plane::where("estatus", 1)->get();
            $grupos = Helpers::setMatricula(Grupo::where("estatus", 1)->get());

            return view('admin.inscripciones.crear', compact('notificaciones', 'usuario', 'planes', 'grupos', 'codigo'));
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
            // Validamos si este estudiante ya esta inscrito en ese grupo de estudio
            $datoExiste = Helpers::datoExiste($request, [
                "inscripciones" => [
                    "cedula_estudiante",
                    "AND codigo_grupo = {$request['codigo_grupo']}",
                    "cedula_estudiante",
                ],
            ]);
            $request['extras'] = implode(',', Helpers::getArrayInputs($request->request, 'ext'));
            $notificaciones = $this->data->notificaciones;
            $usuario = $this->data->usuario;
            $planes = Plane::where("estatus", 1)->get();
            $grupos = Helpers::setMatricula(Grupo::where("estatus", 1)->get());
            $estatusCreate = 0;
            $id = 0;
            if (!$datoExiste) {
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

            return $estatusCreate ? redirect("inscripciones/{$id}?mensaje={$mensaje}&estatus={$estatus}")
                : view(
                    'admin.inscripciones.crear',
                    compact('request', 'notificaciones', 'usuario', 'respuesta', 'planes', 'grupos')
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
            $notificaciones = $this->data->notificaciones;
            $usuario = $this->data->usuario;
            return view('admin.inscripciones.planilla', compact('notificaciones', 'usuario', 'estudiante', 'inscripcione'));
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al mostrar Planilla de Inscripción en el método show,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }

    public function planillapdf($cedula, $codigo)
    {

        try {
            $inscripcione = [];
            $data = new DataDev();
            $estudiante = Helpers::getEstudiante($cedula);
            foreach ($estudiante->inscripciones as $inscripcion) {
                if ($inscripcion->codigo == $codigo) $inscripcione = $inscripcion;
            }

            $notificaciones = $data->notificaciones;
            $usuario = $data->usuario;

            //     return view('admin.inscripciones.planillapdf', 
            //     compact(
            //        'inscripcione', 
            //        'notificaciones',
            //        'usuario',
            //        'estudiante'
            //    ));
            // Se genera el pdf
            $pdf = PDF::loadView(
                'admin.inscripciones.planillapdf',
                compact(
                    'inscripcione',
                    'notificaciones',
                    'usuario',
                    'estudiante'
                )
            );
            return $pdf->download("{$inscripcione->codigo}-{$inscripcione->cedula_estudiante}-{$inscripcione->fecha}.pdf");
        } catch (\Throwable $th) {
           
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
        return redirect()->route('admin.inscripciones.index');
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

            // Eliminamos al estudiante del grupo
            GrupoEstudiante::where([
                "cedula_estudiante" => $inscripcione->cedula_estudiante,
                "codigo_grupo" => $inscripcione->codigo_grupo,
            ])->update(["estatus" => 0]);

            // Borramos la inscripción
            $inscripcione->update(["estatus" => 0]);

            $mensaje = "Datos de Inscripción Eliminado correctamente.";
            $estatus = 200;
            return redirect()->route('admin.inscripciones.index', compact('mensaje', 'estatus'));
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al Eliminar datos de Inscripción en el método destroy,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }
}
