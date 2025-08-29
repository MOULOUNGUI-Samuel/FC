@extends('layouts.app')
@section('title', 'Liste des clients')
@section('content')
<main class="adminuiux-content has-sidebar" onclick="contentClick()">
  <div class="container mt-3" id="main-content">
    <div class="row gx-3 align-items-center">
      <div class="col-6 col-lg mb-3">
        <h3 class="fw-normal mb-0 text-secondary">Liste des clients (Fonds / Entités)</h3>
      </div>
      <div class="col-5"></div>
      <div class="col-1">
        <div class="text-left">
          <button class="btn btn-theme"
                  wire:click="$dispatch('open-create-offcanvas-entite')" {{-- Simplifié --}}
                  data-bs-toggle="offcanvas" href="#offcanvasEntite" role="button" aria-controls="offcanvasEntite">
            <i class="bx bx-plus me-0 me-md-1"></i>
            <span class="d-none d-md-inline-block">Nouveau</span>
          </button>
        </div>
      </div>
    </div>

    <div class="card adminuiux-card mb-3">
      <div class="card-body">
        <ul class="nav nav-tabs adminuiux-tabs" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <a href="{{ route('liste.index') }}" class="nav-link">Particulier</a>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link active">Fonds /Entitées</button>
          </li>
        </ul>
        {{-- TABLE LIVEWIRE : type = Utilisateur --}}
        <livewire:clients.table type="Utilisateur" />
      </div>
    </div>
  </div>

  {{-- Offcanvas spécifique aux fonds/entités --}}
  <livewire:clients.offcanvas-create-entite />
</main>
@endsection