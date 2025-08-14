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
        Schema::create('loans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('debtor_account_id')->constrained('accounts')->onDelete('cascade');
            $table->string('numero_pret')->unique();
            $table->decimal('montant_accorde', 15, 2);
            $table->decimal('taux_interet_annuel', 5, 2);
            $table->date('date_demande');
            $table->date('date_approbation')->nullable();
            $table->date('date_decaissement')->nullable();
            $table->integer('duree_en_mois');
            $table->enum('statut', ['Demande', 'Approuve', 'Debourse', 'Rembourse', 'En_Retard', 'Refuse']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
