<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEstudianteRequest;
use App\Http\Requests\StorePageRequest;
use App\Models\DataDev;
use App\Models\DificultadEstudiante;
use App\Models\Estudiante;
use App\Models\Helpers;
use App\Models\Nivele;
use App\Models\Plane;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $planes = Plane::all();
        $niveles = Nivele::all();
        return view('page.index', compact('planes', 'niveles'));
    }

    /**
     * PÁGINA DE PREINCRIPCIÓN SELECCIÓN DEL PLAN
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $niveles = Nivele::all();
        $planes = Plane::where('estatus', 2)->get();
        $nivelSolicitado = Nivele::where('codigo', $request->codigo_nivel)->get();
        return view('page.preinscripcion', compact('niveles', 'planes', 'request', 'nivelSolicitado'));
    }

    /**
     * RUTA PARA SETEAR DATOS DE ESTUDIANTE EXISTENTE EN LA SESIÓN
     * 
     * @return @session('estudiantesInscriptos')
     */

     public function setDatosEnSesionEstudiante($idEstudiante){
        $estudiantesInscriptos = session('estudiantesInscriptos') ?? [];
        array_push( $estudiantesInscriptos, Estudiante::find($idEstudiante) );

        session([ 
            'estudiantesInscriptos' => $estudiantesInscriptos,
            'totalDeRegistros' => count($estudiantesInscriptos),
        ]);

        return back();
     }

    /**
     * PÁGINA DE PREINCRIPCIÓN REGISTRO DEL ESTUDIANTE
     *
     * @return \Illuminate\Http\Response
     */

    public function createEstudiante(Request $request)
    {
        try {
            $respuestaTail = DataDev::$respuestaTail;
            $nivelSolicitado = Nivele::where('codigo', $request->codigo_nivel)->get();
            $planSolicitado = Plane::where('codigo', $request->codigo_plan)->get();
            $totalDeRegistros = session('totalDeRegistros') ?? 0;
            return view('page.estudiantePreinscripcion', compact('request', 'nivelSolicitado', 'planSolicitado', 'respuestaTail', 'totalDeRegistros'));
            
        } catch (\Throwable $th) {
           $estatus = Response::HTTP_INTERNAL_SERVER_ERROR;
           $mensaje = Helpers::getMensajeError($th, ", ¡Error interno al intentar acceder a la vista de preincripción!");
           return back()->with(compact('estatus', 'mensaje'));
        }
    }

    /**
     * Crear estudiante desde la página.
     *
     * @param  \Illuminate\Http\StorePageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePageRequest $request)
    {
        /** lo puedo hacer guardando los datos en la sessión */
        try {
            // Validando cedula 
            $estudiante = 0;
            $estudiantesInscriptos = session('estudiantesInscriptos') ?? [];

            // Configuramos las dificultades en un array
            $dificultadesInput = Helpers::getDificultades($request->request);

            // Validamos si se envio una foto
            if (isset($request->file)) {
                $request['foto'] = Helpers::setFile($request);
            }

            // registramos el estudiante
            $estudiante = Estudiante::create($request->all());

            if ($estudiante) {
                // Validamos si existe el representante
                if (isset($request->rep_cedula)) {
                    if (isset($request->rep_nombre)) {
                        // Se crea y asigna el representante al estudiante
                        Helpers::setRepresentantes($request);
                    } else {
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


            $mensaje =  $estudiante   ? "Estudiante registrado correctamente"
                : "No se pudo registrar verifique los datos.";
            $estatus = $estudiante ? Response::HTTP_CREATED : Response::HTTP_NOT_FOUND;
            
            array_push( $estudiantesInscriptos, Estudiante::find($estudiante->id) );
            session([ 
                'estudiantesInscriptos' => $estudiantesInscriptos,
                'totalDeRegistros' => count($estudiantesInscriptos),
            ]);

            // session()->flush(); // elimina todos los datos de la session
            // return session('estudiantesInscriptos');

            return back()->with(compact('mensaje', 'estatus'));
            
            
        } catch (\Throwable $th) {
            $mensaje = Helpers::getMensajeError($th, ", ¡Error interno al intentar registrar estudiante!");
            $estatus = Response::HTTP_INTERNAL_SERVER_ERROR;
            return back()->with(compact('mensaje', 'estatus'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
