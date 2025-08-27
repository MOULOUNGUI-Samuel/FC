<?php

namespace App\Livewire\Clients;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    /** @var string Client|Utilisateur */
    public string $type = 'Client';

    public string $search = '';
    public ?string $pendingDeleteId = null;

    #[On('clients:refresh')]
    public function refreshList()
    {
        $this->resetPage();
        $this->dispatch('$refresh');
    }

    public function confirmDelete(string $id): void
    {
        $this->pendingDeleteId = $id;
        // Ouvre une modal de confirmation côté JS
        $this->dispatch('confirm:show');
    }

    public function deleteNow(): void
    {
        if (!$this->pendingDeleteId) return;

        $u = User::find($this->pendingDeleteId);
        if ($u) {
            $name  = trim(($u->prenom ? $u->prenom . ' ' : '') . $u->nom);
            $label = $u->type_utilisateur === 'Client' ? 'Client' : 'Entité / Société';

            // Si tu veux un "soft delete", ajoute SoftDeletes à User et remplace par $u->delete();
            $u->delete(); // ⚠️ hard delete; tes comptes seront supprimés via onDelete('cascade') de la FK

            $this->dispatch('notify', type: 'success', text: "{$label} « {$name} » supprimé(e).");
        }

        $this->pendingDeleteId = null;
        $this->resetPage();
        $this->dispatch('$refresh');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = User::query()
            ->withCount('accounts')
            ->where('type_utilisateur', $this->type)
            ->when($this->search, function ($q) {
                $s = "%{$this->search}%";
                $q->where(function ($qq) use ($s) {
                    $qq->where('nom', 'like', $s)
                        ->orWhere('prenom', 'like', $s)
                        ->orWhere('profession', 'like', $s)
                        ->orWhere('email', 'like', $s)
                        ->orWhere('numero_telephone', 'like', $s);
                });
            })
            ->latest();

        $clients = $query->paginate(10);

        return view('livewire.clients.table', compact('clients'));
    }
}
