<?php

namespace App\Http\Controllers;

//Modelos
use App\Models\{
    Profesore,
    Helpers,
    DataDev,
    Grupo
};

use App\Http\Requests\StoreProfesoreRequest;
use App\Http\Requests\UpdateProfesoreRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProfesoreController extends Controller
{
    public $data;

    /**
     * Constructor
     */
     public function __construct(){
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
            if($request->filtro){

                $profesores = Profesore::where('cedula', $request->filtro)
                ->orWhere('nombre', 'LIKE', "%{$request->filtro}%")  
                ->orWhere('edad', 'LIKE', "%{$request->filtro}%")  
                ->orWhere('correo', 'LIKE', "%{$request->filtro}%")
                ->orderBy('id', 'desc')
                ->paginate(12);  
    
            }else{
                $profesores =  Profesore::orderBy('id', 'desc')->paginate(12);
            }

            foreach ($profesores as $key => $profesor) {
                $profesor['grupos_estudios'] = Grupo::where('cedula_profesor', $profesor->cedula)->get();
            }

       
            $notificaciones = $this->data->notificaciones;
            $respuesta = $this->data->respuesta;
    
            return view('admin.profesores.lista', compact('notificaciones', 'request', 'profesores', 'respuesta') );
        } catch (\Throwable $th) {
            $mensaje = Helpers::getMensajeError($th, ', ¡Error interno al intentar listar los profesores!');
            $estatus = Response::HTTP_INTERNAL_SERVER_ERROR;
            return back()->with(compact('mensaje', 'estatus'));
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProfesoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProfesoreRequest $request)
    {
       
        $estatusCreate = 0;
        $datoExiste = Helpers::datoExiste($request, [
            "profesores" => ["cedula", "", "cedula"]
        ]);
        $cedulaAlert = $datoExiste ? $datoExiste->cedula = number_format($datoExiste->cedula,0,',','.') : '';
        
        if (!$datoExiste) {
            
            if(isset($request->file)){
                $request['foto'] = Helpers::setFile($request);
            }
            $estatusCreate = Profesore::create($request->all());
        }

        
        $mensaje = $estatusCreate ? "Profesor registrado correctamente"
                                    : "La cédula ingresada ya esta registrada con {$datoExiste->nombre} - V-{$datoExiste->cedula}, por favor vuelva a intentar con otra cédula.";
        $estatus = $estatusCreate ? Response::HTTP_OK : Response::HTTP_UNAUTHORIZED;
       

        return back()->with( compact('mensaje', 'estatus') );
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profesore  $profesore
     * @return \Illuminate\Http\Response
     */
    public function edit(Profesore $profesore)
    {
        $notificaciones = $this->data->notificaciones;
        $respuesta = $this->data->respuesta;
        return view('admin.profesores.editar', compact('profesore', 'notificaciones', 'respuesta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProfesoreRequest  $request
     * @param  \App\Models\Profesore  $profesore
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfesoreRequest $request, Profesore $profesore)
    {
       try {
            /** verificamos si cambio la cedula */
            if($request->cedula != $profesore->cedula){
                Grupo::where('cedula_profesor', $profesore->cedula)
                ->update([
                    "cedula_profesor" => $request->cedula
                ]);
            }

           // Validamos si se envio una foto
           if (isset($request->file)) {
                // Eliminamos la imagen anterior
                Helpers::removeFile($profesore->foto);
                 
                // Insertamos la nueva imagen o archivo
                $request['foto'] = Helpers::setFile($request);
            }else{
                $request['foto'] = $profesore->foto;
            }
    
            // Ejecutamos la actualizacion (Guardamos los cambios)
            $profesore->update( $request->all() );

            //respuesta
            $mensaje = "Los datos del profesor se actualizaron correctamente.";
            $estatus = Response::HTTP_OK;
            return back()->with(compact('mensaje', 'estatus'));
    
       } catch (\Throwable $th) {
            $mensaje = Helpers::getMensajeError($th, ', ¡Error interno al intentar actualizar el profesor!');
            $estatus = Response::HTTP_INTERNAL_SERVER_ERROR;
            return back()->with(compact('mensaje', 'estatus'));
       }
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profesore  $profesore
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profesore $profesore)
    {
        try {

            /** validar que el profesor no este asignado a ningun grupo */
            $gruposAsignados = Grupo::where('cedula_profesor', $profesore->cedula)->get();
            if(count($gruposAsignados)){
                $mensaje = "el profesor tiene grupos de estudios asignados, debes cambiar de profesor en el grupo o eliminar el grupo para poder eliminar al profesor.";
                $estatus = Response::HTTP_UNAUTHORIZED;
                return back()->with( compact('mensaje', 'estatus') );
            }

            /** Eliminamos al profesor */
            $profesore->delete();

            $mensaje = "el profesor fue eliminado correctamente.";
            $estatus = Response::HTTP_OK;
            return back()->with( compact('mensaje', 'estatus') );
         
        } catch (\Throwable $th) {
            $mensaje = Helpers::getMensajeError($th, ', ¡Error interno al intentar eliminar el profesor!');
            $estatus = Response::HTTP_INTERNAL_SERVER_ERROR;
            return back()->with(compact('mensaje', 'estatus'));
        }
    }
}
