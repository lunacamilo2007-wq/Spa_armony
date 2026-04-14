<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Servicios extends Model
{
    protected $table = "servicios";
    protected $primaryKey = "id_servicio";
    protected $keyType = "int";
    public $incrementing = true;
    protected $fillable = [
        "nombre_servicio",
        "precio",
        "descripcion"
    ];

    public function citas(): BelongsToMany
    {
        return $this->belongsToMany(
            Citas::class,
            'citas_servicios',
            'id_servicio',
            'id_cita'
        );
    }
}
