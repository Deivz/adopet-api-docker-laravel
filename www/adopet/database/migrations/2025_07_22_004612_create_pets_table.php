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
            $table->uuid('uuid')->unique();
            $table->string('name');
            $table->string('age');
            $table->string('size');
            $table->string('temperament');
            $table->string('city');
            $table->string('country');
            $table->string('photo')->nullable();
            $table->unsignedBigInteger('cod_responsible');
            $table->unsignedBigInteger('cod_adopter')->nullable();
            $table->timestamps();
            
            $table->foreign('cod_responsible')->references('id')->on('responsibles');
            $table->foreign('cod_adopter')->references('id')->on('adopters');
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
