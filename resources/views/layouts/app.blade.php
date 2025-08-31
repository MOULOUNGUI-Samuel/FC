<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags  -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>FCI</title>
    <link rel="icon" type="image/png" href="{{ asset('_assets/images/icon1.png') }}">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fira+Sans+Condensed:wght@100;400;500;600&amp;family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,400&amp;display=swap"
        rel="stylesheet">
    <style>
        :root {
            --adminuiux-content-font: 'Roboto';
            --adminuiux-content-font-weight: 400;
            --adminuiux-title-font: "Fira Sans Condensed";
            --adminuiux-title-font-weight: 500;
        }
    </style>

    <script defer src="{{ asset('assets/js/appced1.js?7e4316178ad989670ad8') }}"></script>
    <link href="{{ asset('assets/css/appced1.css?7e4316178ad989670ad8') }}" rel="stylesheet">
    @livewireStyles
</head>

<body
    class="main-bg main-bg-opac main-bg-blur adminuiux-sidebar-fill-white adminuiux-sidebar-boxed theme-blue roundedui"
    data-theme="theme-blue" data-sidebarfill="adminuiux-sidebar-fill-white" data-bs-spy="scroll"
    data-bs-target="#list-example" data-bs-smooth-scroll="true" tabindex="0">
    <!-- Pageloader -->
    <div class="pageloader">
        <div class="container h-100">
            <div class="row justify-content-center align-items-center text-center h-100">
                <div class="col-12 mb-auto pt-4"></div>
                <div class="col-auto">
                    <img src="{{ asset('_assets/images/icon2.png') }}" alt="" class="height-60 mb-3">
                    <div class="loader10 mb-2 mx-auto"></div>
                </div>
                <div class="col-12 mt-auto pb-4">
                    <p class="text-secondary">Chargement...</p>
                </div>
            </div>
        </div>
    </div>
    <!-- standard header -->
    <header class="adminuiux-header">
        <!-- Fixed navbar -->
        <nav class="navbar navbar-expand-lg fixed-top">
            <div class="container-fluid">

                <!-- main sidebar toggle -->
                <button class="btn btn-link btn-square sidebar-toggler" type="button" onclick="initSidebar()">
                    <i class="sidebar-svg" data-feather="menu"></i>
                </button>

                <!-- logo -->
                <a class="navbar-brand" href="investment-dashboard.html">
                    <img data-bs-img="light" src="{{ asset('_assets/images/icon2.png') }}" alt="">
                    <img data-bs-img="dark" src="{{ asset('_assets/images/icon2.png') }}" alt="">
                </a>

                <!-- right icons button -->
                <div class="ms-auto">
                    <!-- dark mode -->
                    <button class="btn btn-link btn-square btnsunmoon btn-link-header" id="btn-layout-modes-dark-page">
                        <i class="sun mx-auto" data-feather="sun"></i>
                        <i class="moon mx-auto" data-feather="moon"></i>
                    </button>

                    <!-- profile dropdown -->
                    <div class="dropdown d-inline-block">
                        <a class="dropdown-toggle btn btn-link btn-square btn-link-header style-none no-caret px-0"
                            id="userprofiledd" data-bs-toggle="dropdown" aria-expanded="false" role="button">
                            <div class="row gx-0 d-inline-flex">
                                <div class="col-auto align-self-center">
                                    <figure class="avatar avatar-28 rounded-circle coverimg align-middle">
                                        <img src="assets/img/modern-ai-image/user-6.jpg" alt=""
                                            id="userphotoonboarding2">
                                    </figure>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end width-300 pt-0 px-0"
                            aria-labelledby="userprofiledd">
                            <div class="bg-theme-1-space rounded py-3 mb-3 dropdown-dontclose">
                                <div class="row gx-0">
                                    <div class="col-auto px-3">
                                        <figure class="avatar avatar-50 rounded-circle coverimg align-middle">
                                            <img src="assets/img/modern-ai-image/user-6.jpg" alt="">
                                        </figure>
                                    </div>
                                    <div class="col align-self-center ">
                                        <p class="mb-1"><span>AdminUIUX</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="px-2">
                                <div>
                                    <a class="dropdown-item theme-red" href="investment-login.html">
                                        <i data-feather="power" class="avatar avatar-18 me-1"></i> Logout
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </nav>

    </header>

    <div class="adminuiux-wrap">
        <!-- Standard sidebar -->
        <div class="adminuiux-sidebar">
            <div class="adminuiux-sidebar-inner">
                <!-- Profile -->
                <div class="px-3 not-iconic mt-2">
                    <div class="row gx-3">
                        <div class="col align-self-center ">
                            <h6 class="fw-medium">Menu principal</h6>
                        </div>
                        <div class="col-auto">
                            <a class="btn btn-link btn-square" data-bs-toggle="collapse"
                                data-bs-target="#usersidebarprofile" aria-expanded="false" role="button"
                                aria-controls="usersidebarprofile">
                                <i data-feather="user"></i>
                            </a>
                        </div>
                    </div>
                    <div class="text-center collapse " id="usersidebarprofile">
                        <figure class="avatar avatar-100 rounded-circle coverimg my-3">
                            <img src="assets/img/modern-ai-image/user-6.jpg" alt="">
                        </figure>
                        <h5 class="mb-1 fw-medium">AdminUIUX</h5>
                    </div>
                </div>

                <ul class="nav flex-column menu-active-line">
                    <!-- investment sidebar -->
                    <li class="nav-item mb-3">
                        <a href="{{ 'dashboard' }}"
                            class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="menu-icon" data-feather="home"></i>
                            <span class="menu-name">Tableau de bord</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="javascrit:void(0)" class="nav-link dropdown-toggle  {{ request()->routeIs('liste.associer', 'liste.particulier') ? 'active' : '' }}" data-bs-toggle="dropdown">
                            <i class="menu-icon" data-feather="users"></i>
                            <span class="menu-name">Clients</span>
                        </a>
                        <div class="dropdown-menu">
                            <div class="nav-item">
                                <a href="{{ route('liste.particulier') }}" class="nav-link mb-3 {{ request()->routeIs('liste.particulier') ? 'active' : '' }}">
                                    <i class="menu-icon" data-feather="user"></i>
                                    <span class="menu-name">Particulier</span>
                                </a>
                            </div>
                            <div class="nav-item">
                                <a href="{{ route('liste.associer') }}" class="nav-link mb-3 {{ request()->routeIs( 'liste.associer') ? 'active' : '' }}">
                                    <i class="menu-icon" data-feather="user"></i>
                                    <span class="menu-name">Fonds / Entitees</span>
                                </a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a href="#"
                            class="nav-link">
                            <i class="menu-icon" data-feather="dollar-sign"></i>
                            <span class="menu-name">Tresorerie</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#"
                            class="nav-link">
                            <i class="menu-icon" data-feather="bar-chart-2"></i>
                            <span class="menu-name">Synthese</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#"
                            class="nav-link">
                            <i class="menu-icon" data-feather="users"></i>
                            <span class="menu-name">Utilisateurs</span>
                        </a>
                    </li>
                </ul>
                <div class=" mt-auto "></div>
                <!-- User account -->
                <ul class="nav flex-column menu-active-line">
                    <li class="nav-item">
                        <a href="investment-settings.html" class="nav-link">
                            <i class="menu-icon" data-feather="settings"></i>
                            <span class="menu-name">
                                Paramètres
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        {{-- Container toast Bootstrap (une seule fois dans la page/layout) --}}
        <div class="position-fixed top-0 end-0 p-3" style="z-index:1080" wire:ignore>
            <div id="liveToast" class="toast align-items-center text-bg-success border-0" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body" id="liveToastBody">Action réussie.</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
        @yield('content')
    </div>
    @livewireScripts
    <script src="{{ asset('assets/js/investment/investment-auth.js') }}"></script>
    <!-- Page Level js -->
    <script src="{{ asset('assets/js/investment/investment-dashboard.js') }}"></script>
</body>

</html>
