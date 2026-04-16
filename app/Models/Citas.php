<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Citas extends Model
{
    protected $table = "citas";

    protected $primaryKey = "id_cita";

    public $incrementing = true;

    protected $keyType = "int";

    protected $fillable = [
        'fecha',
        'masajista',
        'id_cliente',
        'nota',
        'estado',
        'habitacion',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'datetime',
        ];
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Clientes::class, 'id_cliente', 'cedula');
    }

    public function masajista(): BelongsTo
    {
        return $this->belongsTo(Masajista::class, 'masajista', 'cedula');
    }

    public function servicios(): BelongsToMany
    {
        return $this->belongsToMany(
            Servicios::class,
            'citas_servicios',
            'id_cita',
            'id_servicio'
        )->withPivot('duracion')->withTimestamps();
    }

    public function getTotalAttribute(): int
    {
        return $this->servicios->sum('precio');
    }

    public function getDuracionTotalAttribute(): int
    {
        return $this->servicios->sum('pivot.duracion') ?? 0;
    }
}
