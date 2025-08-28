<div>
    <!-- modal-lg -->
    <div class="modal fade" id="lgmodal" tabindex="-1" aria-labelledby="lgmodalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0">
                    <p class="modal-title h5" id="lgmodalLabel">Compte d’un client</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body pt-0">
                    <div class="row g-0">
                        <!-- Panneau gauche -->
                        <div class="col-12 col-lg-5 d-none d-lg-flex align-items-end"
                            style="background:#0b3aa9;color:#fff;border-radius:.5rem;">
                            <div class="p-4 w-100">
                                <h5 class="fw-semibold mb-4">Comptes client</h5>
                                <img src="{{ asset('_assets/images/compte.png') }}" alt=""
                                    style="max-width:100%;height:auto;">
                            </div>
                        </div>

                        <!-- Panneau droit -->
                        <div class="col-12 col-lg-7 ps-lg-4">
                            @if ($user)
                                <!-- En-tête client -->
                                <div class="d-flex align-items-start justify-content-between mb-3">
                                    <div>
                                        <h5 class="mb-1 fw-semibold text-uppercase">{{ $user->nom ?? '' }}</h5>
                                        <div class="text-muted small">
                                            {{ $user->profession ?? '—' }}<br>
                                            {{ $user->numero_telephone ?? '' }}
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <button class="btn btn-sm btn-outline-primary" wire:click="refreshData">
                                            Actualiser <i class="bi bi-arrow-repeat ms-1"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Onglets -->
                                <ul class="nav nav-pills gap-2 mb-3">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#acc-actifs">
                                            Actif <span class="badge bg-light text-dark ms-1">{{ $totalActive }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#acc-inactifs">
                                            Inactif <span
                                                class="badge bg-light text-dark ms-1">{{ $totalInactive }}</span>
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <!-- Actifs -->
                                    <div class="tab-pane fade show active" id="acc-actifs">
                                        @forelse($active as $a)
                                            <div class="d-flex align-items-center justify-content-between p-3 mb-2 rounded"
                                                style="background:#e8f0ff;">
                                                <div class="d-flex align-items-center gap-3">
                                                    <span class="avatar avatar-10 rounded-circle"
                                                        style="background:#1b3fe5;display:inline-block;width:10px;height:10px;"></span>
                                                    <div>
                                                        <div class="fw-semibold text-uppercase">{{ $a['nom'] }}
                                                        </div>
                                                        <div class="text-muted small">{{ $a['numero'] }}</div>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="text-end">
                                                        <div class="fw-semibold">{{ $a['solde'] }}</div>
                                                    </div>
                                                    <a class="text-secondary" href="javascript:void(0)"
                                                        wire:click="openEditAccount('{{ $a['id'] }}')">
                                                        <i class="bx bx-pencil"></i>
                                                    </a>
                                                    <a class="text-danger" href="javascript:void(0)"
                                                        wire:click="confirmDeleteAccount('{{ $a['id'] }}')">
                                                        <i class="bx bx-trash"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="text-muted small">Aucun compte actif.</div>
                                        @endforelse
                                    </div>

                                    <!-- Inactifs -->
                                    <div class="tab-pane fade" id="acc-inactifs">
                                        @forelse($inactive as $a)
                                            <div
                                                class="d-flex align-items-center justify-content-between p-3 mb-2 rounded border">
                                                <div class="d-flex align-items-center gap-3">
                                                    <span class="avatar avatar-10 rounded-circle"
                                                        style="background:#6c757d;display:inline-block;width:10px;height:10px;"></span>
                                                    <div>
                                                        <div class="fw-semibold text-uppercase">{{ $a['nom'] }}
                                                        </div>
                                                        <div class="text-muted small">{{ $a['numero'] }} —
                                                            {{ $a['statut'] }}</div>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="text-end">
                                                        <div class="fw-semibold">{{ $a['solde'] }}</div>
                                                    </div>
                                                    <a class="text-secondary" href="javascript:void(0)"
                                                        wire:click="editAccount('{{ $a['id'] }}')"><i
                                                            class="bi bi-pencil"></i></a>
                                                    <a class="text-danger" href="javascript:void(0)"
                                                        wire:click="deleteAccount('{{ $a['id'] }}')"><i
                                                            class="bi bi-trash"></i></a>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="text-muted small">Aucun compte inactif.</div>
                                        @endforelse
                                    </div>
                                </div>
                            @else
                                <div class="text-muted">Sélectionnez un client…</div>
                            @endif
                        </div>
                    </div>
                </div>
                

                <div class="modal-footer border-0">
                    {{-- Bouton flottant pour créer un compte --}}
                <button type="button" class="btn btn-primary rounded-circle shadow "
                style=" width: 52px; height: 52px;"
                title="Nouveau compte" wire:click="openCreateAccount">
                +
            </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    {{-- Un bouton d’action globale si besoin --}}
                </div>
            </div>
        </div>
    </div>
    {{-- MODAL : Création d’un compte --}}
    <div class="modal fade" id="createAccountModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Fiche compte client</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>

                <div class="modal-body">
                    <form wire:submit.prevent="saveNewAccount" class="row g-3">
                        {{-- N° du compte + actions --}}
                        <div class="col-12">
                            <label class="form-label">N° du compte</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('new_numero') is-invalid @enderror"
                                    wire:model.defer="new_numero" placeholder="Généré automatiquement">
                                <button class="btn btn-outline-secondary" type="button"
                                    wire:click="regenerateNumero">
                                    Obtention du numéro…
                                </button>
                                <button class="btn btn-outline-primary" type="button" wire:click="regenerateNumero">
                                    Actualiser
                                </button>
                                @error('new_numero')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Intitulé --}}
                        <div class="col-12">
                            <label class="form-label">Intitulé du compte</label>
                            <input type="text" class="form-control @error('new_nom') is-invalid @enderror"
                                wire:model.defer="new_nom" required>
                            @error('new_nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Type --}}
                        <div class="col-12">
                            <label class="form-label">Type de compte</label>
                            <select class="form-select @error('new_type') is-invalid @enderror"
                                wire:model.defer="new_type" required>
                                <option value="Principal">PRINCIPAL</option>
                                <option value="Epargne">ÉPARGNE</option>
                                <option value="Projet">PROJET</option>
                                <option value="Autre">AUTRE</option>
                            </select>
                            @error('new_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Découvert max --}}
                        <div class="col-12">
                            <label class="form-label">Découvert max</label>
                            <div class="input-group">
                                <input type="number" step="0.01"
                                    class="form-control @error('new_plafond') is-invalid @enderror"
                                    wire:model.defer="new_plafond" placeholder="0,00">
                                <span class="input-group-text">,00</span>
                                @error('new_plafond')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Etats --}}
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="new_inactif"
                                    wire:model="new_inactif">
                                <label class="form-check-label" for="new_inactif">Le compte est inactif</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="new_prive"
                                    wire:model="new_prive">
                                <label class="form-check-label" for="new_prive">Ce compte est privé *</label>
                            </div>
                            <div class="form-text">
                                * Les comptes privés sont visibles uniquement par le superviseur du FCI.
                                {{-- @if (!Schema::hasColumn('accounts', 'est_prive'))
                                    <br><span class="text-warning">⚠️ Note : la colonne <code>est_prive</code> n’existe
                                        pas dans la table
                                        <code>accounts</code>. Cette option est pour l’instant visuelle.</span>
                                @endif --}}
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="col-12 d-flex gap-2 mt-2">
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Annuler</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- MINI-MODAL : Confirmation suppression --}}
    <div class="modal fade" id="confirmAccountDelete" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h6 class="modal-title">Confirmation</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    Supprimer ce compte ? Cette action est irréversible.
                </div>
                <div class="modal-footer py-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm"
                        data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-danger btn-sm" wire:click="deleteAccountNow"
                        data-bs-dismiss="modal">Supprimer</button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL : Edition compte --}}
    <div class="modal fade" id="editAccountModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier le compte</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>

                <div class="modal-body">
                    <form wire:submit.prevent="saveAccountEdit" class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nom</label>
                            <input type="text" class="form-control @error('edit_nom') is-invalid @enderror"
                                wire:model.defer="edit_nom" required>
                            @error('edit_nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label">Type</label>
                            <select class="form-select @error('edit_type') is-invalid @enderror"
                                wire:model.defer="edit_type" required>
                                <option value="Principal">Principal</option>
                                <option value="Epargne">Epargne</option>
                                <option value="Projet">Projet</option>
                                <option value="Autre">Autre</option>
                            </select>
                            @error('edit_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label">Statut</label>
                            <select class="form-select @error('edit_statut') is-invalid @enderror"
                                wire:model.defer="edit_statut" required>
                                <option value="Actif">Actif</option>
                                <option value="Bloque">Bloqué</option>
                                <option value="Cloture">Clôturé</option>
                            </select>
                            @error('edit_statut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Plafond (optionnel)</label>
                            <input type="number" step="0.01"
                                class="form-control @error('edit_plafond') is-invalid @enderror"
                                wire:model.defer="edit_plafond" placeholder="0.00">
                            @error('edit_plafond')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 text-end">
                            <button type="button" class="btn btn-outline-secondary me-2"
                                data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('modal:show', e => {
            const el = document.getElementById(e.detail?.id);
            if (el) bootstrap.Modal.getOrCreateInstance(el).show();
        });
        window.addEventListener('modal:hide', e => {
            const el = document.getElementById(e.detail?.id);
            if (el) bootstrap.Modal.getOrCreateInstance(el).hide();
        });
    </script>
    {{-- @push('scripts') --}}
    <script>
        // Ouvrir la modale depuis Livewire
        window.addEventListener('modal:show', e => {
            const id = e.detail?.id || 'lgmodal';
            const el = document.getElementById(id);
            if (!el) return;
            bootstrap.Modal.getOrCreateInstance(el).show();
        });

        // Optionnel: toast global déjà montré dans tes autres vues
        window.addEventListener('notify', e => {
            // branche ton système de toast si besoin
            console.log(e.detail?.text || 'Info');
        });
    </script>
    <script>
        // helpers pour afficher/fermer les modales via events Livewire
        window.addEventListener('modal:show', e => {
            const el = document.getElementById(e.detail?.id);
            if (el) bootstrap.Modal.getOrCreateInstance(el).show();
        });
        window.addEventListener('modal:hide', e => {
            const el = document.getElementById(e.detail?.id);
            if (el) bootstrap.Modal.getOrCreateInstance(el).hide();
        });
    </script>
    {{-- @endpush --}}
</div>
