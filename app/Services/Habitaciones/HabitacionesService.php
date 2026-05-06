<?php

namespace App\Services\Habitaciones;

use App\Models\Habitacion;

class HabitacionesService
{
    public function obtenerHabitaciones($search = null)
    {
        $query = Habitacion::query();

        if ($search) {
            $query->where('id', 'like', "%{$search}%");
        }

        return $query->paginate(20);
    }

    public function obtenerHabitacionesActivas()
    {
        return Habitacion::where('estado', 'activo')->get();
    }

    public function create(array $data): Habitacion
    {
        return Habitacion::create($data);
    }

    public function update(int $id, array $data): Habitacion
    {
        $habitacion = Habitacion::findOrFail($id);
        $habitacion->update($data);

        return $habitacion;
    }

    public function toggleEstado(int $id): Habitacion
    {
        $habitacion = Habitacion::findOrFail($id);
        $habitacion->estado = $habitacion->estado === 'activo' ? 'inactivo' : 'activo';
        $habitacion->save();

        return $habitacion;
    }

    public function delete(int $id): void
    {
        Habitacion::findOrFail($id)->delete();
    }
}
