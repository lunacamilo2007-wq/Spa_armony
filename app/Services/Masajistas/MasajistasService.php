<?php

namespace App\Services\Masajistas;
use App\Models\Masajista;

class MasajistasService
{
    public function create(array $data): Masajista
    {
        return Masajista::create($data);
    }
}