@extends('layouts.app')

@section('title', 'Mon Tableau de bord')

@section('content')
<main class="adminuiux-content has-sidebar" onclick="contentClick()">

            <!-- Content  -->
            <div class="container mt-3" id="main-content">

                <div class="row gx-3">
                    <!-- Summary chart -->
                    <div class="col-12 col-lg-6 col-xl-8 mb-3">
                        <div class="card adminuiux-card">
                            <div class="card-header pb-0">
                                <div class="row align-items-center">
                                    <div class="col mb-3">
                                        <h6>Summary</h6>
                                    </div>
                                    <div class="col-auto mb-3">
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination pagination-sm justify-content-end mb-0">
                                                <li class="page-item"><a class="page-link" href="#">1D</a></li>
                                                <li class="page-item"><a class="page-link" href="#">1M</a></li>
                                                <li class="page-item"><a class="page-link" href="#">1Y</a></li>
                                                <li class="page-item"><a class="page-link" href="#">All</a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                    <div class="col-12 col-md-auto position-relative text-sm-end mb-3">
                                        <input type="text"
                                            class="form-control form-control-sm d-inline-block w-auto align-middle"
                                            id="daterangepicker">
                                        <button class="btn btn-sm btn-square btn-link d-inline-block align-middle"
                                            onclick="$(this).prev().click()">
                                            <i data-feather="calendar" class="text-theme-1"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row gx-0">
                                <!-- summary account -->
                                <div class="col-12 col-xl-4 order-2 order-xl-1">
                                    <div class="card-body pb-0">
                                        <div class="card adminuiux-card bg-theme-1 mb-3">
                                            <div class="card-body">
                                                <p class="text-white small mb-2">Current Value</p>
                                                <h5 class="fw-medium">$ 65.52k <span class="text-white fs-14"><i
                                                            class="bi bi-arrow-up-short me-1"></i> 18.5%</span></h5>
                                            </div>
                                        </div>
                                        <div class="card adminuiux-card bg-theme-1-subtle mb-3">
                                            <div class="card-body">
                                                <p class="text-secondary small mb-2">Profit Revenue</p>
                                                <h5 class="fw-medium">$ 15.51k <span class="text-success fs-14"><i
                                                            class="bi bi-arrow-up-short me-1"></i> 11.5%</span></h5>
                                            </div>
                                        </div>
                                        <div class="card adminuiux-card bg-theme-1-subtle mb-3">
                                            <div class="card-body">
                                                <p class="text-secondary small mb-2">Investment</p>
                                                <h5 class="fw-medium">$ 45.00k</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- chart section -->
                                <div class="col-12 col-xl-8 order-1 order-xl-2">
                                    <div class="card-body">
                                        <div class="w-100 height-200">
                                            <canvas id="summarychart"></canvas>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xxl-4 mb-3">
                        <div class="card adminuiux-card bg-theme-1">
                            <div class="card-body">
                                <h4 class="mb-3 fw-medium">Adminuiux Innovation and tech Fund</h4>
                                <h5 class="h4 mb-1">$ 15.52</h5>
                                <p class="opacity-75 mb-3">Current Nav (Today)</p>
                                <div class="row gx-3">
                                    <div class="col-6 mb-3">
                                        <h5 class="mb-1">21</h5>
                                        <p class="small opacity-75"><i class="bi bi-speedometer2 me-1"></i> Risk</p>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <h5 class="mb-1">15.25%</h5>
                                        <p class="small opacity-75"><i class="bi bi-bar-chart-line me-1"></i> CAGR</p>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <h5 class="mb-1">0.5%</h5>
                                        <p class="small opacity-75"><i class="bi bi-exclamation-triangle me-1"></i>
                                            Exit Load</p>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <h5 class="mb-1">0.25%</h5>
                                        <p class="small opacity-75"><i class="bi bi-cash-stack me-1"></i> Expense
                                            Ratio</p>
                                    </div>
                                </div>
                                <div class="row gx-3">
                                    <div class="col">
                                        <button class="btn btn-sm btn-light me-2">Buy</button>
                                        <button class="btn btn-sm btn-light me-2">SIP</button>
                                    </div>
                                    <div class="col-auto">
                                        <button class="btn btn-sm btn-link text-white me-2">Details</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- investment category chart -->
                    <div class="col-12 col-lg-12 col-xl-8 mb-3">
                        <div class="card adminuiux-card">
                            <div class="row gx-3 align-items-center">
                                <div class="col-12 col-md-6 col-lg-5 col-xl-5">
                                    <div class="card-header">
                                        <h6 class="my-1">Investment Categories</h6>
                                    </div>
                                    <div class="card-body">
                                        <div
                                            class="position-relative d-flex align-items-center justify-content-center text-center mb-3">
                                            <div class="position-absolute">
                                                <h4 class="mb-0">$ 1165.30k</h4>
                                                <p class="text-secondary small">Portfolio Value</p>
                                            </div>
                                            <canvas id="doughnutchart" class="mx-auto width-230 height-230"></canvas>
                                        </div>
                                        <p class="text-secondary small">You have invested in different types of
                                            categories shown as above and summary of each category.</p>
                                    </div>
                                </div>
                                <div class="col-12 col-sm">
                                    <div class="card-body">
                                        <div class="row gx-3 mb-2">
                                            <div class="col-6 col-md-6 mb-3">
                                                <p class="text-secondary small mb-2">
                                                    <span class="me-1 avatar avatar-10 rounded bg-green"></span>
                                                    Share holdings
                                                </p>
                                                <h5 class="ps-3 fw-medium">$ 165.52k<br> <span
                                                        class="text-success fs-14 fw-normal"><i
                                                            class="bi bi-caret-up-fill me-1 fs-14"></i> 25.30%</span>
                                                </h5>
                                            </div>
                                            <div class="col-6 col-md-6 mb-3">
                                                <p class="text-secondary small mb-2">
                                                    <span class="me-1 avatar avatar-10 rounded bg-yellow"></span>
                                                    Mutual Funds
                                                </p>
                                                <h5 class="ps-3 fw-medium">$ 265.85k<br> <span
                                                        class="text-success fs-14 fw-normal"><i
                                                            class="bi bi-caret-up-fill me-1"></i> 21.42%</span></h5>
                                            </div>
                                            <div class="col-6 col-md-6 mb-3">
                                                <p class="text-secondary small mb-2">
                                                    <span class="me-1 avatar avatar-10 rounded bg-orange"></span>
                                                    Bank Bonds
                                                </p>
                                                <h5 class="ps-3 fw-medium">$ 356.26k<br> <span
                                                        class="text-success fs-14 fw-normal"><i
                                                            class="bi bi-caret-up-fill me-1"></i> 20.18%</span></h5>
                                            </div>
                                            <div class="col-6 col-md-6 mb-3">
                                                <p class="text-secondary small mb-2">
                                                    <span class="me-1 avatar avatar-10 rounded bg-purple"></span>
                                                    Gov. Securities
                                                </p>
                                                <h5 class="ps-3 fw-medium">$ 185.65<br> <span
                                                        class="text-success fs-14 fw-normal"><i
                                                            class="bi bi-caret-up-fill me-1"></i> 15.65%</span></h5>
                                            </div>
                                            <div class="col-6 col-md-6">
                                                <p class="text-secondary small mb-2">
                                                    <span class="me-1 avatar avatar-10 rounded bg-secondary"></span>
                                                    Fixed Deposit
                                                </p>
                                                <h5 class="ps-3 fw-medium">$ 190.45k<br> <span
                                                        class="text-success fs-14 fw-normal"><i
                                                            class="bi bi-caret-up-fill me-1"></i> 18.50%</span></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- wallet balance -->
                    <div class="col-12 col-md-12 col-xl-4 mb-3">
                        <div class="card adminuiux-card overflow-hidden">
                            <div class="card-header">
                                <div class="row gx-3 align-items-center">
                                    <div class="col-auto">
                                        <span class="avatar avatar-30 rounded-circle bg-theme-1-subtle text-theme-1"><i
                                                class="bi bi-wallet"></i></span>
                                    </div>
                                    <div class="col px-0">
                                        <h6>My Wallet</h6>
                                    </div>
                                    <div class="col-auto px-0">
                                        <select class="form-select form-select-sm">
                                            <option>USD</option>
                                            <option>CAD</option>
                                            <option>AUD</option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <button class="btn btn-sm btn-square btn-link"><i
                                                class="bi bi-arrow-clockwise"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h4 class="fw-medium">$ 1152.25k </h4>
                                <p class="text-secondary small">Total net revenue is $ 756.83 <span
                                        class="text-success fs-14"><i class="bi bi-arrow-up-short"></i> 11.5%</span>
                                    increased in last week</p>

                                <!-- chart blue -->
                                <div class="summarychart height-110 w-100 mb-3">
                                    <canvas id="areachartblue1"></canvas>
                                </div>
                                <div class="card adminuiux-card bg-theme-1-subtle">
                                    <div class="card-body">
                                        <p class="text-secondary small mb-2">Top performing investment is <b
                                                class="text-theme-1">Share Holdings</b></p>
                                        <h5 class="fw-medium">$ 165.52k <span class="text-success fs-14 fw-normal"><i
                                                    class="bi bi-caret-up-fill me-1 fs-14"></i> 25.30%</span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
@endsection
