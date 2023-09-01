<?php

namespace App\Http\Controllers;

use App\Models\{
    Concepto,
    DataDev,
    Helpers
};
use App\Http\Requests\StoreConceptoRequest;
use App\Http\Requests\UpdateConceptoRequest;


class ConceptoController extends Controller
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
            $conceptos = Concepto::all();
            foreach ($conceptos as $key => $value) {
                $value->estatus = $value->estatus ? "Activo" : "Inactivo";
            }
            return view('admin.conceptos.lista', compact('notificaciones', 'usuario', 'conceptos'));
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al Consultar lista de Conceptos de pago en el método index,");
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
            return view('admin.conceptos.crear', compact('notificaciones', 'usuario'));
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al Consultar datos Conceptos de pago en el método create,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreConceptoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreConceptoRequest $request)
    {
        try {
            $request['descripcion'] = trim(strtoupper($request['descripcion']));
            $request['codigo'] = trim(strtoupper($request['codigo']));
            $notificaciones = $this->data->notificaciones;
            $usuario = $this->data->usuario;
            $estatusCreate = 0;
            $datoExiste = Helpers::datoExiste($request, ["conceptos" => ["codigo", "", "codigo"]]);
            if (!$datoExiste) {
                $estatusCreate = Concepto::create($request->all());
            }
            $mensaje = $this->data->respuesta['mensaje'] = $estatusCreate ? "El Concepto se Registró correctamente."
                : "El Código del Concepto ¡Ya existe!, Cambie el Código por favor.";
            $estatus = $this->data->respuesta['estatus'] = $estatusCreate ? 200
                : 301;
            $respuesta = $this->data->respuesta;
            return $estatusCreate ? redirect()->route('admin.conceptos.index', compact('mensaje', 'estatus'))
                : view('admin.conceptos.crear', compact('request', 'notificaciones', 'usuario', 'respuesta'));
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al Registrar datos de Conceptos de pago en el método store,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Concepto  $concepto
     * @return \Illuminate\Http\Response
     */
    public function show(Concepto $concepto)
    {
        redirect()->route('admin.niveles.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Concepto  $concepto
     * @return \Illuminate\Http\Response
     */
    public function edit(Concepto $concepto)
    {
        try {
            $notificaciones = $this->data->notificaciones;
            $usuario = $this->data->usuario;
            return view('admin.conceptos.editar', compact('notificaciones', 'usuario', 'concepto'));
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al Consultar datos de Conceptos de pago en el método edit,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateConceptoRequest  $request
     * @param  \App\Models\Concepto  $concepto
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateConceptoRequest $request, Concepto $concepto)
    {
        try {
            $request['estatus'] =  $request['estatus'] ?? 0;
            $concepto->update($request->all());
            $mensaje = "El Concepto de pago se actualizó correctamente.";
            $estatus =  200;
            return redirect()->route('admin.conceptos.index', compact('mensaje', 'estatus'));
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al Actualizar los datos de Conceptos de pago en el método update,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Concepto  $concepto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Concepto $concepto)
    {
        try {
            $concepto->update(["estatus" => 0 ]);
            $mensaje = "El Concepto de pago se Eliminó correctamente.";
            $estatus =  404;
            return redirect()->route('admin.conceptos.index', compact('mensaje', 'estatus'));
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al intentar Eliminar los datos de Conceptos de pago en el método destroy,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }
}
