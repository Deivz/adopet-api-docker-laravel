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
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('idade');
            $table->string('porte');
            $table->string('perfil');
            $table->string('cidade');
            $table->string('estado');
            $table->string('foto')->nullable();
            $table->unsignedBigInteger('cod_responsavel');
            $table->unsignedBigInteger('cod_adotante')->nullable();
            $table->timestamps();
            
            $table->foreign('cod_responsavel')->references('id')->on('responsaveis');
            $table->foreign('cod_adotante')->references('id')->on('adotantes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
