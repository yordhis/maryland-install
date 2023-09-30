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


class EstudianteController extends Controller
{

    public $respuesta;
    public $notificaciones;
    public $usuario;
    public $estudiantes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $data = new DataDev;
        $this->respuesta = $data->respuesta;

        $this->notificaciones = $data->notificaciones;

        $this->usuario = $data->usuario;

        $this->estudiantes = Helpers::getEstudiantes();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estudiantes =  $this->estudiantes;
        return view('admin.estudiantes.lista', compact('estudiantes'));
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
        return view('admin.estudiantes.crear', compact('notificaciones', 'usuario'));
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
        $datoExiste = Helpers::datoExiste($request, [
            "estudiantes" => ["cedula", " AND estatus = 1 ", "cedula"]
        ]);



        // Localizando si el estudiante es inactivo en la DB
        $estudianteInactivo = Helpers::datoExiste($request, [
            "estudiantes" => ["cedula", " AND estatus = 0 ", "cedula"]
        ]);


        // si el estudiante existe pero esta inactivo se porcede a activar y actualizar datos
        if ($estudianteInactivo) {
            $request['estatus'] = 1;
            // Validamos si se envio una foto
            if (isset($request->file)) {
                $request['foto'] = Helpers::setFile($request);
            }

            // Se activa el estudiante y se actualiza la data
            $estatusCreate = Estudiante::where('cedula', $estudianteInactivo->cedula)->update([
                "estatus" => $request->estatus,
                "nombre" => $request->nombre,
                "nacionalidad" => $request->nacionalidad,
                "correo" => $request->correo,
                "telefono" => $request->telefono,
                "nacimiento" => $request->nacimiento,
                "direccion" => $request->direccion,
                "edad" => $request->edad,
                "foto" => $request->foto ?? FOTO_PORDEFECTO,
            ]);

            if ($estatusCreate) {
                // Validamos si existe el representante
                if (isset($request->rep_cedula)) {
                    // Se crea y asigna el representante al estudiante
                    Helpers::setRepresentantes($request);
                }
                // Configuramos las dificultades en un array
                $listDificultades = Helpers::getDificultades($request->request);
                if (isset($listDificultades)) {
                    /** Relacionamos los estudiante con la dificultad */
                    // Recorremos las dificultades para actualizar las o crear si no existe
                   Helpers::setDificultades($listDificultades, $request->cedula);
                }
            }
        }

        // Si el estudiante no esta en la DB se procede a crear
        if (!$datoExiste && !$estudianteInactivo) {
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
                    // Se crea y asigna el representante al estudiante
                    Helpers::setRepresentantes($request);
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
        }

        $cedulaAlert = $datoExiste ? $datoExiste->cedula = number_format($datoExiste->cedula, 0, ',', '.') : '';

        $mensaje = $this->respuesta['mensaje'] = $estatusCreate ? "Estudiante registrado correctamente"
            : "La cédula ingresada ya esta registrada con {$datoExiste->nombre} - V-{$datoExiste->cedula}, por favor vuelva a intentar con otra cédula.";
        $estatus = $this->respuesta['estatus'] =  $estatusCreate ? 201 : 301;

        $respuesta = $this->respuesta;

        return $estatusCreate ? redirect()->route('admin.estudiantes.index', compact('mensaje', 'estatus'))
            : view('admin.estudiantes.crear', compact('respuesta', 'request'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Estudiante  $estudiante
     * @return \Illuminate\Http\Response
     */
    public function show(Estudiante $estudiante)
    {
        //
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

            $representantes = RepresentanteEstudiante::where('cedula_estudiante', $estudiante->cedula)->get();
            $listDificultades = DificultadEstudiante::where('cedula_estudiante', $estudiante->cedula)->get();

            foreach ($representantes as  $repre) {
                $data = Representante::where('cedula', $repre['cedula_representante'])->get();
                $repre['data'] = $data[0];
            }

            return view('admin.estudiantes.editar', compact(
                'estudiante',
                'representantes',
                'listDificultades'
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
            
            if($estudiante->cedula != $request->cedula){
                Helpers::updateCedula($estudiante->cedula, $request->cedula);
            }

            // Actualizamos los datos de lestudiante
            $estudiante->update($request->all());


            // Actualizamos los datos del representante
            // validamos que la cedula no cambio
            if (isset($request->rep_cedula)) {
                // Seteamos los representantes
                Helpers::setRepresentantes($request);
                // obtenemos la relacion del estudiante con el representante
                // $cedulaDeRelacion = RepresentanteEstudiante::where('cedula_estudiante', $estudiante->cedula)->get();
                // if (count($cedulaDeRelacion)) {
                //     // Cedula del representante ya relacionado con el estudiante
                //     $cedulaRepre = $cedulaDeRelacion[0]['cedula_representante'];

                //     // Comparamos si la cedula no cambio
                //     if ($cedulaRepre !== $request->rep_cedula) {
                //         // En caso de que cambio el representante se actualiza la cedula de relacion
                //         $r = RepresentanteEstudiante::where('cedula_representante', $cedulaRepre)
                //             ->update([
                //                 "cedula_representante" => $request->rep_cedula
                //             ]);
                //             /** Se Actualiza el representante */
                //             Representante::where("cedula", $cedulaRepre)->update([
                //                 "nombre" => $request->rep_nombre,
                //                 "cedula" => $request->rep_cedula,
                //                 "edad" => $request->rep_edad,
                //                 "ocupacion" => $request->rep_ocupacion,
                //                 "telefono" => $request->rep_telefono,
                //                 "direccion" => $request->rep_direccion,
                //                 "correo" => $request->rep_correo,
                //             ]);
                //     }
                // } else {
                //     // creamos el representante
                //     $r = Representante::create([
                //         "nombre" => $request->rep_nombre,
                //         "cedula" => $request->rep_cedula,
                //         "edad" => $request->rep_edad,
                //         "ocupacion" => $request->rep_ocupacion,
                //         "telefono" => $request->rep_telefono,
                //         "direccion" => $request->rep_direccion,
                //         "correo" => $request->rep_correo,
                //     ]);

                //     if ($r) {
                //         /** Relacionamos los estudiante con el representante */
                //         RepresentanteEstudiante::create([
                //             "cedula_estudiante" => $request->cedula,
                //             "cedula_representante" => $request->rep_cedula
                //         ]);
                //     }
                // }
            }

            // Configuramos las dificultades en un array y obtenemos
            $listDificultades = Helpers::getDificultades($request->request);

            // Seteamos las dificultades
            Helpers::setDificultades( $listDificultades, $request->cedula);


            return redirect()->route('admin.estudiantes.index', [
                "estatus" => 200,
                "mensaje" => "Los Datos del estudiante se guardaron correctamente"
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            $this->respuesta['activo'] = true;
            $this->respuesta['mensaje'] = "Algo fallo al actualizar los datos del estudiante." . PHP_EOL
                . " Verifique este error: " . $th->getMessage() . PHP_EOL
                . "Codigo: " . $th->getCode() . PHP_EOL
                . "linea: " . $th->getLine();
            $this->respuesta['estatus'] = 404;
            $respuesta = $this->respuesta;
            $notificaciones = $this->notificaciones;
            $usuario = $this->usuario;
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
                    'usuario',
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

            $estudiante->update(['estatus' => 0]);
            $mensaje = "El estudiante {$estudiante->nombre}, fue eliminado correctamente";
            $estatus = 200;
            return redirect()->route('admin.estudiantes.index', compact('mensaje', 'estatus'));
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
