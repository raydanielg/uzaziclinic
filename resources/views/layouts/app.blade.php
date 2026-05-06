<!doctype html>
@php
    $isAuthPage = request()->routeIs(
        'login',
        'register',
        'password.request',
        'password.email',
        'password.reset',
        'password.confirm',
        'verification.notice'
    );
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
</head>
<body class="{{ $isAuthPage ? 'auth-body' : 'bg-light' }}">
    <div id="app">
        @unless ($isAuthPage)
            @auth
                @include('partials.sidebar')
                <div class="main-content">
                    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm sticky-top">
                        <div class="container-fluid px-4">
                            <button class="btn btn-light me-3" id="sidebarToggle">
                                <i class="fa-solid fa-bars"></i>
                            </button>
                            <span class="navbar-brand d-none d-md-block fw-bold text-success">AfyaCare Pro</span>
                            
                            <div class="ms-auto d-flex align-items-center">
                                <div class="dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle fw-bold" href="#" role="button" data-bs-toggle="dropdown">
                                        <i class="fa-solid fa-circle-user me-1 text-success"></i> {{ Auth::user()->name }}
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                                        <a class="dropdown-item py-2" href="#"><i class="fa-solid fa-user me-2"></i> Profile</a>
                                        <a class="dropdown-item py-2" href="#"><i class="fa-solid fa-key me-2"></i> Password</a>
                                        <hr class="dropdown-divider">
                                        <a class="dropdown-item py-2 text-danger" href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fa-solid fa-right-from-bracket me-2"></i> {{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </nav>
                    <div class="content-body">
                        @yield('content')
                    </div>
                </div>
            @else
                <main class="py-4">
                    @yield('content')
                </main>
            @endauth
        @else
            <main class="py-0">
                @yield('content')
            </main>
        @endunless
    </div>

    <style>
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            transition: all 0.3s;
        }
        .content-body {
            padding: 20px;
        }
        @media (max-width: 991.98px) {
            .sidebar { margin-left: -260px; }
            .sidebar.active { margin-left: 0; }
            .main-content { margin-left: 0; }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            if(toggle && sidebar) {
                toggle.addEventListener('click', () => {
                    sidebar.classList.toggle('active');
                });
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            @if (session('status'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: "{{ session('status') }}",
                    confirmButtonColor: '#166534',
                });
            @endif

            @if (session('success'))
                Toast.fire({
                    icon: 'success',
                    title: "{{ session('success') }}"
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#166534',
                });
            @endif

            @if ($errors->any())
                @php
                    $errorList = "<ul>";
                    foreach ($errors->all() as $error) {
                        $errorList .= "<li>$error</li>";
                    }
                    $errorList .= "</ul>";
                @endphp
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    html: '{!! $errorList !!}',
                    confirmButtonColor: '#166534',
                });
            @endif
        });
    </script>
</body>
</html>
