<!-- Offcanvas pour la création/édition de Fonds / Entités (Utilisateur) -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEntite" aria-labelledby="offcanvasEntiteLabel" wire:ignore.self>
    <div class="offcanvas-header">
        <p class="h5 offcanvas-title" id="offcanvasEntiteLabel">
            {{ $editingId ? 'Modifier un fonds / une entité' : 'Nouveau fonds / nouvelle entité' }}
        </p>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">
        <div class="card-body">
            <div wire:key="form-entite">
                <form class="row g-3 needs-validation" novalidate wire:submit.prevent="save"> {{-- Removed was-validated --}}
                    @include('components.clients._ajouterassocier')

                    <div class="col-12 d-flex gap-2">
                        <button class="btn btn-primary" type="submit">
                            {{ $editingId ? 'Mettre à jour' : 'Enregistrer' }}
                        </button>
                        <button type="button" class="btn btn-outline-secondary"
                            data-bs-dismiss="offcanvas">Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Le script Livewire pour les offcanvas peut être dans un fichier commun ou intégré dans chaque composant --}}
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('ui:show-offcanvas', (event) => {
            const offcanvasId = event.id || 'offcanvasEntite'; // Utilisez l'ID de l'offcanvas
            const offcanvasElement = document.getElementById(offcanvasId);
            if (offcanvasElement) {
                bootstrap.Offcanvas.getOrCreateInstance(offcanvasElement).show();
            }
        });

        Livewire.on('ui:hide-offcanvas', (event) => {
            const offcanvasId = event.id || 'offcanvasEntite'; // Utilisez l'ID de l'offcanvas
            const offcanvasElement = document.getElementById(offcanvasId);
            if (offcanvasElement) {
                bootstrap.Offcanvas.getOrCreateInstance(offcanvasElement).hide();
            }
        });

        Livewire.on('notify', (event) => {
            const { type = 'success', text = 'Action effectuée.' } = event;
            const toastEl = document.getElementById('liveToast');
            const bodyEl = document.getElementById('liveToastBody');
            if (!toastEl || !bodyEl) return;

            toastEl.className = 'toast align-items-center border-0 text-bg-' + (
                ['success', 'danger', 'warning', 'info'].includes(type) ? type : 'success'
            );
            bodyEl.textContent = text;
            bootstrap.Toast.getOrCreateInstance(toastEl, { delay: 3500 }).show();
        });
    });
</script>