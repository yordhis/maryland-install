<?php

namespace App\Http\Controllers;

use App\Models\{
    Nivele,
    Helpers,
    DataDev,
    Grupo,
    Inscripcione
};
use App\Http\Requests\StoreNiveleRequest;
use App\Http\Requests\UpdateNiveleRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
    public function index(Request $request)
    {
        try {
            $codigo = Helpers::getCodigo('niveles');
            $notificaciones = $this->data->notificaciones;
            $respuesta = $this->data->respuesta;
            if($request->filtro){
                $niveles = Nivele::where("codigo", $request->filtro)
                ->orWhere('nombre', 'like', "%{$request->filtro}%")
                ->orWhere('libro', 'like', "%{$request->filtro}%")
                ->orWhere('precio', 'like', "%{$request->filtro}%")
                ->orderBy("codigo", "desc")->paginate(12);

            }else{
                $niveles = Nivele::orderBy("codigo", "desc")->paginate(12);
            }
            return view( 'admin.niveles.lista', compact('niveles', 'notificaciones', 'codigo', 'request', 'respuesta') );

        } catch (\Throwable $th) {
            //throw $th;
            $errorInfo = Helpers::getMensajeError($th, "Error de consula,");
            return back()->with([
                "mensaje" => $errorInfo,
                "estatus" => Response::HTTP_INTERNAL_SERVER_ERROR
            ]);
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
            
            $estatusCreate = 0;
            $datoExiste = Helpers::datoExiste($request, ["niveles" => ["nombre","","nombre"]]);
            if(!$datoExiste){
                $estatusCreate = Nivele::create($request->all());
            }
            $mensaje = $estatusCreate ? "El nivel se Registró correctamente."
                                      : "El nombre del Nivel Ya existe, Cambie el nombre.";
            $estatus = $estatusCreate ? Response::HTTP_OK 
                                      : Response::HTTP_UNAUTHORIZED;
    
            return back()->with([
                "mensaje" => $mensaje,
                "estatus" => $estatus
            ]);
        
            
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al intentar crear un nivel,");
            return back()->with([
                "mensaje" => $errorInfo,
                "estatus" => Response::HTTP_INTERNAL_SERVER_ERROR
            ]);
        }
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
            $notificaciones = $this->data->notificaciones;
            $respuesta = $this->data->respuesta;

            return view('admin.niveles.editar', compact('notificaciones', 'nivele'));
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
                $estatus = Response::HTTP_OK;    
            }else{
                $mensaje = "¡El nivel NO se pudo actualizar!.";
                $estatus = Response::HTTP_UNAUTHORIZED;    
            }

            return redirect()->route('admin.niveles.index')->with([
                "mensaje" => $mensaje,
                "estatus" => $estatus
            ]);
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error de al intentar Actualizar un nivel,");
            return back('admin.niveles.index')->with([
                "mensaje" => $errorInfo,
                "estatus" => $estatus
            ]);
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
           

            $grupos = Grupo::where("codigo_nivel", $nivele->codigo)->get();
            
            if(count($grupos)){

                return back()->with([
                    "mensaje" => "No se puede eliminar el nivel, porque esta asignados a un grupo de estudio.",
                    "estatus" => Response::HTTP_UNAUTHORIZED
                ]);

            }else{

                /** Eliminamos el nivel */
                $nivele->delete();
                return back()->with([
                    "mensaje" =>  "El Nivel se Eliminó correctamente.",
                    "estatus" =>  Response::HTTP_OK
                ]);
            }
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error de al intentar Eliminar un nivel,");
            return back()->with([
                "mensaje" =>  $errorInfo,
                "estatus" =>  Response::HTTP_INTERNAL_SERVER_ERROR
            ]);
        }
    }
}
