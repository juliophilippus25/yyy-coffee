<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>YYY Coffee | @yield('title')</title>
    <link rel="shortcut icon" type="image/png" href="modernize/assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="modernize/assets/css/styles.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.bootstrap5.min.css">
</head>

<body class="bg-primary-subtle">
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
                                    @if (Auth::user()->image)
                                        <img alt="Profile" width="35" height="35" class="rounded-circle"
                                            src="{{ asset('storage/images/users/' . Auth::user()->image) }}" />
                                    @elseif(Auth::user()->image == null)
                                        <img alt="Profile" width="35" height="35" class="rounded-circle"
                                            src="modernize/assets/images/profile/user-1.jpg" />
                                    @endif
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                                    aria-labelledby="drop2">
                                    <div class="message-body">
                                        <a href="{{ route('users.profile') }}"
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

            {{-- Content --}}
            <div class="container-fluid">
                @yield('content')
            </div>
            {{-- End Content --}}
        </div>
    </div>

    @include('sweetalert::alert')
    <script src="modernize/assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="modernize/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="modernize/assets/js/sidebarmenu.js"></script>
    <script src="modernize/assets/js/app.min.js"></script>
    <script src="modernize/assets/libs/simplebar/dist/simplebar.js"></script>
    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    </script>
    @yield('script')
</body>

</html>
