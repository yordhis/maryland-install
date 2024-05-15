<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscripcione extends Model
{
    use HasFactory;

    protected $fillable = [
        "codigo", 
        "cedula_estudiante", 
        "codigo_grupo", 
        "codigo_plan",
        "codigo_nivel",
        "nota",
        "fecha",
        "extras",
        "total",
        "abono",
        "estatus"
    ];
}
