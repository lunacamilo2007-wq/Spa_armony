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

    public function rules(): array
    {
        return [
            'fecha'        => 'required|date|after:now',
            'masajista'    => 'required|exists:masajistas,cedula',
            'id_cliente'   => 'required|exists:clientes,cedula',
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
            'fecha.required'       => 'La fecha es obligatoria.',
            'fecha.date'           => 'La fecha debe ser una fecha válida.',
            'fecha.after'          => 'La fecha debe ser posterior a la actual.',
            'masajista.required'   => 'El masajista es obligatorio.',
            'masajista.exists'     => 'El masajista seleccionado no existe.',
            'id_cliente.required'  => 'El cliente es obligatorio.',
            'id_cliente.exists'    => 'El cliente seleccionado no existe.',
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