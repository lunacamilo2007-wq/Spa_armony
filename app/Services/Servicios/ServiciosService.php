<?php

namespace App\Services\Servicios;
use App\Models\Servicios;

class ServiciosService
{
    public function create(array $data): Servicios
    {
        $servicio = Servicios::create($data);
        return $servicio;

    }
    public function update(int $id, array $data): Servicios
    {
        $servicio = Servicios::findOrFail($id);
        $servicio->update($data);
        return $servicio;
    }
    public function delete(int $id): void
    {
        $servicio = Servicios::findOrFail($id);
        $servicio->delete();
    }
}