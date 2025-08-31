@extends('layouts.app')
@section('title', 'Liste des clients')
@section('content')
<main class="adminuiux-content has-sidebar" onclick="contentClick()">
  <div class="container mt-3" id="main-content">
        <h3 class="fw-normal mb-0 text-secondary mb-3">Liste des particuliers</h3>

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