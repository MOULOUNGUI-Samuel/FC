<?php

namespace App\Livewire\Clients;

use App\Models\User;
use App\Models\Account;
use Livewire\Attributes\On;
use Livewire\Component;

class AccountsModal extends Component
{
    public ?string $userId = null;
    public ?User $user = null;

    public array $active = [];
    public array $inactive = [];
    public int $totalActive = 0;
    public int $totalInactive = 0;

    // --------- Suppression ----------
    public ?string $pendingDeleteAccountId = null;

    // --------- Edition ----------
    public ?string $editingAccountId = null;
    public ?string $edit_nom = null;
    public ?string $edit_type = 'Principal';      // Principal | Epargne | Projet | Autre
    public ?string $edit_statut = 'Actif';        // Actif | Bloque | Cloture
    public ?float  $edit_plafond = null;

    #[On('clients:open-accounts')]
    public function open(string $id): void
    {
        $this->userId = $id;
        $this->loadData();
        $this->dispatch('modal:show', id: 'lgmodal');
    }

    public function refreshData(): void
    {
        $this->loadData();
        $this->dispatch('notify', type: 'info', text: 'Comptes actualisés.');
    }

    protected function loadData(): void
    {
        $this->user = User::with(['accounts' => fn($q) => $q->orderBy('created_at','desc')])
            ->findOrFail($this->userId);

        $this->active = $this->inactive = [];
        foreach ($this->user->accounts as $acc) {
            $row = [
                'id'     => $acc->id,
                'nom'    => $acc->nom,
                'numero' => $acc->numero_compte,
                'type'   => $acc->type,
                'statut' => $acc->statut,
                'solde'  => number_format((float)$acc->solde, 0, ',', ' '),
            ];
            ($acc->statut === 'Actif') ? $this->active[] = $row : $this->inactive[] = $row;
        }
        $this->totalActive = count($this->active);
        $this->totalInactive = count($this->inactive);
    }

    /* ========== SUPPRESSION avec mini-modal ========== */
    public function confirmDeleteAccount(string $accountId): void
    {
        $this->pendingDeleteAccountId = $accountId;
        $this->dispatch('modal:show', id: 'confirmAccountDelete');
    }

    public function deleteAccountNow(): void
    {
        if (!$this->pendingDeleteAccountId) return;

        $acc = Account::find($this->pendingDeleteAccountId);
        if ($acc) {
            $acc->delete(); // hard delete (tu peux passer en soft si besoin)
            $this->dispatch('notify', type:'success', text:'Compte supprimé.');
        }
        $this->pendingDeleteAccountId = null;
        $this->refreshData();
    }

    /* ========== EDITION ========== */
    public function openEditAccount(string $accountId): void
    {
        $acc = Account::findOrFail($accountId);
        $this->editingAccountId = $acc->id;
        $this->edit_nom    = $acc->nom;
        $this->edit_type   = $acc->type;
        $this->edit_statut = $acc->statut;
        $this->edit_plafond = $acc->plafond ? (float)$acc->plafond : null;

        $this->dispatch('modal:show', id: 'editAccountModal');
    }

    public function saveAccountEdit(): void
    {
        $this->validate([
            'edit_nom'    => ['required','string','max:255'],
            'edit_type'   => ['required','in:Principal,Epargne,Projet,Autre'],
            'edit_statut' => ['required','in:Actif,Bloque,Cloture'],
            'edit_plafond'=> ['nullable','numeric','min:0'],
        ]);

        $acc = Account::findOrFail($this->editingAccountId);
        $acc->update([
            'nom'     => $this->edit_nom,
            'type'    => $this->edit_type,
            'statut'  => $this->edit_statut,
            'plafond' => $this->edit_plafond,
        ]);

        $this->dispatch('notify', type:'success', text:'Compte modifié.');
        $this->dispatch('modal:hide', id:'editAccountModal');
        $this->editingAccountId = null;

        $this->refreshData();
    }
// ==== CREATION ====
public bool $creating = false;

public ?string $new_numero = null;
public ?string $new_nom = null;
public string  $new_type = 'Principal';          // Principal|Epargne|Projet|Autre
public ?float  $new_plafond = null;              // Découvert max -> colonne 'plafond'
public bool    $new_inactif = false;             // -> statut Bloque si true
public bool    $new_prive = false;  

    public function openCreateAccount(): void
{
    $this->creating = true;
    $this->new_numero = $this->generateNumeroUnique();
    $this->new_nom = null;
    $this->new_type = 'Principal';
    $this->new_plafond = null;
    $this->new_inactif = false;
    $this->new_prive = false;

    $this->dispatch('modal:show', id: 'createAccountModal');
}

public function regenerateNumero(): void
{
    $this->new_numero = $this->generateNumeroUnique();
}

protected function generateNumeroUnique(): string
{
    // AC + yymmdd + 6 chiffres — on garantit l’unicité par une boucle
    do {
        $candidate = 'AC'.date('ymd').substr((string) mt_rand(100000, 999999), 0, 6);
    } while (\App\Models\Account::where('numero_compte', $candidate)->exists());

    return $candidate;
}

public function saveNewAccount(): void
{
    $this->validate([
        'new_nom'      => ['required','string','max:255'],
        'new_type'     => ['required','in:Principal,Epargne,Projet,Autre'],
        'new_numero'   => ['required','string','max:190','unique:accounts,numero_compte'],
        'new_plafond'  => ['nullable','numeric','min:0'],
    ], [], [
        'new_nom' => 'intitulé du compte',
        'new_numero' => 'numéro du compte',
        'new_type' => 'type du compte',
        'new_plafond' => 'découvert max',
    ]);

    \App\Models\Account::create([
        'id'            => (string) \Illuminate\Support\Str::uuid(),
        'user_id'       => $this->userId,
        'numero_compte' => $this->new_numero,
        'nom'           => $this->new_nom,
        'type'          => $this->new_type,
        'plafond'       => $this->new_plafond,
        'statut'        => $this->new_inactif ? 'Bloque' : 'Actif',
        // 'est_prive'   => $this->new_prive, // décommente si tu ajoutes la colonne
        'solde'         => 0,
    ]);

    $this->dispatch('notify', type:'success', text:'Compte créé avec succès.');
    $this->dispatch('modal:hide', id:'createAccountModal');

    $this->creating = false;
    $this->refreshData();
}

    public function render()
    {
        return view('livewire.clients.accounts-modal');
    }
}
