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
        Schema::create('loan_installments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('loan_id')->constrained('loans')->onDelete('cascade');
            $table->date('date_echeance');
            $table->decimal('montant_principal', 15, 2);
            $table->decimal('montant_interet', 15, 2);
            $table->decimal('montant_total', 15, 2);
            $table->enum('statut', ['A_Payer', 'Payee', 'En_Retard', 'Payee_Partiel'])->default('A_Payer');
            $table->decimal('montant_paye', 15, 2)->default(0.00);
            $table->dateTime('date_paiement')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_installments');
    }
};
