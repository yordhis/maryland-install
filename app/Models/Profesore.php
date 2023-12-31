<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesore extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "nombre", 
        "nacionalidad", 
        "cedula",
        "telefono",
        "correo",
        "nacimiento",
        "edad",
        "direccion",
        "foto",
        "estatus"
    ];
}
