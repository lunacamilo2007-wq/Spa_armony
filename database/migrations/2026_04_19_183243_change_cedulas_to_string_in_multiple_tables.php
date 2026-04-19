<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->dropForeign(['id_cliente']); // Usa el nombre de la columna
            $table->dropForeign(['masajista']);
        });

        Schema::table('masa_servicio', function (Blueprint $table) {
            $table->dropForeign(['id_masajista']);
        });

        // 2. Cambiar todos los tipos de datos a string
        Schema::table('clientes', function (Blueprint $table) {
            $table->string('cedula', 20)->change();
        });

        Schema::table('masajistas', function (Blueprint $table) {
            $table->string('cedula', 20)->change();
        });

        Schema::table('citas', function (Blueprint $table) {
            $table->string('id_cliente', 20)->change();
            $table->string('masajista', 20)->change();
        });

        Schema::table('masa_servicio', function (Blueprint $table) {
            $table->string('id_masajista', 20)->change();
        });

        // 3. Volver a crear las relaciones
        Schema::table('citas', function (Blueprint $table) {
            $table->foreign('id_cliente')->references('cedula')->on('clientes');
            $table->foreign('masajista')->references('cedula')->on('masajistas');
        });

        Schema::table('masa_servicio', function (Blueprint $table) {
            $table->foreign('id_masajista')->references('cedula')->on('masajistas');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Soltar las relaciones actuales (las que usan string)
        Schema::table('citas', function (Blueprint $table) {
            $table->dropForeign(['id_cliente']);
            $table->dropForeign(['masajista']);
        });

        Schema::table('masa_servicio', function (Blueprint $table) {
            $table->dropForeign(['id_masajista']);
        });

        // 2. Revertir todos los tipos de datos al original (integer)
        // Agrupamos por tabla para mantener el orden
        Schema::table('clientes', function (Blueprint $table) {
            $table->integer('cedula')->change();
        });

        Schema::table('masajistas', function (Blueprint $table) {
            $table->integer('cedula')->change();
        });

        Schema::table('citas', function (Blueprint $table) {
            $table->integer('id_cliente')->change();
            $table->integer('masajista')->change();
        });

        Schema::table('masa_servicio', function (Blueprint $table) {
            $table->integer('id_masajista')->change();
        });

        // 3. Volver a crear las relaciones originales (basadas en integer)
        Schema::table('citas', function (Blueprint $table) {
            $table->foreign('id_cliente')->references('cedula')->on('clientes');
            $table->foreign('masajista')->references('cedula')->on('masajistas');
        });

        Schema::table('masa_servicio', function (Blueprint $table) {
            $table->foreign('id_masajista')->references('cedula')->on('masajistas');
        });
    }
};
