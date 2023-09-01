<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEstudianteRequest extends FormRequest
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
            "foto" => "max:2048|image",
            "cedula" => "required",
        ];
    }

    // public function attributes()
    // {
    //    return [
    //        'foto'=> 'imagen'
    //    ];
    // }

    public function messages(): array
    {
        return [
            'foto.image' => 'El archivo debe ser una imagen jpg/png',
            'foto.max' => 'El archivo excede el limite de peso permitido de Megas del archivo  (max: 2048kb)',
            'cedula.required' => 'El campo Cédula es obligatorio!'
            
        ];
    }
}
