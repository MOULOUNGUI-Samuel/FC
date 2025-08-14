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
    $table->enum('type_utilisateur', ['Client', 'Utilisateur'])->comment('Définit si l\'entrée est un client ou un utilisateur interne/gestionnaire.');

    // --- Informations Personnelles (Communes & Client) ---
    $table->string('prenom')->nullable()->comment('Prénom, surtout pour les clients.');
    $table->string('nom')->comment('Nom de famille ou nom principal de l\'entité.');
    $table->string('nom_utilisateur')->unique()->nullable()->comment('Nom d\'utilisateur pour la connexion.');
    $table->string('profession')->nullable()->comment('Champ spécifique au Client.');
    $table->date('date_naissance')->nullable()->comment('Champ spécifique au Client.');
    $table->enum('genre', ['Homme', 'Femme', 'Autre'])->nullable()->comment('Champ spécifique au Client.');

    // --- Informations de Contact (Communes) ---
    $table->string('email')->unique()->nullable();
    $table->string('numero_telephone')->unique()->comment('Numéro de téléphone principal (phone_1).');
    $table->string('numero_telephone_secondaire')->nullable()->comment('Numéro de téléphone secondaire (phone_2).');
    $table->string('pays')->nullable();
    $table->string('ville')->nullable();
    $table->text('adresse')->nullable();

    // --- Informations d'Identification (Spécifiques) ---
    $table->string('numero_carte_identite')->unique()->nullable()->comment('Numéro CNI, spécifique au Client.');
    $table->string('numero_ifu')->unique()->nullable()->comment('Numéro IFU, spécifique à l\'Utilisateur/Société.');
    $table->string('numero_rccm')->unique()->nullable()->comment('Numéro RCCM, spécifique à l\'Utilisateur/Société.');

    // --- Authentification et Système ---
    $table->timestamp('email_verifie_le')->nullable();
    $table->string('password')->nullable()->comment('Peut être null si connexion via Google/Facebook.');
    $table->rememberToken();
    $table->string('google_id')->unique()->nullable();
    $table->boolean('est_actif')->default(true);
    
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