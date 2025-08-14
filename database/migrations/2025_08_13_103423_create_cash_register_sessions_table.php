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
        Schema::create('cash_register_sessions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('cash_register_id')->constrained('cash_registers')->onDelete('cascade');
            $table->foreignUuid('opening_user_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('heure_ouverture');
            $table->decimal('solde_initial', 15, 2);
            $table->foreignUuid('closing_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->dateTime('heure_fermeture')->nullable();
            $table->decimal('solde_final_theorique', 15, 2)->nullable();
            $table->decimal('solde_final_reel', 15, 2)->nullable();
            $table->decimal('difference', 15, 2)->nullable();
            $table->text('justification')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_register_sessions');
    }
};
