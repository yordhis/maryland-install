<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfesoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "nombre"        => "required | max:255", 
            "nacionalidad"  => "required", 
            "cedula"        => "required | numeric | unique:profesores",
            "telefono"      => "required | numeric",
            "correo"        => "required | max:255",
            "nacimiento"    => "required",
            "edad"          => "required | numeric",     
            "direccion"     => "required | max:255",
            "foto"          => "mimes:jpg,bmp,png",
        ];
    }
}
