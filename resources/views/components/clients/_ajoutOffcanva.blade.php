<!-- off canvas live offcanvas-start -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="particulier" aria-labelledby="particulierOffcanva">
    <div class="offcanvas-header">
        <p class="h5 offcanvas-title" id="particulierOffcanva">Nouvel enrégistrement</p>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="card-body">
            <ul class="nav nav-tabs adminuiux-tabs text-center" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="Particulier-tab" data-bs-toggle="tab"
                        data-bs-target="#Particulier-tab-pane" type="button" role="tab"
                        aria-controls="Particulier-tab-pane" aria-selected="true">Est une personne morale</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="Fondentite-tab" data-bs-toggle="tab"
                        data-bs-target="#Fondentite-tab-pane" type="button" role="tab"
                        aria-controls="Fondentite-tab-pane" aria-selected="false">Est associé</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="Particulier-tab-pane" role="tabpanel"
                    aria-labelledby="Particulier-tab" tabindex="0">
                    <br>
                    <p class="h5">Est une personne morale</p>
                    @include('components.clients._ajouterParticulier')
                </div>
                <div class="tab-pane fade" id="Fondentite-tab-pane" role="tabpanel" aria-labelledby="Fondentite-tab"
                    tabindex="0">
                    <br>
                    <p class="h5">Est associé</p>
                    @include('components.clients._ajouterFondEntitee')
                </div>
            </div>
        </div>
    </div>
</div>
