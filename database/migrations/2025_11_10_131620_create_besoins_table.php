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
        Schema::create('besoins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etudiants_id')->constrained('etudiants')->onDelete('cascade');
            $table->enum('type_besoin', ['paiement_scolarité', 'hébergement', 'modification_module'])->default('paiement_scolarite'); 
            $table->string('titre');
            $table->text('description');
            $table->enum('priorite', ['faible', 'moyenne', 'élevée', 'urgent'])->default('moyenne');
            $table->enum('statut', ['en_attente', 'en_cours', 'résolu', 'rejeté'])->default('en_attente');
            $table->decimal('cout_estime', 10, 2)->nullable(); 
            $table->date('date_limite')->nullable();
            $table->text('notes_admin')->nullable(); 
            $table->timestamp('date_resolution')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('besoins');
    }
};
