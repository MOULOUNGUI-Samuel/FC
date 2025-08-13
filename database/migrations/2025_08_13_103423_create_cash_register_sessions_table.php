<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void {
        Schema::create('cash_register_sessions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('cash_register_id')->constrained('cash_registers')->onDelete('cascade');
            $table->foreignUuid('opening_user_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('opening_time');
            $table->decimal('initial_balance', 15, 2);
            $table->foreignUuid('closing_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->dateTime('closing_time')->nullable();
            $table->decimal('theorical_final_balance', 15, 2)->nullable();
            $table->decimal('real_final_balance', 15, 2)->nullable();
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
