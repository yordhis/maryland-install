<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preinscripcione extends Model
{
    use HasFactory;

    protected $fillable = [
        "codigo",
        "cedula_estudiante",
        "codigo_plan",
        "codigo_nivel",
        "total",
        "abono",
        "comprobante",
        "referencia",
        "estatus"
    ];
}
