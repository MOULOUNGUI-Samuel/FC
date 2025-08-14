@extends('layouts.app')

@section('title', 'Liste des clients')

@section('content')
    <style>
        /* Avatar gris circulaire */
        .avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #e9ecef;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #adb5bd;
            font-size: 1.25rem;
            flex: 0 0 44px;
        }

        /* Ligne active (sélection) */
        .item-active {
            background: #d8ecff;
        }

        /* bleu clair */
        .list-item {
            border: 1px solid #e5e7eb;
        }

        .list-item+.list-item {
            border-top: none;
        }

        /* joints propres */
        .name {
            font-weight: 700;
            letter-spacing: .3px;
            color: #2d2d2d;
        }

        .role {
            color: #8f9aa3;
            font-size: .85rem;
            margin-top: .15rem;
        }

        .actions .btn {
            --bs-btn-padding-y: .35rem;
            --bs-btn-padding-x: .5rem;
        }

        .badge-comptes {
            background: #0d34a6;
            /* bleu foncé proche de la capture */
            border-radius: 999px;
            padding: .35rem .7rem;
            font-weight: 700;
        }

        .dropdown-toggle-soft {
            background: #eef2f6;
            color: #7a8591;
            border: 1px solid #e3e7eb;
        }

        /* Responsive : empile à <576px */
        @media (max-width: 575.98px) {
            .stack-sm {
                flex-direction: column;
                align-items: flex-start !important;
                gap: .5rem;
            }

            .actions {
                width: 100%;
                display: flex;
                gap: .5rem;
                justify-content: flex-start;
            }
        }
    </style>
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Liste des clients</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Clients</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary">Settings</button>
                        <button type="button"
                            class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split"
                            data-bs-toggle="dropdown"> <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end"> <a class="dropdown-item"
                                href="javascript:;">Action</a>
                            <a class="dropdown-item" href="javascript:;">Another action</a>
                            <a class="dropdown-item" href="javascript:;">Something else here</a>
                            <div class="dropdown-divider"></div> <a class="dropdown-item" href="javascript:;">Separated
                                link</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col"></div>
                <div class="col-md-8">
                    <div class="list-group">

                        <!-- Item 2 -->
                        <div class="list-group-item list-item bg-white">
                            <div class="d-flex align-items-center justify-content-between stack-sm gap-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                    <div>
                                        <div class="name text-uppercase">MOULOUNGUI BIENVENUE SAMARA</div>
                                        <div class="role">INFORMATICIEN</div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-2 actions">
                                    <div class="dropdown">
                                        <button class="btn btn-sm dropdown-toggle dropdown-toggle-soft" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Membres associés
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Voir les membres</a></li>
                                            <li><a class="dropdown-item" href="#">Ajouter un membre</a></li>
                                        </ul>
                                    </div>
                                    <span class="badge badge-comptes">2 Comptes</span>
                                    <button class="btn btn-outline-secondary btn-sm" title="Éditer">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm" title="Supprimer">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Item 3 -->
                        <div class="list-group-item list-item bg-white">
                            <div class="d-flex align-items-center justify-content-between stack-sm gap-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                    <div>
                                        <div class="name text-uppercase">NDOULY Bienvenue</div>
                                        <div class="role">Chauffeur</div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-2 actions">
                                    <div class="dropdown">
                                        <button class="btn btn-sm dropdown-toggle dropdown-toggle-soft" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Membres associés
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Voir les membres</a></li>
                                            <li><a class="dropdown-item" href="#">Ajouter un membre</a></li>
                                        </ul>
                                    </div>
                                    <span class="badge badge-comptes">1 Compte</span>
                                    <button class="btn btn-outline-secondary btn-sm" title="Éditer">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm" title="Supprimer">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col"></div>
            </div>

        </div>
    </div>
@endsection
