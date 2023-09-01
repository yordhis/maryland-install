<?php

namespace Database\Seeders;

use App\Models\Plane;
use Illuminate\Database\Seeder;

class PlaneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $planeUno = new Plane();
        $planeUno->codigo = "0001";
        $planeUno->nombre = "Estandar";
        $planeUno->cantidad_cuotas = 3;
        $planeUno->plazo = 30;
        $planeUno->descripcion = "El pago se realiza cada 30 días";
        $planeUno->save();
        
        $planeDos = new Plane();
        $planeDos->codigo = "0002";
        $planeDos->nombre = "Contado";
        $planeDos->cantidad_cuotas = 1;
        $planeDos->plazo = 1;
        $planeDos->descripcion = "Se realiza un solo pago.";
        $planeDos->save();
    }
}
