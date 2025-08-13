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
        Schema::create('loans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('debtor_account_id')->constrained('accounts')->onDelete('cascade');
            $table->string('loan_number')->unique();
            $table->decimal('amount_granted', 15, 2);
            $table->decimal('annual_interest_rate', 5, 2);
            $table->date('request_date');
            $table->date('approval_date')->nullable();
            $table->date('disbursement_date')->nullable();
            $table->integer('duration_in_months');
            $table->enum('status', ['Demande', 'Approuve', 'Debourse', 'Rembourse', 'En_Retard', 'Refuse']);
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
