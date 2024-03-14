<?php

namespace App\Http\Controllers;

//Modelos
use App\Models\{
    Profesore,
    Helpers,
    DataDev
};

use App\Http\Requests\StoreProfesoreRequest;
use App\Http\Requests\UpdateProfesoreRequest;


class ProfesoreController extends Controller
{
    public $respuesta;
    public $notificaciones;
    public $usuario;
    public $profesores;

    /**
     * Constructor
     */
     public function __construct(){
        $data = new DataDev();

        $this->respuesta= $data->respuesta;

        $this->notificaciones =  $data->notificaciones;

        $this->usuario =  $data->usuario;
        
        $this->profesores= Profesore::where('estatus', '!=', 0)->orderBy('id','DESC')->get();
     }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profesores = $this->profesores;
        $usuario = $this->usuario;
        $notificaciones = $this->notificaciones;

        return view('admin.profesores.lista', compact('notificaciones', 'usuario', 'profesores') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usuario = $this->usuario;
        $notificaciones = $this->notificaciones;
        return view('admin.profesores.crear', compact('notificaciones', 'usuario'));
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

        
        $this->respuesta['mensaje'] = $estatusCreate ? "Profesor registrado correctamente"
                                    : "La cédula ingresada ya esta registrada con {$datoExiste->nombre} - V-{$datoExiste->cedula}, por favor vuelva a intentar con otra cédula.";
        $this->respuesta['estatus'] = $estatusCreate ? 201 : 301;
       
        $profesores = Profesore::where('estatus', '!=', 0)->orderBy('id','DESC')->get();
        $respuesta = $this->respuesta;
        $notificaciones = $this->notificaciones;

        return $estatusCreate ? view('admin.profesores.lista', compact('notificaciones', 'respuesta', 'profesores'))
        : view('admin.profesores.crear', compact('notificaciones', 'respuesta', 'request'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profesore  $profesore
     * @return \Illuminate\Http\Response
     */
    public function show(Profesore $profesore)
    {
        //redireccionamos a la lista
        return redirect()->route('admin.profesores.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profesore  $profesore
     * @return \Illuminate\Http\Response
     */
    public function edit(Profesore $profesore)
    {
        $notificaciones = $this->notificaciones;
        return view('admin.profesores.editar', compact('profesore', 'notificaciones'));
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
        if($profesore->update($request->all())){
            $this->respuesta['estatus']=200;
            $this->respuesta['mensaje']="Datos Guardados Correctamente";
            $respuesta = $this->respuesta;
            $usuario = $this->usuario;
            $notificaciones = $this->notificaciones;
        }
        $profesores = Profesore::where('estatus', '!=', 0)->orderBy('id','DESC')->get();
        
        return view('admin.profesores.lista', compact('notificaciones', 'usuario', 'respuesta', 'profesores'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profesore  $profesore
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profesore $profesore)
    {
        $profesore->update([
            "estatus" => 0
        ]);
        $mensaje = "el profesor fue eliminado correctamente.";
        $estatus = 200;
        return redirect()->route('admin.profesores.index', compact('mensaje', 'estatus'));
    }
}
