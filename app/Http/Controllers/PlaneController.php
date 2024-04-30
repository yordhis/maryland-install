<?php

namespace App\Http\Controllers;

use App\Models\{
    Plane,
    DataDev,
    Helpers,
    Inscripcione
};

use App\Http\Requests\StorePlaneRequest;
use App\Http\Requests\UpdatePlaneRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

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
    public function index(Request $request)
    {
        try {
            $codigo = Helpers::getCodigo('planes');
            $notificaciones = $this->data->notificaciones;
            $respuesta = $this->data->respuesta;

            if($request->filtro){
                $planes = Plane::where('codigo', $request->filtro)
                ->orWhere('nombre', 'like', "%{$request->filtro}%")
                ->orderBy('id', 'desc')
                ->paginate(5);
            }else{
                $planes = Plane::orderBy('id', 'desc')->paginate(5);
            }
            return view(
                'admin.planes.lista',
                compact('planes', 'notificaciones', 'respuesta', 'request', 'codigo')
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
   
            $estatusCreate = 0;
                
            $estatusCreate = Plane::create($request->all());
            
            $mensaje = $estatusCreate ? "El Plan se guardo correctamente."
                : "El nombre del Plan Ya existe, Cambie el nombre.";

            $estatus = $estatusCreate ? 200
                : 301;

       

            return redirect( url()->previous() )->with([
                "mensaje" =>   $mensaje,
                "estatus" =>   $estatus
            ]);

        } catch (\Throwable $th) {
            $mensaje = Helpers::getMensajeError($th, "Error al intentar registrar un plan en el método store,");
            return redirect( url()->previous() )->with([
                "mensaje" =>   $mensaje,
                "estatus" =>   404
            ]);
          
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
        return redirect( url()->previous() )->with([
            "mensaje" =>   "Este método no esta disponible",
            "estatus" =>   301
        ]);
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
            $urlPrevious = url()->previous();
            return view('admin.planes.editar', compact('notificaciones', 'plane', 'urlPrevious'));
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

            $estatusUpdate = $plane->update($request->all());
           
            $mensaje = $this->data->respuesta['mensaje'] = $estatusUpdate ? "El Plan se Actualizó correctamente."
                : "El Plan no sufrió ninguncambio.";
            $estatus = $this->data->respuesta['estatus'] = $estatusUpdate ? 200
                : 404;
            $respuesta = $this->data->respuesta;

            return redirect( $request->urlPrevious )->with([
                "mensaje" =>   $mensaje,
                "estatus" =>   $estatus
            ]);
            // return $estatusUpdate ? redirect()->route('admin.planes.index', compact('mensaje', 'estatus'))
            //     : view('admin.planes.editar', compact('request', 'notificaciones', 'usuario', 'respuesta'));   
         
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
            $inscripciones = Inscripcione::where("codigo_plan", $plane->codigo)->get();
            if(count($inscripciones)){

                return back()->with([
                    "mensaje" => "No se puede eliminar el plan, porque esta asignados a registros inscripción.",
                    "estatus" => Response::HTTP_UNAUTHORIZED
                ]);

            }else{

                /** Eliminamos el plan */
                $plane->delete();
                return redirect( url()->previous() )->with([
                    "mensaje" =>  "El Plan se Eliminó correctamente.",
                    "estatus" =>  Response::HTTP_OK
                ]);
            }

        } catch (\Throwable $th) {
            $mensaje = Helpers::getMensajeError($th, "Error de al intentar Eliminar un nivel,");
            return redirect( url()->previous() )->with([
                "mensaje" =>   $mensaje ,
                "estatus" =>  Response::HTTP_INTERNAL_SERVER_ERROR
            ]);
        }
    }
}
