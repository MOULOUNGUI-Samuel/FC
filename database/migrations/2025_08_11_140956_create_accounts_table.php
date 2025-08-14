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
        Schema::create('accounts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->string('numero_compte')->unique();
            $table->string('nom');
            $table->enum('type', ['Principal', 'Epargne', 'Projet', 'Autre'])->default('Principal');
            $table->foreignUuid('parent_account_id')->nullable()->constrained('accounts')->onDelete('set null');
            $table->decimal('plafond', 15, 2)->nullable();
            $table->enum('statut', ['Actif', 'Bloque', 'Cloture'])->default('Actif');
            $table->decimal('solde', 15, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
