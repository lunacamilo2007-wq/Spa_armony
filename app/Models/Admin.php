<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admin';
    protected $primaryKey = 'id_admin';
    protected $fillable = ['usuario', 'contrasena'];
    protected $hidden = ['contrasena'];

    /**
     * Get the password for the user (Laravel auth expects this method).
     */
    public function getAuthPassword()
    {
        return $this->contrasena;
    }
}
