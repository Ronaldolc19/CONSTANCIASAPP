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
        Schema::create('historial_constancias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_constancia');
            $table->unsignedBigInteger('id_usuario');
            $table->string('accion'); // generado, visualizado, descargado
            $table->timestamp('fecha');

            $table->foreign('id_constancia')->references('id_constancia')->on('constancias')->onDelete('cascade');
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_constancias');
    }
};
