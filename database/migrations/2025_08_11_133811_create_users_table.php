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
        Schema::create('users', function (Blueprint $table) {
            // --- ID et Type ---
            $table->uuid('id')->primary();
            $table->enum('user_type', ['Client', 'Utilisateur'])->comment('Définit si l\'entrée est un client ou un utilisateur interne/gestionnaire.');

            // --- Informations Personnelles (Communes & Client) ---
            $table->string('first_name')->nullable()->comment('Prénom, surtout pour les clients.');
            $table->string('last_name')->comment('Nom de famille ou nom principal de l\'entité.');
            $table->string('username')->unique()->nullable()->comment('Nom d\'utilisateur pour la connexion.');
            $table->string('profession')->nullable()->comment('Champ spécifique au Client.');
            $table->date('date_of_birth')->nullable()->comment('Champ spécifique au Client.');
            $table->enum('gender', ['Homme', 'Femme', 'Autre'])->nullable()->comment('Champ spécifique au Client.');

            // --- Informations de Contact (Communes) ---
            $table->string('email')->unique()->nullable();
            $table->string('phone_number')->unique()->comment('Numéro de téléphone principal (phone_1).');
            $table->string('secondary_phone_number')->nullable()->comment('Numéro de téléphone secondaire (phone_2).');
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->text('address')->nullable();

            // --- Informations d'Identification (Spécifiques) ---
            $table->string('id_card_number')->unique()->nullable()->comment('Numéro CNI, spécifique au Client.');
            $table->string('ifu_number')->unique()->nullable()->comment('Numéro IFU, spécifique à l\'Utilisateur/Société.');
            $table->string('rccm_number')->unique()->nullable()->comment('Numéro RCCM, spécifique à l\'Utilisateur/Société.');

            // --- Authentification et Système ---
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable()->comment('Peut être null si connexion via Google/Facebook.');
            $table->rememberToken();
            $table->string('google_id')->unique()->nullable();
            $table->boolean('is_active')->default(true);
            
            // --- Relations ---
            $table->foreignUuid('role_id')->nullable()->constrained()->onDelete('set null');

            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // Le champ 'id' de la session est un string, pas un UUID. C'est correct.
            // =======================================================
            //                  LA CORRECTION EST ICI
            // =======================================================
            // On utilise foreignUuid pour faire référence à la clé primaire UUID de la table users.
            $table->foreignUuid('user_id')->nullable()->index(); 
            
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};