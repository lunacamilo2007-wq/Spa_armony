<?php
namespace App\Services\Clientes;
use App\Models\Clientes;
use Illuminate\Support\Facades\DB;

class ClientesService
{
    public function obtenerClientes($search = null)
    {
        $query = DB::table("clientes");

        if ($search) {
            // Agrupamos la lógica en un closure (función anónima)
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('cedula', 'like', "%{$search}%");
            });
        }

        return $query->paginate(20);
    }
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