<?php

namespace App\Livewire\Clients;

use App\Models\User;
use App\Models\Account;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class OffcanvasCreateParticulier extends Component
{
    public string $type_utilisateur = 'Client'; // Ce composant est spécifiquement pour les clients particuliers
    public ?string $editingId = null;

    // Champs spécifiques au client particulier
    public ?string $nom = null;
    public ?string $prenom = null;
    public ?string $profession = null;
    public ?string $email = null;
    public ?string $numero_telephone = null;
    public ?string $numero_telephone_secondaire = null;
    public ?string $pays = 'Gabon';
    public ?string $ville = null;
    public ?string $adresse = null;
    public ?string $date_naissance = null;
    public ?string $genre = null; // Homme|Femme|Autre
    public ?string $numero_carte_identite = null;

    public bool $creer_compte_par_defaut = true;

    // Générateur simple de numéro de compte
    protected function genNumeroCompte(): string
    {
        return 'AC'
            . date('ymd')
            . substr((string) mt_rand(100000, 999999), 0, 6);
    }

    // Reset du formulaire
    protected function resetForm(): void
    {
        $this->editingId = null;
        $this->nom = null;
        $this->prenom = null;
        $this->profession = null;
        $this->email = null;
        $this->numero_telephone = null;
        $this->numero_telephone_secondaire = null;
        $this->pays = 'Gabon';
        $this->ville = null;
        $this->adresse = null;
        $this->date_naissance = null;
        $this->genre = null;
        $this->numero_carte_identite = null;
        $this->creer_compte_par_defaut = true;
    }

    #[On('open-create-offcanvas-particulier')]
    public function open(): void
    {
        $this->resetValidation();
        $this->resetForm();
        $this->editingId = null;
        $this->type_utilisateur = 'Client'; // S'assurer que le type est bien 'Client'
        $this->dispatch('ui:show-offcanvas', id: 'offcanvasParticulier');
    }

    #[On('open-edit-offcanvas-particulier')] // Nouvel événement pour l'édition de particuliers
    public function openEdit(string $id): void
    {
        $this->resetValidation();
        $this->resetForm();

        $user = User::findOrFail($id);
        if ($user->type_utilisateur !== 'Client') {
            // Optionnel: Gérer le cas où l'ID n'est pas un client particulier
            // Ou lancer une exception si un type incorrect est passé
            $this->dispatch('notify', type: 'danger', text: 'Ce n\'est pas un client particulier.');
            return;
        }

        $this->editingId = $user->id;
        $this->type_utilisateur = 'Client'; // Assurez-vous que le type est correct

        // Remplir les champs
        $this->nom                       = $user->nom;
        $this->prenom                    = $user->prenom;
        $this->profession                = $user->profession;
        $this->email                     = $user->email;
        $this->numero_telephone          = $user->numero_telephone;
        $this->numero_telephone_secondaire = $user->numero_telephone_secondaire;
        $this->pays                      = $user->pays ?? 'Gabon';
        $this->ville                     = $user->ville;
        $this->adresse                   = $user->adresse;
        $this->date_naissance            = $user->date_naissance ? $user->date_naissance->format('Y-m-d') : null;
        $this->genre                     = $user->genre;
        $this->numero_carte_identite     = $user->numero_carte_identite;

        $this->dispatch('ui:show-offcanvas', id: 'offcanvasParticulier');
    }

    // Règles de validation spécifiques aux clients particuliers
    protected function rules(): array
    {
        $ignore = $this->editingId;

        return [
            'type_utilisateur' => ['required', Rule::in(['Client'])], // Type fixé à 'Client'
            'nom'              => ['required', 'string', 'max:255'],
            'prenom'           => ['nullable', 'string', 'max:255'],
            'profession'       => ['nullable', 'string', 'max:255'],
            'email'            => ['nullable', 'email', 'max:255', Rule::unique('users', 'email')->ignore($ignore)],
            'numero_telephone' => ['required', 'string', 'min:6', 'max:30', Rule::unique('users', 'numero_telephone')->ignore($ignore)],
            'numero_telephone_secondaire' => ['nullable', 'string', 'min:6', 'max:30'],
            'pays'             => ['nullable', 'string', 'max:120'],
            'ville'            => ['nullable', 'string', 'max:180'],
            'adresse'          => ['nullable', 'string', 'max:1000'],
            'date_naissance'        => ['nullable', 'date'],
            'genre'                 => ['nullable', Rule::in(['Homme', 'Femme', 'Autre'])],
            'numero_carte_identite' => ['nullable', 'string', 'max:190', Rule::unique('users', 'numero_carte_identite')->ignore($ignore)],
        ];
    }

    // Sauvegarde (création / modification)
    public function save(): void
    {
        $this->validate();

        if ($this->editingId) {
            // MISE À JOUR
            $user = User::findOrFail($this->editingId);
            $user->update([
                'type_utilisateur'            => 'Client',
                'prenom'                      => $this->prenom,
                'nom'                         => $this->nom,
                'profession'                  => $this->profession,
                'date_naissance'              => $this->date_naissance,
                'genre'                       => $this->genre,
                'email'                       => $this->email,
                'numero_telephone'            => $this->numero_telephone,
                'numero_telephone_secondaire' => $this->numero_telephone_secondaire,
                'pays'                        => $this->pays,
                'ville'                       => $this->ville,
                'adresse'                     => $this->adresse,
                'numero_carte_identite'       => $this->numero_carte_identite,
                // Assurez-vous que les champs non pertinents pour 'Client' sont nullifiés si nécessaire
                'date_creation' => null,
                'numero_ifu'    => null,
                'numero_rccm'   => null,
            ]);

            $name  = trim(($user->prenom ? $user->prenom . ' ' : '') . $user->nom);
            $this->dispatch('notify', type: 'success', text: "Client particulier « {$name} » modifié(e) avec succès.");
        } else {
            // CRÉATION
            $user = User::create([
                'id'                          => (string) Str::uuid(),
                'type_utilisateur'            => 'Client',
                'prenom'                      => $this->prenom,
                'nom'                         => $this->nom,
                'nom_utilisateur'             => null,
                'profession'                  => $this->profession,
                'date_naissance'              => $this->date_naissance,
                'genre'                       => $this->genre,
                'email'                       => $this->email,
                'numero_telephone'            => $this->numero_telephone,
                'numero_telephone_secondaire' => $this->numero_telephone_secondaire,
                'pays'                        => $this->pays,
                'ville'                       => $this->ville,
                'adresse'                     => $this->adresse,
                'numero_carte_identite'       => $this->numero_carte_identite,
                'date_creation'               => null,
                'numero_ifu'                  => null,
                'numero_rccm'                 => null,
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

            $name  = trim(($user->prenom ? $user->prenom . ' ' : '') . $user->nom);
            $this->dispatch('notify', type: 'success', text: "Client particulier « {$name} » créé(e) avec succès.");
        }

        // UI
        $this->dispatch('ui:hide-offcanvas', id: 'offcanvasParticulier');
        $this->dispatch('clients:refresh'); // Émettre un événement pour rafraîchir la table des clients
        $this->resetForm();
    }

    public function render()
    {
        return view('livewire.clients.offcanvas-create-particulier');
    }
}