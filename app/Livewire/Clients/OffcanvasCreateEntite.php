<?php

namespace App\Livewire\Clients;

use App\Models\User;
use App\Models\Account;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class OffcanvasCreateEntite extends Component
{
    public string $type_utilisateur = 'Utilisateur'; // Ce composant est spécifiquement pour les fonds/entités
    public ?string $editingId = null;

    // Champs spécifiques aux fonds/entités
    public ?string $nom = null;
    public ?string $prenom = null; // Peut-être utilisé pour un contact principal
    public ?string $email = null;
    public ?string $numero_telephone = null;
    public ?string $numero_telephone_secondaire = null;
    public ?string $pays = 'Gabon';
    public ?string $ville = null;
    public ?string $adresse = null;
    public ?string $date_creation = null;
    public ?string $numero_ifu = null;
    public ?string $numero_rccm = null;

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
        $this->email = null;
        $this->numero_telephone = null;
        $this->numero_telephone_secondaire = null;
        $this->pays = 'Gabon';
        $this->ville = null;
        $this->adresse = null;
        $this->date_creation = null;
        $this->numero_ifu = null;
        $this->numero_rccm = null;
        $this->creer_compte_par_defaut = true;
    }

    #[On('open-create-offcanvas-entite')]
    public function open(): void
    {
        $this->resetValidation();
        $this->resetForm();
        $this->editingId = null;
        $this->type_utilisateur = 'Utilisateur'; // S'assurer que le type est bien 'Utilisateur'
        $this->dispatch('ui:show-offcanvas', id: 'offcanvasEntite');
    }

    #[On('open-edit-offcanvas-entite')] // Nouvel événement pour l'édition d'entités
    public function openEdit(string $id): void
    {
        $this->resetValidation();
        $this->resetForm();

        $user = User::findOrFail($id);
        if ($user->type_utilisateur !== 'Utilisateur') {
            // Optionnel: Gérer le cas où l'ID n'est pas un fonds/entité
            $this->dispatch('notify', type: 'danger', text: 'Ce n\'est pas un fonds ou une entité.');
            return;
        }

        $this->editingId = $user->id;
        $this->type_utilisateur = 'Utilisateur'; // Assurez-vous que le type est correct

        // Remplir les champs
        $this->nom                       = $user->nom;
        $this->prenom                    = $user->prenom;
        $this->email                     = $user->email;
        $this->numero_telephone          = $user->numero_telephone;
        $this->numero_telephone_secondaire = $user->numero_telephone_secondaire;
        $this->pays                      = $user->pays ?? 'Gabon';
        $this->ville                     = $user->ville;
        $this->adresse                   = $user->adresse;
        $this->date_creation             = $user->date_creation ? $user->date_creation->format('Y-m-d') : null;
        $this->numero_ifu                = $user->numero_ifu;
        $this->numero_rccm               = $user->numero_rccm;

        $this->dispatch('ui:show-offcanvas', id: 'offcanvasEntite');
    }

    // Règles de validation spécifiques aux fonds/entités
    protected function rules(): array
    {
        $ignore = $this->editingId;

        return [
            'type_utilisateur' => ['required', Rule::in(['Utilisateur'])], // Type fixé à 'Utilisateur'
            'nom'              => ['required', 'string', 'max:255'],
            'prenom'           => ['nullable', 'string', 'max:255'], // Peut être le nom du contact principal
            'email'            => ['nullable', 'email', 'max:255', Rule::unique('users', 'email')->ignore($ignore)],
            'numero_telephone' => ['required', 'string', 'min:6', 'max:30', Rule::unique('users', 'numero_telephone')->ignore($ignore)],
            'numero_telephone_secondaire' => ['nullable', 'string', 'min:6', 'max:30'],
            'pays'             => ['nullable', 'string', 'max:120'],
            'ville'            => ['nullable', 'string', 'max:180'],
            'adresse'          => ['nullable', 'string', 'max:1000'],
            'date_creation' => ['nullable', 'date'],
            'numero_ifu'    => ['nullable', 'string', 'max:190', Rule::unique('users', 'numero_ifu')->ignore($ignore)],
            'numero_rccm'   => ['nullable', 'string', 'max:190', Rule::unique('users', 'numero_rccm')->ignore($ignore)],
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
                'type_utilisateur'            => 'Utilisateur',
                'prenom'                      => $this->prenom,
                'nom'                         => $this->nom,
                'email'                       => $this->email,
                'numero_telephone'            => $this->numero_telephone,
                'numero_telephone_secondaire' => $this->numero_telephone_secondaire,
                'pays'                        => $this->pays,
                'ville'                       => $this->ville,
                'adresse'                     => $this->adresse,
                'date_creation'               => $this->date_creation,
                'numero_ifu'                  => $this->numero_ifu,
                'numero_rccm'                 => $this->numero_rccm,
                // Assurez-vous que les champs non pertinents pour 'Utilisateur' sont nullifiés si nécessaire
                'profession'            => null,
                'date_naissance'        => null,
                'genre'                 => null,
                'numero_carte_identite' => null,
            ]);

            $name  = trim(($user->prenom ? $user->prenom . ' ' : '') . $user->nom);
            $this->dispatch('notify', type: 'success', text: "Fonds / Entité « {$name} » modifié(e) avec succès.");
        } else {
            // CRÉATION
            $user = User::create([
                'id'                          => (string) Str::uuid(),
                'type_utilisateur'            => 'Utilisateur',
                'prenom'                      => $this->prenom,
                'nom'                         => $this->nom,
                'nom_utilisateur'             => null,
                'email'                       => $this->email,
                'numero_telephone'            => $this->numero_telephone,
                'numero_telephone_secondaire' => $this->numero_telephone_secondaire,
                'pays'                        => $this->pays,
                'ville'                       => $this->ville,
                'adresse'                     => $this->adresse,
                'date_creation'               => $this->date_creation,
                'numero_ifu'                  => $this->numero_ifu,
                'numero_rccm'                 => $this->numero_rccm,
                'profession'                  => null,
                'date_naissance'              => null,
                'genre'                       => null,
                'numero_carte_identite'       => null,
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
            $this->dispatch('notify', type: 'success', text: "Fonds / Entité « {$name} » créé(e) avec succès.");
        }

        // UI
        $this->dispatch('ui:hide-offcanvas', id: 'offcanvasEntite');
        $this->dispatch('clients:refresh');
        $this->resetForm();
    }

    public function render()
    {
        return view('livewire.clients.offcanvas-create-entite');
    }
}