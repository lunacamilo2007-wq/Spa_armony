<?php

namespace App\Services\Masajistas;
use App\Models\Masajista;
use Illuminate\Support\Facades\DB;

class MasajistasService
{
    /**
     * Crear masajista + servicios en pivot dentro de una transacción.
     * Si falla cualquier insert, se hace rollback completo.
     */
    public function create(array $data): Masajista
    {
        return DB::transaction(function () use ($data) {
            $masajista = Masajista::create($data);

            if (isset($data['servicios'])) {
                $masajista->servicios()->sync($data['servicios']);
            }

            return $masajista;
        });
    }

    /**
     * Actualizar masajista + servicios en pivot dentro de una transacción.
     * Si falla el update o el sync, ningún cambio se persiste.
     */
    public function update(int $id, array $data): Masajista
    {
        return DB::transaction(function () use ($id, $data) {
            $masajista = Masajista::findOrFail($id);
            $masajista->update($data);

            if (isset($data['servicios'])) {
                $masajista->servicios()->sync($data['servicios']);
            } else {
                $masajista->servicios()->sync([]);
            }

            return $masajista;
        });
    }

    public function delete(int $id): void
    {
        $masajista = Masajista::findOrFail($id);
        $masajista->delete();
    }
}
