<?php

namespace App\Http\Controllers;

use App\Models\{
    Nivele,
    Helpers,
    DataDev
};
use App\Http\Requests\StoreNiveleRequest;
use App\Http\Requests\UpdateNiveleRequest;

class NiveleController extends Controller
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
            $dataDev = new DataDev;
            $notificaciones = $dataDev->notificaciones;
            $usuario = $dataDev->usuario;
            $niveles = Nivele::where('estatus', '>=', 1)->orderBy("codigo", "desc")->get();
            return view( 'admin.niveles.lista', compact('niveles', 'notificaciones', 'usuario') );

        } catch (\Throwable $th) {
            //throw $th;
            $errorInfo = Helpers::getMensajeError($th, "Error de consula,");
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
            $dataDev = new DataDev;
            $notificaciones = $dataDev->notificaciones;
            $usuario = $dataDev->usuario;
            $codigo = Helpers::getCodigo('niveles');
            return view('admin.niveles.crear', compact('notificaciones', 'usuario', 'codigo'));
        } catch (\Throwable $th) {
            //throw $th;
            $errorInfo = Helpers::getMensajeError($th, "Error de consula,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNiveleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNiveleRequest $request)
    {
        try {
            $notificaciones = $this->data->notificaciones;
            $usuario = $this->data->usuario;
            $estatusCreate = 0;
            $datoExiste = Helpers::datoExiste($request, ["niveles" => ["nombre","","nombre"]]);
            if(!$datoExiste){
                $estatusCreate = Nivele::create($request->all());
            }
            $mensaje = $this->data->respuesta['mensaje'] = $estatusCreate ? "El nivel se Registró correctamente."
                                      : "El nombre del Nivel Ya existe, Cambie el nombre.";
            $estatus = $this->data->respuesta['estatus'] = $estatusCreate ? 200 
                                      : 301;
            $respuesta = $this->data->respuesta;
            return $estatusCreate ? redirect()->route('admin.niveles.index', compact('mensaje', 'estatus'))
                                  : view('admin.niveles.crear', compact('request', 'notificaciones', 'usuario', 'respuesta') );
            
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al intentar crear un nivel,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Nivele  $nivele
     * @return \Illuminate\Http\Response
     */
    public function show(Nivele $nivele)
    {
        return redirect()->route('admin.niveles.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Nivele  $nivele
     * @return \Illuminate\Http\Response
     */
    public function edit(Nivele $nivele)
    {
        try {
            $data = new DataDev;
            $notificaciones = $data->notificaciones;
            $usuario = $data->usuario;
            return view('admin.niveles.editar', compact('notificaciones', 'usuario', 'nivele'));
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error de consula,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNiveleRequest  $request
     * @param  \App\Models\Nivele  $nivele
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNiveleRequest $request, Nivele $nivele)
    {
        try {
            if($nivele->update($request->all())){
                $mensaje = "El nivel se Actualizó correctamente.";
                $estatus = 200;
                return redirect()->route('admin.niveles.index', compact('mensaje', 'estatus'));
            }
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error de al intentar Actualizar un nivel,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Nivele  $nivele
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nivele $nivele)
    {
        try {
            $nivele->update(["estatus" => 0]);
            $mensaje = "El nivel se Eliminó correctamente.";
            $estatus = 200;
            return redirect()->route( 'admin.niveles.index', compact('mensaje', 'estatus') );
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error de al intentar Eliminar un nivel,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }
}
