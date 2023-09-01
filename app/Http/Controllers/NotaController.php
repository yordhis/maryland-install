<?php

namespace App\Http\Controllers;

use App\Models\Cuota;
use App\Models\DataDev;
use App\Models\Helpers;
use App\Models\Inscripcione;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $data = new DataDev;
        try {
            if ($request->nota > $request->notaMaxima) {
                return redirect()->route('admin.inscripciones.index',[
                    "estatus" => 301,
                    "mensaje" => "La nota asignada supera la nota maxima."
                ]);
            }

            $nota = "{$request->nota}/{$request->notaMaxima}";
            Inscripcione::where('id', $id)
            ->update(['nota' => $nota]);
            return redirect()->route('admin.inscripciones.index',[
                "estatus" => 200,
                "mensaje" => "La nota se guardo correctamente."
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return $th->getMessage();
        }
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
