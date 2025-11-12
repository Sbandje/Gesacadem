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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('etudiants_id');
            $table->decimal('montant', 10, 2);
            $table->decimal('montant_total', 10, 2)->default(200000);
            $table->date('date_paiement');
            $table->enum ('mode_paiement', ['espece', 'carte_bancaire', 'virement_bancaire'])->default('espece');
            $table->decimal('reste_a_payer', 10, 2)->default(0);
            $table->enum('etat', ['partiel', 'solde'])->default('partiel');
            $table->foreign('etudiants_id')->references('id')->on('etudiants')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');

    }
};
