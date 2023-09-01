<?php

namespace App\Http\Controllers;

use App\Models\{
    Plane,
    DataDev,
    Helpers
};

use App\Http\Requests\StorePlaneRequest;
use App\Http\Requests\UpdatePlaneRequest;

class PlaneController extends Controller
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
            $respuesta = $this->data->respuesta;
            $planes = Plane::where('estatus', 1)->get();
            return view(
                'admin.planes.lista',
                compact('planes', 'notificaciones', 'usuario', 'respuesta')
            );
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error de consula en el método index,");
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
            $codigo = Helpers::getCodigo('planes');
            return view('admin.planes.crear', compact('notificaciones', 'usuario', 'codigo'));
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error de consula en el método create,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePlaneRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePlaneRequest $request)
    {
        try {
            $notificaciones = $this->data->notificaciones;
            $usuario = $this->data->usuario;
            $estatusCreate = 0;
            $datoExiste = Helpers::datoExiste($request, ["planes" => ["nombre", "", "nombre"]]);
            if (!$datoExiste) {
                $estatusCreate = Plane::create($request->all());
            }

            $mensaje = $this->data->respuesta['mensaje'] = $estatusCreate ? "El Plan se guardo correctamente."
                : "El nombre del Plan Ya existe, Cambie el nombre.";
            $estatus = $this->data->respuesta['estatus'] = $estatusCreate ? 200
                : 301;
            $respuesta = $this->data->respuesta;

            return $estatusCreate ? redirect()->route('admin.planes.index', compact('mensaje', 'estatus'))
                : view('admin.planes.crear', compact('request', 'notificaciones', 'usuario', 'respuesta'));
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al intentar registrar un plan en el método store,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plane  $plane
     * @return \Illuminate\Http\Response
     */
    public function show(Plane $plane)
    {
        return redirect()->route('admin.planes.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plane  $plane
     * @return \Illuminate\Http\Response
     */
    public function edit(Plane $plane)
    {
        try {
            $notificaciones = $this->data->notificaciones;
            $usuario = $this->data->usuario;
            return view('admin.planes.editar', compact('notificaciones', 'usuario', 'plane'));
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error de consula en el método edit,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePlaneRequest  $request
     * @param  \App\Models\Plane  $plane
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePlaneRequest $request, Plane $plane)
    {
        try {
            $notificaciones = $this->data->notificaciones;
            $usuario = $this->data->usuario;
            $estatusUpdate = $plane->update($request->all());
           
            $mensaje = $this->data->respuesta['mensaje'] = $estatusUpdate ? "El Plan se Actualizó correctamente."
                : "El Plan no sufrió ninguncambio.";
            $estatus = $this->data->respuesta['estatus'] = $estatusUpdate ? 200
                : 404;
            $respuesta = $this->data->respuesta;

            return $estatusUpdate ? redirect()->route('admin.planes.index', compact('mensaje', 'estatus'))
                : view('admin.planes.editar', compact('request', 'notificaciones', 'usuario', 'respuesta'));   
         
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al intentar actualizar Plan en el método update,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plane  $plane
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plane $plane)
    {
        try {
            $plane->update(["estatus" => 0]);
            $mensaje = "El Plan se Eliminó correctamente.";
            $estatus = 200;
            return redirect()->route( 'admin.planes.index', compact('mensaje', 'estatus') );
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error de al intentar Eliminar un nivel,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }
}
