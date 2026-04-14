<?php

namespace App\Http\Requests\Clientes;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientesRequest extends FormRequest
{
    // Define quién tiene permiso de hacer esta acción
    // Por ahora true significa que cualquiera puede
    public function authorize(): bool
    {
        return true;
    }

    // Las reglas de validación
    public function rules(): array
    {
        return [
            'cedula' => 'required|digits_between:6,10|unique:clientes,cedula',
            'nombre' => 'required|string|max:100',
            'telefono' => 'required|digits_between:7,10',
            'correo' => 'required|email|unique:clientes,correo',
        ];
    }

    // Mensajes personalizados en español
    public function messages(): array
    {
        return [
            'cedula.required' => 'La cédula es obligatoria.',
            'cedula.digits_between' => 'La cédula debe tener entre 6 y 10 dígitos.',
            'cedula.unique' => 'Ya existe un cliente con esa cédula.',
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede superar los 100 caracteres.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.digits_between' => 'El teléfono debe tener entre 7 y 10 dígitos.',
            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'El correo debe ser un correo válido.',
            'correo.unique' => 'Ya existe un cliente con ese correo.',
        ];
    }
}