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
        Schema::create('constancias', function (Blueprint $table) {
            $table->id('id_constancia');
            $table->string('no_registro')->unique();
            $table->string('no_folio')->unique();
            $table->string('calificacion');
            $table->date('fecha_emision');
            $table->unsignedBigInteger('id_estudiante');
            $table->unsignedBigInteger('id_empresa');
            $table->unsignedBigInteger('id_periodo');

            $table->foreign('id_estudiante')->references('id_estudiante')->on('estudiantes')->onDelete('cascade');
            $table->foreign('id_empresa')->references('id_empresa')->on('empresas')->onDelete('cascade');
            $table->foreign('id_periodo')->references('id_periodo')->on('periodos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('constancias');
    }
};
