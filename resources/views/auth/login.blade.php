<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>YYY Coffee | Login</title>
    <link rel="shortcut icon" type="image/png" href="modernize/assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="modernize/assets/css/styles.min.css" />
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="modernize/assets/images/logos/dark-logo.svg" width="180"
                                        alt="">
                                </a>
                                <p class="text-center">YYY Cofee.</p>
                                @if (session('failed'))
                                    <p class="bg-danger fw-bold text-white p-3 rounded-lg text-center">
                                        {{ session('failed') }}
                                    </p>
                                @endif
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username"
                                            class="form-control @error('username') is-invalid @enderror" name="username"
                                            value="{{ old('username') }}" required autocomplete="username" autofocus>
                                        @error('username')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="password" class="form-label">Password</label>
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="current-password">
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <button class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Sign
                                        In</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <p class="text-center" style="margin-top: 20px;color: #308ee0">Copyright &copy; {{ date('Y') }}
                        YYY Coffee.</p>
                </div>
            </div>
        </div>
    </div>
    <script src="modernize/assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="modernize/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
