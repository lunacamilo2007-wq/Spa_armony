<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Asegurarse de que las habitaciones referenciadas en citas existan antes de agregar la clave foránea
        $habitacionesIds = \Illuminate\Support\Facades\DB::table('citas')->select('habitacion')->distinct()->pluck('habitacion');
        
        foreach ($habitacionesIds as $id) {
            if ($id !== null) {
                $exists = \Illuminate\Support\Facades\DB::table('habitaciones')->where('id', $id)->exists();
                if (!$exists) {
                    \Illuminate\Support\Facades\DB::table('habitaciones')->insert([
                        'id' => $id,
                        'estado' => 'activo',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        Schema::table('citas', function (Blueprint $table) {
            $table->unsignedBigInteger('habitacion')->change();
            $table->foreign('habitacion')->references('id')->on('habitaciones')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->dropForeign(['habitacion']);
            $table->integer('habitacion')->change();
        });
    }
};
