<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.98.0">
    <title>Dashboard Template · Bootstrap v5.2</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/dashboard/">
    <link href="{{ asset('assets/dist/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/global.css') }}" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="{{ asset('assets/dashboard/dashboard.css') }}" rel="stylesheet">

    <!-- ESTILOS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/parsley/parsley.css') }}">
    <link rel="stylesheet"src="{{ asset('assets/bootstrap-table/bootstrap-table.css') }}">

    <!-- noty -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/noty/themes/sunset.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/noty/noty.css') }}">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.css" integrity="sha512-NXUhxhkDgZYOMjaIgd89zF2w51Mub53Ru3zCNp5LTlEzMbNNAjTjDbpURYGS5Mop2cU4b7re1nOIucsVlrx9fA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    

    <!-- BOOTSTRAP TABLE -->
    <script type="text/javascript" src="{{ asset('assets/bootstrap-table/bootstrap-table.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/bootstrap-table/extensions/export/bootstrap-table-export.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/bootstrap-table/locale/bootstrap-table-es-MX.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/bootstrap-table/extensions/filter-control/bootstrap-table-filter-control.js') }}"></script>
    <script src="{{ asset('assets/tableExport/tableExport.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap-table/extensions/cookie/bootstrap-table-cookie.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/parsley/parsley.js') }}"></script>

    <script defer type="text/javascript" src="{{ asset('assets/sweetalert/sweetalert-2.1.0.js') }}"></script>


    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">Reporte de robo vehícular</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="#">Sign out</a>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">
                                <span data-feather="home" class="align-text-bottom"></span>
                                Buscar reporte
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file" class="align-text-bottom"></span>
                                Reporte de robo
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/vehiculos') }}">
                                <span data-feather="shopping-cart" class="align-text-bottom"></span>
                                Vehiculos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/propietarios') }}">
                                <span data-feather="users" class="align-text-bottom"></span>
                                Propietarios
                            </a>
                        </li>
                    </ul>

                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
                        <span>Catalogos</span>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/marcas') }}">
                                <span data-feather="file-text" class="align-text-bottom"></span>
                                Marcas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/colores') }}">
                                <span data-feather="file-text" class="align-text-bottom"></span>
                                Colores
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">@yield('title')</h1>
                </div>

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        var baseUrl = "{{ env('APP_URL') }}";
    </script>

    <script src="{{ asset('assets/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/dashboard/dashboard.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js" integrity="sha512-lOrm9FgT1LKOJRUXF3tp6QaMorJftUjowOWiDcG5GFZ/q7ukof19V0HKx/GWzXCdt9zYju3/KhBNdCLzK8b90Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    
</body>

</html>