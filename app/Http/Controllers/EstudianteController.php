<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEstudianteRequest;
use App\Http\Requests\UpdateEstudianteRequest;


use App\Models\{
    Cuota,
    Estudiante,
    Representante,
    RepresentanteEstudiante,
    DificultadEstudiante,
    Dificultade,
    Helpers,
    DataDev
};
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;


class EstudianteController extends Controller
{

    public $data;

    /**
     * Constructor
     */
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
        if($request->filtro){
            $estudiantes =  Helpers::getEstudiantes($request);
        }else{
            $estudiantes =  Helpers::getEstudiantes();
        }
        $notificaciones =  $this->data->notificaciones;
        return view('admin.estudiantes.lista', compact('estudiantes', 'notificaciones', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $notificaciones = $this->data->notificaciones;
        return view('admin.estudiantes.crear', compact('notificaciones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEstudianteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEstudianteRequest $request)
    {
            // Validando cedula 
            $estatusCreate = 0;   
        
            // Configuramos las dificultades en un array
            $dificultadesInput = Helpers::getDificultades($request->request);

            // Validamos si se envio una foto
            if (isset($request->file)) {
                $request['foto'] = Helpers::setFile($request);
            }

            $estatusCreate = Estudiante::create($request->all());

            if ($estatusCreate) {
                // Validamos si existe el representante
                if (isset($request->rep_cedula)) {
                    if (isset($request->rep_nombre)) {
                        // Se crea y asigna el representante al estudiante
                        Helpers::setRepresentantes($request);
                    }else{
                        // Solo asignamos al representante
                        Helpers::asignarRepresentante($request->cedula, $request->rep_cedula);
                    }
                }

                if (isset($dificultadesInput)) {
                    /** Relacionamos los estudiante con la dificultad */
                    foreach ($dificultadesInput as $dificultad) {
                        DificultadEstudiante::create([
                            "cedula_estudiante" => $request->cedula,
                            "dificultad" => $dificultad->nombre,
                            "estatus" => $dificultad->estatus,
                        ]);
                    }
                }
            }
        

        $mensaje = $this->data->respuesta['mensaje'] = $estatusCreate ? "Estudiante registrado correctamente"
            : "No se pudo registrar verifique los datos.";
        $estatus = $this->data->respuesta['estatus'] =  $estatusCreate ? 201 : 404;

        $respuesta = $this->data->respuesta;
        $notificaciones =  $this->data->notificaciones;


        if(stripos(url()->previous(), '/inscripciones/estudiante')) return redirect()->route('admin.inscripciones.createEstudiante')->with([
            'mensaje'=> $mensaje, 
            'estatus'=> $estatus
        ]);
  

        return $estatusCreate ? redirect()->route('admin.estudiantes.index')->with([
                                'mensaje'=> $mensaje, 
                                'estatus'=> $estatus
                            ])
            : view('admin.estudiantes.crear', compact('respuesta', 'request', 'notificaciones'));
    }

  

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Estudiante  $estudiante
     * @return \Illuminate\Http\Response
     */
    public function edit(Estudiante $estudiante)
    {
        try {
            $urlPrevia = url()->previous();
            $representantes = RepresentanteEstudiante::where('cedula_estudiante', $estudiante->cedula)->get();
            $listDificultades = DificultadEstudiante::where('cedula_estudiante', $estudiante->cedula)->get();

            foreach ($representantes as  $repre) {
                $data = Representante::where('cedula', $repre['cedula_representante'])->get();
                $repre['data'] = $data[0];
            }
            $notificaciones = $this->data->notificaciones;
            return view('admin.estudiantes.editar', compact(
                'estudiante',
                'representantes',
                'listDificultades',
                'notificaciones',
                'urlPrevia'
            ));
        } catch (\Throwable $th) {
            //throw $th;
            $errorInfo = Helpers::getMensajeError($th, "Error al Consultar datos del estudiante en el método edit,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEstudianteRequest  $request
     * @param  \App\Models\Estudiante  $estudiante
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEstudianteRequest $request, Estudiante $estudiante)
    {

        try {
            // Validamos si se envio una foto
            if (isset($request->file)) {
                // Eliminamos la imagen anterior
                $fotoActual = explode('/', $estudiante->foto);
                if ($fotoActual[count($fotoActual) - 1] != 'default.jpg') {
                    Helpers::removeFile($estudiante->foto);
                }

                // Insertamos la nueva imagen o archivo
                $request['foto'] = Helpers::setFile($request);
            } else {
                $request['foto'] = $estudiante->foto;
            }
            
            // Editar cedula
            if(!empty($request->cedula)){
                if($estudiante->cedula != $request->cedula){
                    Helpers::updateCedula($estudiante->cedula, $request->cedula);
                }
            }

            // Actualizamos los datos de lestudiante
            $estudiante->update($request->all());


            // Actualizamos los datos del representante
            // validamos que la cedula no cambio
            if (isset($request->rep_cedula)) {
                if (isset($request->rep_nombre)) {
                    // Se crea y asigna el representante al estudiante
                    Helpers::setRepresentantes($request);
                }else{
                    // Solo asignamos al representante
                    Helpers::asignarRepresentante($request->cedula, $request->rep_cedula);
                }
                
            }

            // Configuramos las dificultades en un array y obtenemos
            $listDificultades = Helpers::getDificultades($request->request);

            // Seteamos las dificultades
            Helpers::setDificultades( $listDificultades, $request->cedula);

         
            return redirect($request->urlPrevia)->with(
                Response::HTTP_OK,
                "Los Datos del estudiante se guardaron correctamente"
            );
        } catch (\Throwable $th) {
            //throw $th;
            $this->data->respuesta['activo'] = true;
            $this->data->respuesta['mensaje'] = "Algo fallo al actualizar los datos del estudiante." . PHP_EOL
                . " Verifique este error: " . $th->getMessage() . PHP_EOL
                . "Codigo: " . $th->getCode() . PHP_EOL
                . "linea: " . $th->getLine();
            $this->data->respuesta['estatus'] = 404;
            $respuesta = $this->data->respuesta;
            $notificaciones = $this->data->notificaciones;
            
            $representantes = RepresentanteEstudiante::where('cedula_estudiante', $estudiante->cedula)->get();
            $listDificultades = DificultadEstudiante::where('cedula_estudiante', $estudiante->cedula)->get();

            foreach ($representantes as  $repre) {
                $data = Representante::where('cedula', $repre['cedula_representante'])->get();
                $repre['data'] = $data[0];
            }
            return view(
                'admin.estudiantes.editar',
                compact(
                    'notificaciones',
                    'respuesta',
                    'estudiante',
                    'representantes',
                    'listDificultades',

                )
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Estudiante  $estudiante
     * @return \Illuminate\Http\Response
     */
    public function destroy(Estudiante $estudiante)
    {

        try {

            Helpers::destroyData($estudiante->cedula, false,false, [
                "pagos" => true,
                "cuotas" => true,
                "inscripcione" => true,
                "grupoEstudiante" => true,
                "representanteEstudiante" => true,
                "dificultadEstudiante" => true,
            ]);

            $estudiante->delete();
            $mensaje = "El estudiante {$estudiante->nombre}, fue eliminado correctamente";
            $estatus = 200;
            return back();
        } catch (\Throwable $th) {
            $mensaje = "Error al intentar eliminar al estudiante {$estudiante->nombre}. \n"
                . "Verificar los siguientes errores: \n"
                . "Código de error: " . $th->getCode()
                . "Linea de error: " . $th->getLine()
                . "Archivo de error: " . $th->getFile();
            $estatus = 301;
            return redirect()->route('admin.estudiantes.index', compact('mensaje', 'estatus'));
        }
    }
}
