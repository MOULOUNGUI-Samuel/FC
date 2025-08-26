@extends('layouts.app')

@section('title', 'Liste des clients')

@section('content')

    <main class="adminuiux-content has-sidebar" onclick="contentClick()">

        <!-- Content  -->
        <div class="container mt-3" id="main-content">
            <div class="row gx-3 align-items-center">
                <div class="col-12 col-lg mb-3">
                    <h3 class="fw-normal mb-0 text-secondary">Liste des clients</h3>
                </div>

            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card adminuiux-card mb-3">
                        <div class="card-body">
                            <ul class="nav nav-tabs adminuiux-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                        data-bs-target="#home-tab-pane" type="button" role="tab"
                                        aria-controls="home-tab-pane" aria-selected="true">Particulier</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                        data-bs-target="#profile-tab-pane" type="button" role="tab"
                                        aria-controls="profile-tab-pane" aria-selected="false">Fonds /Entitées</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="col-12 col-md-11 col-xxl-8 mb-3 mt-3">
                                    <div class="input-group">
                                        <input class="form-control border-end-0" type="text"
                                            placeholder="Search investment plans">
                                        <button class="btn btn-lg btn-theme btn-square"><i
                                                class="bi bi-search"></i></button>
                                    </div>
                                </div>
                                <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel"
                                    aria-labelledby="home-tab" tabindex="0">
                                    <br>
                                    <p class="h5">Particulier</p>

                                    <div class="card-body">
                                        <table class="table mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="all">Photo</th>
                                                    <th class="all">Nom</th>
                                                    <th class="xs">Profession</th>
                                                    <th class="xs sm">Comptes</th>
                                                    <th class="xs sm">Membres associés</th>
                                                    <th class="xs sm">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <p class="mb-0">Jintudal</p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0">MOULOUNGUI BIENVENUE SAMARA</p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0">Informaticien</p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0 text-success"><i class="bi bi-graph-up-arrow"></i> 3
                                                            comptes</p>
                                                    </td>
                                                    <td>
                                                        <div class="dropdown d-inline-block">
                                                            <a class="btn btn-link btn-square no-caret"
                                                                data-bs-toggle="dropdown">
                                                                <i class="bi bi-three-dots">membres</i>
                                                            </a>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li><a class="dropdown-item" href="javascript:void(0)">Voir
                                                                        les membres</a>
                                                                </li>
                                                                <li><a class="dropdown-item"
                                                                        href="javascript:void(0)">Ajouter un membre</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-success">Modifier</button>
                                                        <button class="btn btn-sm btn-outline-danger">Supprimer</button>

                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel"
                                    aria-labelledby="profile-tab" tabindex="0">
                                    <br>
                                    <p class="h5">Fonds /Entitées</p>
                                    <div class="card-body">
                                        <table class="table mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="all">Photo</th>
                                                    <th class="all">Nom</th>
                                                    <th class="xs">Profession</th>
                                                    <th class="xs sm">Comptes</th>
                                                    <th class="xs sm">Membres associés</th>
                                                    <th class="xs sm">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <p class="mb-0">Jintudal</p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0">MOULOUNGUI BIENVENUE SAMARA</p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0">Informaticien</p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0 text-success"><i class="bi bi-graph-up-arrow"></i> 3
                                                            comptes</p>
                                                    </td>
                                                    <td>
                                                        <div class="dropdown d-inline-block">
                                                            <a class="btn btn-link btn-square no-caret"
                                                                data-bs-toggle="dropdown">
                                                                <i class="bi bi-three-dots">membres</i>
                                                            </a>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li><a class="dropdown-item" href="javascript:void(0)">Voir
                                                                        les membres</a>
                                                                </li>
                                                                <li><a class="dropdown-item"
                                                                        href="javascript:void(0)">Ajouter un membre</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-success">Modifier</button>
                                                        <button class="btn btn-sm btn-outline-danger">Supprimer</button>

                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                    x
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>
@endsection
