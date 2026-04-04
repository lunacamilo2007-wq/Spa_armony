<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
