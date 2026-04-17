<?php
namespace App\Services\Citas;
use App\Models\Citas;
use App\Models\Clientes;
use Illuminate\Support\Facades\DB;

class CitasService
{
    /**
     * Crear cita + servicios en pivot dentro de una transacción.
     * Si falla cualquier insert, se hace rollback completo.
     */
    public function create(array $data): Citas
    {
        return DB::transaction(function () use ($data) {

            // Crear el cliente si fue proporcionado por formulario
            if (isset($data['es_nuevo_cliente']) && $data['es_nuevo_cliente']) {
                $cliente = Clientes::create([
                    'cedula' => $data['nuevo_cliente_cedula'],
                    'nombre' => $data['nuevo_cliente_nombre'],
                    'telefono' => $data['nuevo_cliente_telefono'],
                    'correo' => $data['nuevo_cliente_correo'],
                ]);
                $data['id_cliente'] = $cliente->cedula;
            }

            // Forzar estado inicial a pendiente
            $data['estado'] = 'pendiente';

            $cita = Citas::create($data);

            // Sincronizar servicios en tabla pivot citas_servicios
            if (isset($data['servicios'])) {
                $serviciosConDuracion = [];
                foreach ($data['servicios'] as $servicioId) {
                    $serviciosConDuracion[$servicioId] = [
                        'duracion' => $data['duraciones'][$servicioId] ?? 60,
                    ];
                }
                $cita->servicios()->sync($serviciosConDuracion);
            }

            return $cita;
        });
    }

    /**
     * Actualizar cita + servicios en pivot dentro de una transacción.
     * Si falla el update o el sync, ningún cambio se persiste.
     */
    public function update(int $id, array $data): Citas
    {
        return DB::transaction(function () use ($id, $data) {
            $cita = Citas::findOrFail($id);
            $cita->update($data);

            // Sincronizar servicios en tabla pivot citas_servicios
            if (isset($data['servicios'])) {
                $serviciosConDuracion = [];
                foreach ($data['servicios'] as $servicioId) {
                    $serviciosConDuracion[$servicioId] = [
                        'duracion' => $data['duraciones'][$servicioId] ?? 60,
                    ];
                }
                $cita->servicios()->sync($serviciosConDuracion);
            } else {
                $cita->servicios()->sync([]);
            }

            return $cita;
        });
    }

    public function delete(int $id): void
    {
        $cita = Citas::findOrFail($id);
        $cita->delete();
    }

    /**
     * Cambiar estado de una cita con guardia de transiciones válidas.
     *
     * Transiciones permitidas:
     * - pendiente  → confirmada, cancelada
     * - confirmada → finalizada, cancelada
     * - cancelada  → (ninguna, estado final)
     * - finalizada → (ninguna, estado final)
     */
    public function changeStatus(string $id, string $status): Citas
    {
        $cita = Citas::where('id_cita', $id)->firstOrFail();

        $transicionesValidas = [
            'pendiente' => ['confirmada', 'cancelada'],
            'confirmada' => ['finalizada', 'cancelada'],
        ];

        $estadoActual = $cita->estado;

        if (
            !isset($transicionesValidas[$estadoActual])
            || !in_array($status, $transicionesValidas[$estadoActual])
        ) {
            throw new \InvalidArgumentException(
                "No se puede pasar de '{$estadoActual}' a '{$status}'."
            );
        }

        $cita->update(['estado' => $status]);
        return $cita;
    }
}