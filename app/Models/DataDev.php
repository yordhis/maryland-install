<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

class DataDev
{

    public $respuesta;
    public $notificaciones;
    public $usuario;
    public $dias;
    public $metodosPagos;
    public $estatus;
    /**
     * Constructor
     */
     public function __construct(){

        $this->respuesta=[
            "mensaje" => "No Funcionó",
            "activo" => null,
            "estatus" => 404,
            "clases" => [
                "200" => "alert-success",
                "201" => "alert-success",
                "301" => "alert-warning",
                "401" => "alert-warning",
                "404" => "alert-danger",
            ],
            "icono" => [
                "200" => "bi bi-check-circle me-1",
                "201" => "bi bi-check-circle me-1",
                "301" => "bi bi-exclamation-triangle me-1",
                "401" => "bi bi-exclamation-octagon me-1",
                "404" => "bi bi-exclamation-octagon me-1"
            ]
        ];

        $this->metodosPagos = [
            [
                "metodo" => "TD",
                "activo" => false           
            ],
            [
                "metodo" => "EFECTIVO",
                "activo" => false           
            ],
            [
                "metodo" => "PAGO MOVIL",
                "activo" => false           
            ],
            [
                "metodo" => "DIVISAS",
                "activo" => false           
            ]
        ];
        $this->dias = [
            "Lunes",
            "Martes",
            "Miercoles",
            "Jueves",
            "Viernes",
            "Sabado",
            "Domingo"
        ];

        $this->notificaciones = [
            "total" => 5,
            "data"=>[
                ["descripcion"=>"Franklin Pago", "tipo"=>"Pago"],
                ["descripcion"=>"Franklin 2 Pago", "tipo"=>"Pago"],
                ["descripcion"=>"Franklin 3 Pago", "tipo"=>"Pago"],
                ["descripcion"=>"Franklin 4 Pago", "tipo"=>"Pago"],
                ["descripcion"=>"Franklin 5 Pago", "tipo"=>"Pago"]
            ]
        ];

        $this->estatus = [
            "0" => "Eliminado",
            "1" => "Activo",
            "2" => "Inactivo",
            "3" => "Completado",
        ];

        $this->usuario = [
            "nombre" => "admin",
            "rol" => "administrador",
        ];
     }


    public function getRespuesta(){
        return $this->respuesta;
    }

    public function getNotificaciones(){
        return $this->notificaciones;
    }

    public function getMetodosPagos(){
        return $this->metodosPagos;
    }

    public function getEstatusText(){
        return $this->estatus;
    }

}
