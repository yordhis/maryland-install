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
     * PÁGINA DE PREINCRIPCIÓN
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

    public function createEstudiante(Request $request)
    {
        try {
       
            $respuestaTail = DataDev::$respuestaTail;
            $nivelSolicitado = Nivele::where('codigo', $request->codigo_nivel)->get();
            $planSolicitado = Plane::where('codigo', $request->codigo_plan)->get();
            return view('page.estudiantePreinscripcion', compact('request', 'nivelSolicitado', 'planSolicitado', 'respuestaTail'));
            
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

        return $request;
        try {
            // Validando cedula 
            $estatusCreate = 0;

            // Configuramos las dificultades en un array
            $dificultadesInput = Helpers::getDificultades($request->request);

            // Validamos si se envio una foto
            if (isset($request->file)) {
                $request['foto'] = Helpers::setFile($request);
            }

            // registramos el estudiante
            $estatusCreate = Estudiante::create($request->all());

            if ($estatusCreate) {
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


            $mensaje =  $estatusCreate   ? "Estudiante registrado correctamente"
                : "No se pudo registrar verifique los datos.";
            $estatus = $estatusCreate ? Response::HTTP_CREATED : Response::HTTP_NOT_FOUND;

         
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
