<?php

namespace App\Http\Requests\Citas;

use App\Models\Citas;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCitasRequest extends FormRequest
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
            'estado'       => 'required|in:pendiente,confirmada,cancelada,finalizada',
            'habitacion'   => 'required|integer|min:1',
            'servicios'    => 'required|array|min:1',
            'servicios.*'  => 'exists:servicios,id_servicio',
        ];
    }

    /**
     * Validaciones adicionales de reglas de negocio:
     * - Disponibilidad del masajista en ese horario (excluyendo la cita actual)
     * - Disponibilidad de la habitación en ese horario (excluyendo la cita actual)
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $citaId = $this->route('cita');

            if ($this->fecha) {
                $hora = (int) date('H', strtotime($this->fecha));
                if ($hora < 8 || $hora >= 19) {
                    $validator->errors()->add('fecha', 'Las citas solo pueden programarse entre las 8:00 AM y las 7:00 PM.');
                }
            }

            if ($this->fecha && $this->masajista) {
                $fechaInicio = \Carbon\Carbon::parse($this->fecha);
                $minutosTotales = count((array) $this->servicios) * 60;
                if ($minutosTotales === 0) $minutosTotales = 60;
                $fechaFin = $fechaInicio->copy()->addMinutes($minutosTotales);

                $citasExistentes = Citas::where('masajista', $this->masajista)
                    ->whereDate('fecha', $fechaInicio->toDateString())
                    ->whereNotIn('estado', ['cancelada'])
                    ->where('id_cita', '!=', $citaId)
                    ->with('servicios')
                    ->get();

                $conflicto = false;
                foreach ($citasExistentes as $cita) {
                    $citaInicio = \Carbon\Carbon::parse($cita->fecha);
                    $serviciosCita = $cita->servicios->count();
                    $minsCita = ($serviciosCita > 0 ? $serviciosCita : 1) * 60;
                    $citaFin = $citaInicio->copy()->addMinutes($minsCita);

                    if ($fechaInicio < $citaFin && $fechaFin > $citaInicio) {
                        $conflicto = true;
                        break;
                    }
                }

                if ($conflicto) {
                    $validator->errors()->add('masajista',
                        'El masajista ya tiene una cita agendada en ese rango de tiempo.');
                }
            }

            if ($this->fecha && $this->habitacion) {
                $fechaInicio = \Carbon\Carbon::parse($this->fecha);
                $minutosTotales = count((array) $this->servicios) * 60;
                if ($minutosTotales === 0) $minutosTotales = 60;
                $fechaFin = $fechaInicio->copy()->addMinutes($minutosTotales);

                $citasExistentesHab = Citas::where('habitacion', $this->habitacion)
                    ->whereDate('fecha', $fechaInicio->toDateString())
                    ->whereNotIn('estado', ['cancelada'])
                    ->where('id_cita', '!=', $citaId)
                    ->with('servicios')
                    ->get();

                $conflictoHab = false;
                foreach ($citasExistentesHab as $cita) {
                    $citaInicio = \Carbon\Carbon::parse($cita->fecha);
                    $serviciosCita = $cita->servicios->count();
                    $minsCita = ($serviciosCita > 0 ? $serviciosCita : 1) * 60;
                    $citaFin = $citaInicio->copy()->addMinutes($minsCita);

                    if ($fechaInicio < $citaFin && $fechaFin > $citaInicio) {
                        $conflictoHab = true;
                        break;
                    }
                }

                if ($conflictoHab) {
                    $validator->errors()->add('habitacion',
                        'La habitación ya está ocupada en ese rango de tiempo.');
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
            'estado.required'      => 'El estado es obligatorio.',
            'estado.in'            => 'El estado debe ser pendiente, confirmada, cancelada o finalizada.',
            'habitacion.required'  => 'La habitación es obligatoria.',
            'habitacion.integer'   => 'La habitación debe ser un número.',
            'habitacion.min'       => 'La habitación debe ser un número positivo.',
            'servicios.required'   => 'Debe seleccionar al menos un servicio.',
            'servicios.min'        => 'Debe seleccionar al menos un servicio.',
            'servicios.*.exists'   => 'Uno de los servicios seleccionados no existe.',
        ];
    }
}