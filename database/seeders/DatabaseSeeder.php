<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Servicios;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $servicios = [
            ['id_servicio' => 1, 'nombre_servicio' => 'Masaje Relajante', 'precio' => 40000, 'descripcion' => 'Masaje suave para aliviar el estrés y la tensión muscular'],
            ['id_servicio' => 2, 'nombre_servicio' => 'Masaje Deportivo', 'precio' => 50000, 'descripcion' => 'Ideal para deportistas, trabaja músculos profundos'],
            ['id_servicio' => 3, 'nombre_servicio' => 'Aromaterapia', 'precio' => 48000, 'descripcion' => 'Masaje con aceites esenciales para equilibrio emocional'],
            ['id_servicio' => 4, 'nombre_servicio' => 'Tratamiento Facial', 'precio' => 35000, 'descripcion' => 'Limpieza e hidratación facial profunda'],
            ['id_servicio' => 5, 'nombre_servicio' => 'Masaje de Piedras Calientes', 'precio' => 60000, 'descripcion' => 'Terapia con piedras volcánicas para relajación profunda'],
            ['id_servicio' => 6, 'nombre_servicio' => 'Reflexología', 'precio' => 40000, 'descripcion' => 'Estimulación de puntos reflejos en pies y manos'],
        ];

        // 1. Insertar los servicios en la base de datos (ignorando si ya existen por el ID)
        foreach ($servicios as $servicio) {
            Servicios::updateOrCreate(
                ['id_servicio' => $servicio['id_servicio']], 
                $servicio
            );
        }

        // 2. Llamar al seeder del Administrador
        $this->call([
            AdminSeeder::class,
        ]);
    }
}
