<?php

namespace App\Http\Requests\Citas;

use App\Models\Citas;
use Illuminate\Foundation\Http\FormRequest;

class StoreCitasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        // Asegurarnos de que el booleano es evaluado correctamente
        $this->merge([
            'es_nuevo_cliente' => filter_var($this->es_nuevo_cliente, FILTER_VALIDATE_BOOLEAN),
        ]);
    }

    public function rules(): array
    {
        return [
            'es_nuevo_cliente'       => 'required|boolean',
            
            // Si es un cliente existente
            'id_cliente'             => 'required_if:es_nuevo_cliente,false|nullable|exists:clientes,cedula',
            
            // Si es un nuevo cliente
            'nuevo_cliente_cedula'   => 'required_if:es_nuevo_cliente,true|nullable|unique:clientes,cedula',
            'nuevo_cliente_nombre'   => 'required_if:es_nuevo_cliente,true|nullable|string|max:255',
            'nuevo_cliente_telefono' => 'required_if:es_nuevo_cliente,true|nullable|string|max:15',
            'nuevo_cliente_correo'   => 'required_if:es_nuevo_cliente,true|nullable|email|max:255',

            'fecha'        => 'required|date|after:now',
            'masajista'    => 'required|exists:masajistas,cedula',
            'nota'         => 'nullable|string|max:255',
            'habitacion'   => 'required|integer|min:1',
            'servicios'    => 'required|array|min:1',
            'servicios.*'  => 'exists:servicios,id_servicio',
        ];
    }

    /**
     * Validaciones adicionales de reglas de negocio:
     * - Disponibilidad del masajista en ese horario
     * - Disponibilidad de la habitación en ese horario
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->fecha) {
                $hora = (int) date('H', strtotime($this->fecha));
                if ($hora < 8 || $hora >= 19) {
                    $validator->errors()->add('fecha', 'Las citas solo pueden programarse entre las 8:00 AM y las 7:00 PM.');
                }
            }

            if ($this->fecha && $this->masajista) {
                $conflicto = Citas::where('masajista', $this->masajista)
                    ->where('fecha', $this->fecha)
                    ->whereNotIn('estado', ['cancelada'])
                    ->exists();

                if ($conflicto) {
                    $validator->errors()->add('masajista',
                        'El masajista ya tiene una cita agendada en ese horario.');
                }
            }

            if ($this->fecha && $this->habitacion) {
                $conflictoHab = Citas::where('habitacion', $this->habitacion)
                    ->where('fecha', $this->fecha)
                    ->whereNotIn('estado', ['cancelada'])
                    ->exists();

                if ($conflictoHab) {
                    $validator->errors()->add('habitacion',
                        'La habitación ya está ocupada en ese horario.');
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'id_cliente.required_if'             => 'Debe seleccionar un cliente existente.',
            'nuevo_cliente_cedula.required_if'   => 'La cédula del nuevo cliente es obligatoria.',
            'nuevo_cliente_cedula.unique'        => 'Esta cédula ya está registrada, busque al cliente existente.',
            'nuevo_cliente_nombre.required_if'   => 'El nombre del nuevo cliente es obligatorio.',
            'nuevo_cliente_telefono.required_if' => 'El teléfono del nuevo cliente es obligatorio.',
            'nuevo_cliente_correo.required_if'   => 'El correo de contacto es obligatorio.',
            'fecha.required'       => 'La fecha es obligatoria.',
            'fecha.date'           => 'La fecha debe ser una fecha válida.',
            'fecha.after'          => 'La fecha debe ser posterior a la actual.',
            'masajista.required'   => 'El masajista es obligatorio.',
            'masajista.exists'     => 'El masajista seleccionado no existe.',
            'nota.string'          => 'La nota debe ser texto.',
            'nota.max'             => 'La nota no puede superar los 255 caracteres.',
            'habitacion.required'  => 'La habitación es obligatoria.',
            'habitacion.integer'   => 'La habitación debe ser un número.',
            'habitacion.min'       => 'La habitación debe ser un número positivo.',
            'servicios.required'   => 'Debe seleccionar al menos un servicio.',
            'servicios.min'        => 'Debe seleccionar al menos un servicio.',
            'servicios.*.exists'   => 'Uno de los servicios seleccionados no existe.',
        ];
    }
}