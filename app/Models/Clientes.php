<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Clientes extends Model
{
    protected $table = "clientes";

    protected $primaryKey = "cedula";

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'cedula',
        'nombre',
        'telefono',
        'correo',
    ];

    public function citas(): HasMany
    {
        return $this->hasMany(Citas::class, 'id_cliente', 'cedula');
    }
}
