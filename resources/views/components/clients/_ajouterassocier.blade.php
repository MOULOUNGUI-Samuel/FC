<div class="col-12">
  <label class="form-label">Nom</label>
  <input type="text" class="form-control @error('nom') is-invalid @enderror"
         wire:model.live="nom" required>
  @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="col-12">
  <label class="form-label">Date de création</label>
  <input type="date" class="form-control @error('date_creation') is-invalid @enderror"
         wire:model.live="date_creation">
  @error('date_creation') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
  <textarea class="form-control" rows="1" wire:model.live="adresse"></textarea>
</div>

<div class="col-12">
  <label class="form-label">Numéro IFU</label>
  <input type="text" class="form-control @error('numero_ifu') is-invalid @enderror"
         wire:model.live="numero_ifu">
  @error('numero_ifu') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="col-12">
  <label class="form-label">Numéro RCCM</label>
  <input type="text" class="form-control @error('numero_rccm') is-invalid @enderror"
         wire:model.live="numero_rccm">
  @error('numero_rccm') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="col-12 form-check">
  <input class="form-check-input" type="checkbox" id="creerCompte2" wire:model="creer_compte_par_defaut">
  <label class="form-check-label" for="creerCompte2">Créer un compte principal automatiquement</label>
</div>
