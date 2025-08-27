{{-- N.B. On est dans <form wire:submit.prevent="save"> --}}

<div class="col-12">
  <label class="form-label">Nom</label>
  <input type="text" class="form-control @error('nom') is-invalid @enderror"
         wire:model.live="nom" required>
  @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="col-12">
  <label class="form-label">Prénom</label>
  <input type="text" class="form-control" wire:model.live="prenom">
</div>

<div class="col-12">
  <label class="form-label">Profession</label>
  <input type="text" class="form-control" wire:model.live="profession">
</div>

<div class="col-12">
  <label class="form-label">Date de naissance</label>
  <input type="date" class="form-control @error('date_naissance') is-invalid @enderror"
         wire:model.live="date_naissance">
  @error('date_naissance') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="col-12">
  <label class="form-label">Sexe</label>
  <select class="form-select @error('genre') is-invalid @enderror" wire:model.live="genre">
    <option value="" disabled selected>Choisir…</option>
    <option value="Homme">Homme</option>
    <option value="Femme">Femme</option>
    <option value="Autre">Autre</option>
  </select>
  @error('genre') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="col-12">
  <label class="form-label">Téléphone 1</label>
  <input type="tel" class="form-control @error('numero_telephone') is-invalid @enderror"
         wire:model.live="numero_telephone" required>
  @error('numero_telephone') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="col-12">
  <label class="form-label">Téléphone 2</label>
  <input type="tel" class="form-control" wire:model.live="numero_telephone_secondaire">
</div>

<div class="col-12">
  <label class="form-label">Adresse mail</label>
  <input type="email" class="form-control @error('email') is-invalid @enderror"
         wire:model.live="email">
  @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="col-12">
  <label class="form-label">Pays</label>
  <select class="form-select" wire:model.live="pays">
    <option value="Gabon">Gabon</option>
    <option value="Cameroun">Cameroun</option>
    <option value="Côte d'Ivoire">Côte d'Ivoire</option>
    <option value="Congo">Congo</option>
    <option value="Sénégal">Sénégal</option>
    <option value="France">France</option>
  </select>
</div>

<div class="col-12">
  <label class="form-label">Ville</label>
  <input type="text" class="form-control" wire:model.live="ville">
</div>

<div class="col-12">
  <label class="form-label">Adresse</label>
  <input type="text" class="form-control" wire:model.live="adresse">
</div>

<div class="col-12">
  <label class="form-label">Numéro CI</label>
  <input type="text" class="form-control @error('numero_carte_identite') is-invalid @enderror"
         wire:model.live="numero_carte_identite">
  @error('numero_carte_identite') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="col-12 form-check">
  <input class="form-check-input" type="checkbox" id="creerCompte1" wire:model="creer_compte_par_defaut">
  <label class="form-check-label" for="creerCompte1">Créer un compte principal automatiquement</label>
</div>
