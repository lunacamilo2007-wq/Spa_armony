<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    ];
}
