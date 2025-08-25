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
</head>
<script defer src="{{ 'assets/js/appced1.js?7e4316178ad989670ad8' }}"></script>
<link href="{{ 'assets/css/appced1.css?7e4316178ad989670ad8' }}" rel="stylesheet">
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

    <main class="flex-shrink-0 pt-0 h-100">
        <div class="container-fluid">
            <div class="auth-wrapper">

                <!-- login wrap -->
                <div class="row gx-3">
                    <div class="col-12 col-md-6 col-xl-8 p-4 d-none d-md-block">
                        <div class="card adminuiux-card bg-theme-1-space position-relative overflow-hidden h-100">
                            <div class="position-absolute start-0 top-0 h-100 w-100 coverimg  z-index-0">
                                <img src="{{ asset('_assets/images/6196859.jpg') }}" alt="">
                            </div>
                            {{-- <div class="card-body position-relative z-index-1">
                                <div
                                    class="row h-100 d-flex flex-column justify-content-center align-items-center gx-0 text-center">
                                    <div class="col-10 col-md-11 col-xl-8 mb-4 mx-auto">
                                        <div class="swiper swipernavpagination pb-5">
                                            <div class="swiper-wrapper">
                                                <div class="swiper-slide">
                                                    <h3 class="text-white mb-3">Le logiciel FCI est une solution
                                                        intégrée conçue pour répondre aux besoins opérationnels et
                                                        stratégiques
                                                        d’un établissement de microfinance moderne</h3>
                                                    <p class="lead opacity-75">Simplicité d’utilisation, sécurité
                                                        renforcée et
                                                        puissance fonctionnelle</p>
                                                </div>
                                            </div>
                                            <div class="swiper-pagination white bottom-0"></div>
                                        </div>

                                    </div>

                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-xl-4 minvheight-100 d-flex flex-column px-0">
                        <!-- standard header -->
                        <header class="adminuiux-header">
                            <!-- Fixed navbar -->
                            <nav class="navbar">
                                {{-- <div class="container-fluid">
                                    <!-- logo -->
                                    <a class="navbar-brand" href="{{route('login')}}">
                                        <img data-bs-img="light" src="{{ asset('_assets/images/icon2.png') }}" alt="">
                                        
                                    </a>

                                    <div class=" ms-auto "></div>
                                    <!-- right icons button -->
                                    <div class="ms-auto">
                                    </div>
                                </div> --}}
                            </nav>
                        </header>
                        <div class="h-100 px-2 py-3">

                            <div class="row gx-3 h-100 align-items-center justify-content-center mt-md-3">
                                
                                <div class="col-12 col-sm-8 col-md-11 col-xl-11 col-xxl-10 login-box">
                                    <form method="POST" {{ route('login') }} class="row g-3 app-form needs-validation"
                                        novalidate onsubmit="return validateForm(event)">
                                        @csrf
                                        <div class="text-center mb-5">
                                            <img data-bs-img="light" src="{{ asset('_assets/images/icon2.png') }}"
                                                alt="" class="w-50">
                                        </div>
                                        <div class="text-center mb-3">
                                            <h1 class="mb-2">Bienvenue&#9996;</h1>
                                            <p class="text-secondary">Entrez vos identifiants pour vous connecter</p>
                                        </div>
                                    @if ($errors->any())
                                        <div class="alert alert-danger" role="alert">
                                            <p class="mb-0 text-danger">
                                                <i class="ti ti-alert-circle f-s-18 me-2"></i>
                                                {{ $errors->first() }}
                                            </p>
                                            <i class="ti ti-x" data-bs-dismiss="alert"></i>
                                        </div>
                                    @endif
                                    @if (session('success'))
                                        <div class="alert alert-success" role="alert">
                                            <p class="mb-0 text-success">
                                                <i class="ti ti-circle-check f-s-18 me-2"></i>
                                                {{ session('success') }}
                                            </p>
                                            <i class="ti ti-x" data-bs-dismiss="alert"></i>
                                        </div>
                                    @endif
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="emailadd"
                                                placeholder="Votre indentifiant" autofocus="" name="email">
                                            <label for="emailadd" style="margin-left: 10px">Identifiant</label>
                                        </div>

                                        <div class="position-relative" id="show_hide_password">
                                            <div class="form-floating mb-3">
                                                <input type="password" class="form-control" id="passwd"
                                                    placeholder="Votre mot de passe" name="password">
                                                <label for="passwd">Mot de passe</label>
                                            </div>
                                            <a href="javascript:;"
                                                class="btn btn-square btn-link text-theme-1 position-absolute end-0 top-0 mt-2 me-2 ">
                                                <i class="bx bx-hide fs-22"></i>
                                            </a>
                                        </div>

                                        <div class="row gx-3 align-items-center mb-3">
                                            <div class="col">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rememberme"
                                                        id="rememberme">
                                                    <label class="form-check-label" for="rememberme">Souviens-toi de
                                                        moi</label>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <a href="investment-forgot-password.html" class=" ">Mot de passe
                                                    oublié ?</a>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-lg btn-theme w-100 mb-3" id="submitBtn"
                                            onclick="handleSubmit(event)">Se
                                            connecter</button>
                                        <button type="submit" class="btn btn-lg btn-theme w-100 mb-3 d-none" disabled
                                            id="btnLoading">
                                            <span class="spinner-border spinner-border-sm me-2" role="status"
                                                aria-hidden="true"></span>
                                            Connexion...</button>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </main>
    <!-- Page Level js -->
    <script src="{{ asset('assets/js/investment/investment-auth.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bx-hide");
                    $('#show_hide_password i').removeClass("bx-show");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bx-hide");
                    $('#show_hide_password i').addClass("bx-show");
                }
            });
        });
    </script>
    <script>
        function handleSubmit(event) {
            event.preventDefault();

            const form = event.target.closest('form');
            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                return false;
            }

            const btnSubmit = document.getElementById('submitBtn');
            const btnLoading = document.getElementById('btnLoading');

            // Masquer le bouton principal, afficher le bouton loading
            btnSubmit.classList.add('d-none');
            btnLoading.classList.remove('d-none');

            // Soumettre après une courte pause
            setTimeout(() => {
                form.submit();
            }, 500);

            return true;
        }
    </script>
</body>
</html>
