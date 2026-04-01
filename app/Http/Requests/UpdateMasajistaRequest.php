<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMasajistaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Tomamos la cédula de la URL para ignorarla en el unique
        $cedula = $this->route('masajista');

        return [
            'nombre'   => 'required|string|max:100',
            'telefono' => 'required|digits_between:7,10',
        ];
    }

    public function messages(): array
    {
        return [
            'cedula.required'          => 'La cédula es obligatoria.',
            'cedula.digits_between'    => 'La cédula debe tener entre 6 y 10 dígitos.',
            'cedula.unique'            => 'Ya existe un masajista con esa cédula.',
            'nombre.required'          => 'El nombre es obligatorio.',
            'nombre.max'               => 'El nombre no puede superar los 100 caracteres.',
            'telefono.required'        => 'El teléfono es obligatorio.',
            'telefono.digits_between'  => 'El teléfono debe tener entre 7 y 10 dígitos.',
        ];
    }
}
