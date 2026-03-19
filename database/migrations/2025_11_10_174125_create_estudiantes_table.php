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
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id('id_estudiante');
            $table->string('nombre');
            $table->string('ap');
            $table->string('am');
            $table->string('genero');
            $table->string('no_cuenta')->unique();
            $table->unsignedBigInteger('id_carrera');
            $table->unsignedBigInteger('id_empresa')->nullable();
            $table->unsignedBigInteger('id_periodo')->nullable();
            $table->string('no_registro')->unique();
            $table->string('no_folio')->unique();
            $table->string('calificacion')->nullable();
            $table->date('fecha_emision')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};
