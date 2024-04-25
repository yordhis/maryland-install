<?php

namespace App\Http\Controllers;

use App\Models\{
    Pago,
    Estudiante,
    Cuota,
    Concepto,
    Helpers,
    DataDev,
    Grupo,
    Inscripcione
};
use Barryvdh\DomPDF\Facade\PDF;
use App\Http\Requests\StorePagoRequest;
use App\Http\Requests\UpdatePagoRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;

class PagoController extends Controller
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
            $pagos = Pago::where('estatus', 1)->orderBy('codigo', 'desc')->get();
            foreach ($pagos as $key => $pago) {
                $pago['estudiante'] = Helpers::getEstudiante($pago->cedula_estudiante);
                $array = explode(',', $pago->monto);
                $pago->monto = $array[0] . "Bs | " . $array[1] . "$";
            }
            return view('admin.pagos.lista', compact('notificaciones', 'usuario', 'pagos'));
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al Consultar lista de pago en el método index,");
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
            $metodos = $this->data->metodosPagos;
            $codigo = Helpers::getCodigo('pagos');
            $conceptos = Concepto::where("estatus", 1)->get();
            return view('admin.pagos.crear', compact('notificaciones', 'usuario', 'conceptos', 'metodos', 'codigo'));
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al Consultar datos para crear el pago en el método create,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }

    public function getPagoEstudiante($request, $codigoInscripcion)
    {
     
        try {
            $notificaciones = $this->data->notificaciones;
            $metodos = $this->data->metodosPagos;
            $codigo = Helpers::getCodigo('pagos');
            $conceptos = Concepto::where('estatus', 1)->get();
            $estudiante = Estudiante::where("cedula", $request)->get();
            return view('admin.pagos.crear', compact('conceptos', 'notificaciones', 'metodos', 'codigo', "estudiante", 'codigoInscripcion'));
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al Consultar datos de pago del estudiante en el método getPagoEstudiante,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePagoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePagoRequest $request)
    {
       
        try {
            return $request;
            // configuramos las cuotas, metodos y monto para ser almacenados
            $cuotas = Helpers::getArrayInputs($request->request, 'cuo') ?  Helpers::getArrayInputs($request->request, 'cuo') : [0];
            $codigoGrupo = count(Cuota::where('id', $cuotas[0])->get()) ? Cuota::where('id', $cuotas[0])->get()[0]->codigo_grupo : 0;

            $metodos = Helpers::getArrayInputs($request->request, 'met');
            $monto = Helpers::getArrayInputs($request->request, 'mon');
            $request['id_cuota'] = implode(',', $cuotas);
            $request['metodo'] = implode(',', $metodos);
            $request['monto'] = implode(',', $monto);
            $request['codigo_grupo'] =  $codigoGrupo;
            $estatusPago = 0;
            $id = 0;
            // Se registra el pago
            $estatusPago = Pago::create($request->all());

            if ($estatusPago) {
                // Asignamos el id para renderizar
                $id =  $estatusPago->id;

                // Actualizar las cuotas pagadas
                foreach ($cuotas as $cuota) {
                    Cuota::where(["id" => $cuota])->update(["estatus" => 1]);
                }
                // verificamos si todas las cuotas fueron pagadas
                // Para actualizar el estatus de la inscripcion del estudiante
                // a completado
                $cuotas = Cuota::where([
                    "cedula_estudiante" => $request['cedula_estudiante'],
                    "codigo_grupo" => $request['codigo_grupo']
                ])->get();

                $contador = 0;

                // Contamos las cuotas pagadas
                foreach ($cuotas as $cuota) {
                    if ($cuota['estatus'] == 1) $contador++;
                }

                // Comparamos si las cuotyas pagadas son igual alas cuotas creadas
                // para cambiar el estatus de la inscripcion
                if ($contador == count($cuotas)) {
                    Inscripcione::where([
                        "cedula_estudiante" => $request['cedula_estudiante'],
                        "codigo_grupo" => $request['codigo_grupo']
                    ])->update(["estatus" => 3]);
                }
            }
            
            $mensaje = $this->data->respuesta['mensaje'] = $estatusPago ? "¡El Pago del estudiante se proceso correctamente!"
                : "No se pudo procesar el pago, por favor vuelva a intentar.";

            $estatus = $this->data->respuesta['estatus'] = $estatusPago ? 201 : 301;

            $respuesta = $this->data->respuesta;

            return $estatusPago ? redirect("pagos/{$id}?mensaje={$mensaje}&estatus={$estatus}&codigoInscripcion={$request->codigoInscripcion}")
                : view(
                    'admin.pagos.crear',
                    compact('request', 'respuesta', 'planes', 'grupos')
                );
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al Consultar datos de pago del estudiante en el método getPagoEstudiante,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pago  $pago
     * @return \Illuminate\Http\Response
     */
    public function show(Pago $pago)
    {
        try {
            $notificaciones = $this->data->notificaciones;
            $metodos = $this->data->metodosPagos;
            $pago['estudiante'] = Helpers::getEstudiante($pago->cedula_estudiante);
            $pago->id_cuota = explode(",", $pago->id_cuota);
            $pago->monto = explode(",", $pago->monto);

            // Configuramos los horarios
            $pago['horario'] = null;
            foreach ($pago->id_cuota as $key => $cuotaPagada) {
                foreach ($pago['estudiante']['inscripciones'] as $key => $inscripcion) {

                    foreach ($inscripcion['cuotas'] as $key => $cuota) {
                        if ($cuotaPagada == $cuota['id']) {
                            foreach ($pago['estudiante']['grupos'] as $key => $grupo) {
                                if ($cuota['codigo_grupo'] == $grupo['codigo']) {
                                    $pago['horario'] = [
                                        "dias" => $grupo['dias'],
                                        "horas" => $grupo['hora_inicio'] . " - " . $grupo['hora_fin']
                                    ];
                                    break;
                                }
                            }
                            break;
                        }
                    }
                }
            }

            // Configuramos los metodos de pago 
            $metodosPagos = explode(",", $pago->metodo);
            foreach ($metodosPagos as $metodosPago) {
                foreach ($metodos as $key => $metodo) {
                    if ($metodo['metodo'] == $metodosPago) {
                        $metodos[$key]["activo"] = true;
                        break;
                    }
                }
            }

            // return $pago;
            return view('admin.pagos.recibo', compact('pago', 'metodos', 'notificaciones'));
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al Consultar datos de pago del estudiante en el método show,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }

    public function recibopdf($request)
    {
        try {
            // obtenemos los datos del pago
            $pago = count(Pago::where('id', $request)->get())  ? Pago::where('id', $request)->get()[0] : false;

            if ($pago) {
                $notificaciones = $this->data->notificaciones;
                $usuario = $this->data->usuario;
                $metodos = $this->data->metodosPagos;
                $pago['estudiante'] = Helpers::getEstudiante($pago->cedula_estudiante);
                $pago->id_cuota = explode(",", $pago->id_cuota);
                $pago->monto = explode(",", $pago->monto);

                // Configuramos los horarios
                $pago['horario'] = null;
                foreach ($pago->id_cuota as $key => $cuotaPagada) {
                    foreach ($pago['estudiante']['inscripciones'] as $key => $inscripcion) {

                        foreach ($inscripcion['cuotas'] as $key => $cuota) {
                            if ($cuotaPagada == $cuota['id']) {
                                foreach ($pago['estudiante']['grupos'] as $key => $grupo) {
                                    if ($cuota['codigo_grupo'] == $grupo['codigo']) {
                                        $pago['horario'] = [
                                            "dias" => $grupo['dias'],
                                            "horas" => $grupo['hora_inicio'] . " - " . $grupo['hora_fin']
                                        ];
                                        break;
                                    }
                                }
                                break;
                            }
                        }
                    }
                }

                // Configuramos los metodos de pago 
                $metodosPagos = explode(",", $pago->metodo);
                foreach ($metodosPagos as $metodosPago) {
                    foreach ($metodos as $key => $metodo) {
                        if ($metodo['metodo'] == $metodosPago) {
                            $metodos[$key]["activo"] = true;
                            break;
                        }
                    }
                }

                // Codigo para previsualizar el pdf
                // return view('admin.pagos.recibopdf',  compact('pago', 'metodos'));
                // Se genera el pdf
                $pdf = PDF::loadView('admin.pagos.recibopdf', compact('pago', 'metodos', 'notificaciones'));
                return $pdf->download("{$pago->cedula_estudiante}-{$pago->fecha}.pdf");
            } else {
                // en caso de que el recibo no existe redireccionamos a la lista de pago 
                // con un mensaje
                $mensaje  = "El recibo de pago no existe, por favor vuelva a intentar.";
                $estatus  = 301;
                return redirect("pagos?mensaje={$mensaje}&estatus={$estatus}");
            }
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al Generar PDF del Pago del estudiante en el método recibopdf,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pago  $pago
     * @return \Illuminate\Http\Response
     */
    public function edit(Pago $pago)
    {
       return redirect("pagos");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePagoRequest  $request
     * @param  \App\Models\Pago  $pago
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePagoRequest $request, Pago $pago)
    {
        return redirect("pagos");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pago  $pago
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pago $pago)
    {
        try {
     
            // Cambiamos de estado las cuotas del pago
            $pago->id_cuota = explode(",", $pago->id_cuota);
            if ($pago->id_cuota[0] > 0) {
                foreach ($pago->id_cuota as $key => $cuota) {
                    Cuota::where("id", $cuota)->update(["estatus" => 0]);
                }
            }

            // Eliminamos el pago
            $pago->delete();

            // Redireccionamos con una respuesta
            $mensaje = "El Pago del estudiante se eliminó correctamente.";
            $estatus = 200;
            return redirect("pagos?mensaje={$mensaje}&estatus={$estatus}");

        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al Eliminar el Pago del estudiante en el método destroy,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }
}
