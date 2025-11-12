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
        Schema::create('etudiants', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->date('date_naissance');
            $table->unsignedBigInteger('niveaux_id');
            $table->foreign('niveaux_id')
                  ->references('id')
                  ->on('niveaux')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->unsignedBigInteger('modules_id');
            // Définition de la clé étrangère
            $table->foreign('modules_id')
                  ->references('id')
                  ->on('modules')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etudiants');
    }
};
