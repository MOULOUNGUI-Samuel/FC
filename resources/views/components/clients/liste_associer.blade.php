@extends('layouts.app')
@section('title', 'Liste des clients')
@section('content')
<main class="adminuiux-content has-sidebar" onclick="contentClick()">
  <div class="container mt-3" id="main-content">
        <h3 class="fw-normal mb-0 text-secondary mb-3">Liste des fonds / Entités</h3>
    <div class="card adminuiux-card mb-3">
      <div class="card-body">
        {{-- TABLE LIVEWIRE : type = Utilisateur --}}
        <livewire:clients.table-entite type="Utilisateur" />
      </div>
    </div>
  </div>

  {{-- Offcanvas spécifique aux fonds/entités --}}
  <livewire:clients.offcanvas-create-entite />
</main>
@endsection