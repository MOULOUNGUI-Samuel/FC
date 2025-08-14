<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Account;
use App\Models\CashRegister;
class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string'], // Accepts either email or username
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $identifiant = $this->input('email');
        $password = $this->input('password');

//         // 1) UTILISATEUR DE TEST
// $user = User::create([
//     'type_utilisateur' => 'Utilisateur',
//     'prenom' => 'Jean',
//     'nom' => 'Test',
//     'nom_utilisateur' => 'jtest',
//     'profession' => 'Comptable',
//     'date_naissance' => '1995-10-12',
//     'genre' => 'Homme',
//     'email' => 'jean.test@example.com',
//     'numero_telephone' => '077001002',
//     'numero_telephone_secondaire' => '065001002',
//     'pays' => 'Gabon',
//     'ville' => 'Libreville',
//     'adresse' => 'Akanda, Q. Résidentiel',
//     'numero_carte_identite' => 'CNI-TEST-0001',
//     'numero_ifu' => 'IFU-TEST-0001',
//     'numero_rccm' => 'RCCM-TEST-0001',
//     'password' => Hash::make('Test@12345'), // <— mot de passe de test
//     'google_id' => null,
//     'est_actif' => true,
//     'role_id' => null,
// ]);

// echo "✅ Utilisateur créé: {$user->id} ({$user->email})\n";

// // 2) COMPTE LIÉ À L’UTILISATEUR
// $account = Account::create([
//     'user_id' => $user->id,
//     'numero_compte' => 'ACC-'.Str::upper(Str::random(8)),
//     'nom' => 'Compte Principal',
//     'type' => 'Principal',      // ['Principal','Epargne','Projet','Autre']
//     'parent_account_id' => null,
//     'plafond' => 2000000.00,    // optionnel
//     'statut' => 'Actif',        // ['Actif','Bloque','Cloture']
//     'solde' => 150000.00,
// ]);

// echo "✅ Compte créé: {$account->id} ({$account->numero_compte})\n";

// // 3) CAISSE LIÉE À L’UTILISATEUR
// $cashRegister = CashRegister::create([
//     'user_id' => $user->id,
//     'nom' => 'Caisse Agence Akanda',
//     'type' => 'Physique',       // ['Physique','MobileMoney','Bancaire']
//     'solde' => 50000.00,
//     'seuil_min' => 10000.00,
//     'seuil_max' => 500000.00,
// ]);

// echo "✅ Caisse créée: {$cashRegister->id} ({$cashRegister->nom})\n";

// // (Optionnel) Affichage résumé
// echo "\nRésumé:\n- User: {$user->email}\n- Compte: {$account->numero_compte} / Solde: {$account->solde}\n- Caisse: {$cashRegister->nom} / Solde: {$cashRegister->solde}\n";

// die;
        // Vérification de l'existence des champs requis
        if (empty($identifiant)) {
            throw ValidationException::withMessages([
            'email' => 'Le champ identifiant est requis. Veuillez fournir votre email, numéro de téléphone ou nom d’utilisateur.',
            ]);
        }

        if (empty($password)) {
            throw ValidationException::withMessages([
            'password' => 'Le champ mot de passe est requis. Veuillez fournir votre mot de passe.',
            ]);
        }

        // On cherche l'utilisateur en vérifiant dans les 3 colonnes possibles.
        $user = User::where('nom_utilisateur', $identifiant)->first();

        // ----------------------------------------------------
        //        NOUVELLE LOGIQUE DE GESTION D'ERREUR
        // ----------------------------------------------------

        // Cas 1 : L'identifiant n'existe pas du tout.
        if (! $user) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'identifiant' => "Aucun compte n'est associé à cet identifiant ! Veuillez vérifier votre numéro de téléphone, email ou nom d'utilisateur.",
            ]);
        }

        // Cas 2 : L'identifiant existe, mais le mot de passe est incorrect.
        if (! Hash::check($password, $user->password)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                // On met l'erreur sur le champ 'password' pour une meilleure UX.
                // L'utilisateur saura que c'est le mot de passe qu'il doit corriger.
                'password' => 'Le mot de passe que vous avez saisi est incorrect.',
            ]);
        }

        // Si tout est correct, on connecte l'utilisateur.
        Auth::login($user, $this->boolean('remember'));

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')) . '|' . $this->ip());
    }
}
