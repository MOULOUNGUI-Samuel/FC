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
        Schema::create('operations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')
                ->comment('Utilisateur ayant effectué l\'opération')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignUuid('cash_register_session_id')
                ->nullable()
                ->constrained('cash_register_sessions')
                ->onDelete('set null');

            $table->enum('type', ['Depot', 'Retrait']);
            $table->decimal('montant', 15, 2);
            $table->text('description');

            $table->foreignUuid('source_account_id')->nullable()->constrained('accounts')->onDelete('set null');
            $table->foreignUuid('source_cash_register_id')->nullable()->constrained('cash_registers')->onDelete('set null');
            $table->foreignUuid('destination_account_id')->nullable()->constrained('accounts')->onDelete('set null');
            $table->foreignUuid('destination_cash_register_id')->nullable()->constrained('cash_registers')->onDelete('set null');
            $table->foreignUuid('related_loan_id')->nullable()->constrained('loans')->onDelete('set null');

            $table->enum('statut', ['Validee', 'Annulee'])->default('Validee');

            $table->foreignUuid('cancellation_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->dateTime('heure_annulation')->nullable();
            $table->dateTime('date_operation');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operations');
    }
};
