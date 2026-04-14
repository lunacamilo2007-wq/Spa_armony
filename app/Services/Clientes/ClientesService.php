<?php
namespace App\Services\Clientes;
use App\Models\Clientes;

class ClientesService
{
    public function create(array $data): Clientes
    {
        $clientes = Clientes::create($data);
        return $clientes;
    }
    public function update(int $id, array $data): Clientes
    {
        $clientes = Clientes::findOrFail($id);
        $clientes->update($data);
        return $clientes;
    }
    public function delete(int $id): void
    {
        $clientes = Clientes::findOrFail($id);
        $clientes->delete();
    }


}