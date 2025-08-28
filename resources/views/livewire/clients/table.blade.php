<div>
    {{-- Recherche --}}
    <div class="col-12 col-md-11 col-xxl-8 mb-3 mt-3">
        <div class="input-group">
            <input class="form-control border-end-0" type="text" placeholder="Rechercher…"
                wire:model.debounce.400ms="search">
            <button class="btn btn-lg btn-theme btn-square" type="button">
                <i class="bi bi-search"></i>
            </button>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table w-100 nowrap align-middle mb-0">
                <thead>
                    <tr>
                        <th class="all">Nom</th>
                        <th class="xs">Profession</th>
                        <th class="xs sm">Comptes</th>
                        <th class="xs sm">Membres associés</th>
                        <th class="xs sm">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clients as $c)
                        <tr wire:key="row-{{ $c->id }}">
                            <td>
                                <div class="row align-items-center flex-nowrap">
                                    <div class="col-auto">
                                        <figure class="avatar avatar-40 mb-0 coverimg rounded-circle">
                                            <img src="{{ asset('assets/img/modern-ai-image/user-6.jpg') }}"
                                                alt="">
                                        </figure>
                                    </div>
                                    <div class="col ps-0">
                                        <p class="mb-0 fw-medium">
                                            {{ trim($c->prenom . ' ' . $c->nom) ?: $c->nom }}
                                        </p>
                                        <p class="text-secondary small">
                                            {{ $c->ville ? $c->ville . ', ' : '' }}{{ $c->pays }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="mb-0">{{ $c->profession ?? '—' }}</p>
                            </td>
                            <td>
                                <p class="mb-0 text-success">
                                    <i class="menu-icon" data-feather="wallet"></i>
                                    {{ $c->accounts_count }} compte{{ $c->accounts_count > 1 ? 's' : '' }}
                                </p>
                            </td>
                            <td>
                                <div class="dropdown dropstart d-inline-block me-2 mb-3">
                                    <button class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        Membres associés
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">
                                                <i class="menu-icon me-2" data-feather="eye"></i>
                                                Voir les membres
                                            </a></li>
                                        <li><a class="dropdown-item" href="#">
                                                <i class="menu-icon me-2" data-feather="plus"></i>
                                                Ajouter un membre
                                            </a></li>
                                    </ul>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-outline-success"
                                        wire:click="$dispatch('clients:open-accounts', { id: '{{ $c->id }}' })">
                                        Compte du client
                                    </button>

                                    <button class="btn btn-sm btn-outline-success"
                                        wire:click="$dispatch('open-edit-offcanvas', { id: '{{ $c->id }}' })">
                                        Modifier
                                    </button>

                                    <button class="btn btn-sm btn-outline-danger"
                                        wire:click="confirmDelete('{{ $c->id }}')">
                                        Supprimer
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Aucun enregistrement</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{-- Place ce composant UNE FOIS par page (en bas) --}}
            <livewire:clients.accounts-modal />


            {{-- Modal Bootstrap de confirmation --}}
            <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirmer la suppression</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            Voulez-vous vraiment supprimer cet enregistrement ? Cette action est irréversible.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Annuler</button>
                            <button type="button" class="btn btn-danger" wire:click="deleteNow"
                                data-bs-dismiss="modal">Supprimer</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- @push('scripts') --}}
            <script>
                // Afficher la confirmation quand Livewire le demande
                window.addEventListener('confirm:show', () => {
                    const el = document.getElementById('confirmDeleteModal');
                    if (!el) return;
                    bootstrap.Modal.getOrCreateInstance(el).show();
                });
            </script>
            {{-- @endpush --}}

        </div>

        <div class="mt-2">
            {{ $clients->links() }}
        </div>
    </div>
</div>
