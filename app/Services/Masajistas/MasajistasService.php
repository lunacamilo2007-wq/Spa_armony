<?php

namespace App\Services\Masajistas;
use App\Models\Masajista;

class MasajistasService
{
    public function create(array $data): Masajista
    {
        $masajista = Masajista::create($data);

        if (isset($data['servicios'])) {
            $masajista->servicios()->sync($data['servicios']);
        }

        return $masajista;
    }
    public function update(int $id, array $data): Masajista
    {
        $masajista = Masajista::findOrFail($id);
        $masajista->update($data);

        if (isset($data['servicios'])) {
            $masajista->servicios()->sync($data['servicios']);
        } else {
            $masajista->servicios()->sync([]);
        }

        return $masajista;
    }
    public function delete(int $id): void
    {
        $masajista = Masajista::findOrFail($id);
        $masajista->delete();
    }
}
