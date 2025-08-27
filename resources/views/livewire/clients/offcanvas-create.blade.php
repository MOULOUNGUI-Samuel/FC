<!-- off canvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="particulier" aria-labelledby="particulierOffcanva" wire:ignore.self>
    <div class="offcanvas-header">
        <p class="h5 offcanvas-title" id="particulierOffcanva">Nouvel enrégistrement</p>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">
        <div class="card-body">

            {{-- Tabs Bootstrap --}}
            <ul class="nav nav-tabs adminuiux-tabs text-center" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $tab === 'client' ? 'active' : '' }}" id="Particulier-tab"
                        data-bs-toggle="tab" data-bs-target="#Particulier-tab-pane" type="button" role="tab"
                        aria-controls="Particulier-tab-pane" aria-selected="{{ $tab === 'client' ? 'true' : 'false' }}"
                        wire:click="selectType('Client')">
                        Est une personne morale
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $tab === 'associe' ? 'active' : '' }}" id="Fondentite-tab"
                        data-bs-toggle="tab" data-bs-target="#Fondentite-tab-pane" type="button" role="tab"
                        aria-controls="Fondentite-tab-pane" aria-selected="{{ $tab === 'associe' ? 'true' : 'false' }}"
                        wire:click="selectType('Utilisateur')">
                        Est associé
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade {{ $tab === 'client' ? 'show active' : '' }}" id="Particulier-tab-pane"
                    role="tabpanel" aria-labelledby="Particulier-tab" tabindex="0">
                    <br>
                    <p class="h5">Est une personne morale</p>

                    <form class="row g-3 needs-validation was-validated" novalidate wire:submit.prevent="save">
                        {{-- Pas obligatoire, mais si tu veux visualiser le type dans le DOM: --}}
                        {{-- <input type="hidden" value="{{ $type_utilisateur }}"> --}}
                        @include('components.clients._ajouterParticulier')
                        <div class="col-12 d-flex gap-2">
                            <button class="btn btn-primary" type="submit">Enregistrer</button>
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="offcanvas">Annuler</button>
                        </div>
                    </form>
                </div>

                <div class="tab-pane fade {{ $tab === 'associe' ? 'show active' : '' }}" id="Fondentite-tab-pane"
                    role="tabpanel" aria-labelledby="Fondentite-tab" tabindex="0">
                    <br>
                    <p class="h5">Est associé</p>

                    <form class="row g-3 needs-validation was-validated" novalidate wire:submit.prevent="save">
                        @include('components.clients._ajouterFondEntitee')
                        <div class="col-12 d-flex gap-2">
                            <button class="btn btn-primary" type="submit">Enregistrer</button>
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="offcanvas">Annuler</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
  // ouvrir/fermer l’offcanvas (déjà chez toi)
  window.addEventListener('ui:show-offcanvas', e => {
    const el = document.getElementById(e.detail.id || 'particulier');
    if (!el) return; bootstrap.Offcanvas.getOrCreateInstance(el).show();
  });
  window.addEventListener('ui:hide-offcanvas', e => {
    const el = document.getElementById(e.detail.id || 'particulier');
    if (!el) return; bootstrap.Offcanvas.getOrCreateInstance(el).hide();
  });

  // ✅ Toast de confirmation
  window.addEventListener('notify', e => {
    const { type = 'success', text = 'Action effectuée.' } = e.detail || {};
    const toastEl = document.getElementById('liveToast');
    const bodyEl  = document.getElementById('liveToastBody');
    if (!toastEl || !bodyEl) return;

    // Couleur selon le type (success | danger | warning | info)
    toastEl.className = 'toast align-items-center border-0 text-bg-' + (
      ['success','danger','warning','info'].includes(type) ? type : 'success'
    );

    bodyEl.textContent = text;
    bootstrap.Toast.getOrCreateInstance(toastEl, { delay: 3500 }).show();
  });
</script>
