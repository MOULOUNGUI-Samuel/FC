@extends('layouts.app')
@section('title', 'Liste des clients')
@section('content')
<main class="adminuiux-content has-sidebar" onclick="contentClick()">
  <div class="container mt-3" id="main-content">
    <div class="row gx-3 align-items-center">
      <div class="col-6 col-lg mb-3">
        <h3 class="fw-normal mb-0 text-secondary">Liste des particuliers</h3>
      </div>
      <div class="col-5"></div>
      <div class="col-1">
        <div class="text-left">
          <button class="btn btn-theme"
                  wire:click="$dispatch('open-create-offcanvas-particulier')" {{-- Simplifié --}}
                  data-bs-toggle="offcanvas" href="#offcanvasParticulier" role="button" aria-controls="offcanvasParticulier">
            <i class="bx bx-plus me-0 me-md-1"></i>
            <span class="d-none d-md-inline-block">Nouveau</span>
          </button>
        </div>
      </div>
    </div>

    <div class="card adminuiux-card mb-3">
      <div class="card-body">

        {{-- TABLE LIVEWIRE : type = Client --}}
        <livewire:clients.table-particulier type="Client" />
      </div>
    </div>
  </div>

  {{-- Offcanvas spécifique aux particuliers --}}
  <livewire:clients.offcanvas-create-particulier />
</main>
@endsection