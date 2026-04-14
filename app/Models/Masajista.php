<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Masajista extends Model
{
    protected $table = 'masajistas';

    // Le dice a Eloquent que la llave primaria es cedula y no id
    protected $primaryKey = 'cedula';

    // Si la cedula es un string y no un entero (lo más probable),
    // necesitas esta línea para que Eloquent no intente castearlo
    protected $keyType = 'string';

    // Si la cedula la escribe el usuario y no es autoincremental
    public $incrementing = false;

    protected $fillable = [
        'cedula',
        'nombre',
        'telefono',
        'porcentaje_comision'
    ];

    public function calcularComision($precio)
    {
        return ($this->porcentaje_comision / 100) * $precio;
    }

    public function servicios(): BelongsToMany
    {
        return $this->belongsToMany(
            Servicios::class,
            'masa_servicio',
            'id_masajista',
            'id_servicio'
        );
    }

    public function citas(): HasMany
    {
        return $this->hasMany(Citas::class, 'masajista', 'cedula');
    }
}
