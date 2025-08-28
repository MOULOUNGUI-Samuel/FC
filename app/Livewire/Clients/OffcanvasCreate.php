<?php

namespace App\Livewire\Clients;

use App\Models\User;
use App\Models\Account;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class OffcanvasCreate extends Component
{
    public string $tab = 'client';            // client | associe
    public string $type_utilisateur = 'Client';
    public ?string $editingId = null;  // ← null = création, sinon édition
    // Champs communs
    public ?string $nom = null;
    public ?string $prenom = null;
    public ?string $profession = null;
    public ?string $email = null;
    public ?string $numero_telephone = null;
    public ?string $numero_telephone_secondaire = null;
    public ?string $pays = 'Gabon';
    public ?string $ville = null;
    public ?string $adresse = null;

    // Client (personne physique)
    public ?string $date_naissance = null;
    public ?string $genre = null; // Homme|Femme|Autre
    public ?string $numero_carte_identite = null;

    // Utilisateur/Société (fond/entité)
    public ?string $date_creation = null;
    public ?string $numero_ifu = null;
    public ?string $numero_rccm = null;

    public bool $creer_compte_par_defaut = true;

    // Ouvrir en création (tu l'as déjà)
    #[On('open-create-offcanvas')]
    public function open(string $type = 'Client'): void
    {
        $this->resetValidation();
        $this->resetForm();
        $this->editingId = null;                 // ← création
        $this->selectType($type);
        $this->dispatch('ui:show-offcanvas', id: 'particulier');
    }
    protected function genNumeroCompte(): string
    {
        // Exemple de génération : AC + date + 6 chiffres aléatoires
        return 'AC'
            . date('ymd')
            . substr((string) mt_rand(100000, 999999), 0, 6);
    }

    protected function resetForm(): void
    {
        $this->editingId = null;

        // Champs communs
        $this->nom = null;
        $this->prenom = null;
        $this->profession = null;
        $this->email = null;
        $this->numero_telephone = null;
        $this->numero_telephone_secondaire = null;
        $this->pays = 'Gabon';
        $this->ville = null;
        $this->adresse = null;

        // Spécifiques Client
        $this->date_naissance = null;
        $this->genre = null;
        $this->numero_carte_identite = null;

        // Spécifiques Utilisateur / Société
        $this->date_creation = null;
        $this->numero_ifu = null;
        $this->numero_rccm = null;

        $this->creer_compte_par_defaut = true;
    }

    // 🔧 Ouvrir en édition
    #[On('open-edit-offcanvas')]
    public function openEdit(string $id): void
    {
        $this->resetValidation();
        $this->resetForm();

        $u = User::findOrFail($id);
        $this->editingId                 = $u->id;
        $this->type_utilisateur          = $u->type_utilisateur;         // Client | Utilisateur
        $this->tab                       = $u->type_utilisateur === 'Client' ? 'client' : 'associe';

        // communs
        $this->nom                       = $u->nom;
        $this->prenom                    = $u->prenom;
        $this->profession                = $u->profession;
        $this->email                     = $u->email;
        $this->numero_telephone          = $u->numero_telephone;
        $this->numero_telephone_secondaire = $u->numero_telephone_secondaire;
        $this->pays                      = $u->pays ?? 'Gabon';
        $this->ville                     = $u->ville;
        $this->adresse                   = $u->adresse;

        // spécifiques
        $this->date_naissance            = $u->date_naissance?->format('Y-m-d');
        $this->genre                     = $u->genre;
        $this->numero_carte_identite     = $u->numero_carte_identite;
        $this->date_creation             = $u->date_creation?->format('Y-m-d') ?? null; // si colonne existe
        $this->numero_ifu                = $u->numero_ifu;
        $this->numero_rccm               = $u->numero_rccm;

        $this->dispatch('ui:show-offcanvas', id: 'particulier');
    }

    // Règles dynamiques (👉 ignorer l’id courant en édition)
    protected function rules(): array
    {
        $ignore = $this->editingId;

        $base = [
            'type_utilisateur' => ['required', Rule::in(['Client', 'Utilisateur'])],
            'nom'              => ['required', 'string', 'max:255'],
            'prenom'           => ['nullable', 'string', 'max:255'],
            'profession'       => ['nullable', 'string', 'max:255'],
            'email'            => ['nullable', 'email', 'max:255', Rule::unique('users', 'email')->ignore($ignore)],
            'numero_telephone' => ['required', 'string', 'min:6', 'max:30', Rule::unique('users', 'numero_telephone')->ignore($ignore)],
            'numero_telephone_secondaire' => ['nullable', 'string', 'min:6', 'max:30'],
            'pays'             => ['nullable', 'string', 'max:120'],
            'ville'            => ['nullable', 'string', 'max:180'],
            'adresse'          => ['nullable', 'string', 'max:1000'],
        ];

        return $this->type_utilisateur === 'Client'
            ? $base + [
                'date_naissance'        => ['nullable', 'date'],
                'genre'                 => ['nullable', Rule::in(['Homme', 'Femme', 'Autre'])],
                'numero_carte_identite' => ['nullable', 'string', 'max:190', Rule::unique('users', 'numero_carte_identite')->ignore($ignore)],
            ]
            : $base + [
                'date_creation' => ['nullable', 'date'],
                'numero_ifu'    => ['nullable', 'string', 'max:190', Rule::unique('users', 'numero_ifu')->ignore($ignore)],
                'numero_rccm'   => ['nullable', 'string', 'max:190', Rule::unique('users', 'numero_rccm')->ignore($ignore)],
            ];
    }

    public function save(): void
    {
        $this->validate();

        if ($this->editingId) {
            // 🔄 MISE À JOUR
            $user = User::findOrFail($this->editingId);
            $user->update([
                'type_utilisateur'            => $this->type_utilisateur,
                'prenom'                      => $this->prenom,
                'nom'                         => $this->nom,
                'profession'                  => $this->type_utilisateur === 'Client' ? $this->profession : null,
                'date_naissance'              => $this->type_utilisateur === 'Client' ? $this->date_naissance : null,
                'genre'                       => $this->type_utilisateur === 'Client' ? $this->genre : null,
                'email'                       => $this->email,
                'numero_telephone'            => $this->numero_telephone,
                'numero_telephone_secondaire' => $this->numero_telephone_secondaire,
                'pays'                        => $this->pays,
                'ville'                       => $this->ville,
                'adresse'                     => $this->adresse,
                'numero_carte_identite'       => $this->type_utilisateur === 'Client' ? $this->numero_carte_identite : null,
                'numero_ifu'                  => $this->type_utilisateur === 'Utilisateur' ? $this->numero_ifu : null,
                'numero_rccm'                 => $this->type_utilisateur === 'Utilisateur' ? $this->numero_rccm : null,
            ]);

            $label = $this->type_utilisateur === 'Client' ? 'Client' : 'Entité / Société';
            $name  = trim(($user->prenom ? $user->prenom . ' ' : '') . $user->nom);
            $this->dispatch('notify', type: 'success', text: "{$label} « {$name} » modifié(e) avec succès.");
        } else {
            // ✅ CRÉATION (comme avant)
            $user = User::create([
                'id'                          => (string) Str::uuid(),
                'type_utilisateur'            => $this->type_utilisateur,
                'prenom'                      => $this->prenom,
                'nom'                         => $this->nom,
                'nom_utilisateur'             => null,
                'profession'                  => $this->type_utilisateur === 'Client' ? $this->profession : null,
                'date_naissance'              => $this->type_utilisateur === 'Client' ? $this->date_naissance : null,
                'genre'                       => $this->type_utilisateur === 'Client' ? $this->genre : null,
                'email'                       => $this->email,
                'numero_telephone'            => $this->numero_telephone,
                'numero_telephone_secondaire' => $this->numero_telephone_secondaire,
                'pays'                        => $this->pays,
                'ville'                       => $this->ville,
                'adresse'                     => $this->adresse,
                'numero_carte_identite'       => $this->type_utilisateur === 'Client' ? $this->numero_carte_identite : null,
                'numero_ifu'                  => $this->type_utilisateur === 'Utilisateur' ? $this->numero_ifu : null,
                'numero_rccm'                 => $this->type_utilisateur === 'Utilisateur' ? $this->numero_rccm : null,
            ]);

            if ($this->creer_compte_par_defaut) {
                Account::create([
                    'id'            => (string) Str::uuid(),
                    'user_id'       => $user->id,
                    'numero_compte' => $this->genNumeroCompte(),
                    'nom'           => 'Compte principal',
                    'type'          => 'Principal',
                    'statut'        => 'Actif',
                    'solde'         => 0,
                ]);
            }

            $label = $this->type_utilisateur === 'Client' ? 'Client' : 'Entité / Société';
            $name  = trim(($user->prenom ? $user->prenom . ' ' : '') . $user->nom);
            $this->dispatch('notify', type: 'success', text: "{$label} « {$name} » créé(e) avec succès.");
        }

        // UI
        $this->dispatch('ui:hide-offcanvas', id: 'particulier');
        $this->dispatch('clients:refresh');
        $this->resetForm();
        $this->editingId = null;
    }
}
