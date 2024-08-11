<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>YYY Coffee | @yield('title')</title>
    <link rel="shortcut icon" type="image/png" href="modernize/assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="modernize/assets/css/styles.min.css" />
    <link rel="stylesheet" href="cdn.datatables.net/2.1.3/css/dataTables.dataTables.min.css">
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Menu -->
        @section('sidebar')
            @include('layouts.sidebar', ['user' => Auth::User()])
        @show
        <!-- /.sidebar-menu -->

        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse"
                                href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                            <li class="nav-item dropdown">
                                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="modernize/assets/images/profile/user-1.jpg" alt="" width="35"
                                        height="35" class="rounded-circle">
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                                    aria-labelledby="drop2">
                                    <div class="message-body">
                                        <a href="javascript:void(0)"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-user fs-6"></i>
                                            <p class="mb-0 fs-3">My Profile</p>
                                        </a>
                                        <a class="btn btn-outline-primary mx-3 mt-2 d-block"
                                            href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                          document.getElementById('logout-form').submit();">
                                            Logout</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!--  Header End -->



            <div class="container-fluid">
                <!-- breadcrumb -->
                @yield('breadcrumb')
                <!-- breadcrumb -->
                @yield('content')
            </div>
        </div>
    </div>
    <script src="modernize/assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="modernize/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="modernize/assets/js/sidebarmenu.js"></script>
    <script src="modernize/assets/js/app.min.js"></script>
    <script src="modernize/assets/libs/simplebar/dist/simplebar.js"></script>
    <script src="cdn.datatables.net/2.1.3/js/dataTables.min.js"></script>
    <script>
        let table = new DataTable('#myTable');
    </script>
</body>

</html>
