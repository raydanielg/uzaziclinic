<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - {{ config('app.name') }}</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
    
    <style>
        :root {
            --sidebar-width: 280px;
            --primary-color: #6366f1;
            --bg-light: #f8fafc;
            --sidebar-bg: #ffffff;
            --text-muted: #64748b;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --sidebar-active-bg: #f5f3ff;
            --sidebar-hover-bg: #f8fafc;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-light);
            overflow-x: hidden;
        }

        /* Sidebar Styles - matching original sidebar */
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: #ffffff;
            border-right: 1px solid #e2e8f0;
            z-index: 1000;
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        .sidebar .nav-link {
            color: #475569;
            padding: 0.6rem 1rem;
            border-radius: 8px;
            margin-bottom: 0.25rem;
            transition: all 0.2s;
        }

        .sidebar .nav-link:hover {
            background-color: #f1f5f9;
            color: #1e293b;
        }

        .sidebar .nav-link.active {
            background-color: #dbeafe;
            color: #2563eb;
            font-weight: 600;
        }

        .nav-item-header {
            font-size: 0.65rem;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Main Content Styles */
        #main-content {
            flex-grow: 1;
            margin-left: 260px;
            width: calc(100% - 260px);
            min-height: 100vh;
            transition: all 0.3s;
        }

        .topbar {
            height: var(--topbar-height);
            background: #ffffff;
            padding: 0 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #eef2f7;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .content-body {
            padding: 30px;
        }

        @media (max-width: 991.98px) {
            .sidebar { margin-left: -260px; }
            .sidebar.active { margin-left: 0; }
            #main-content { margin-left: 0; width: 100%; }
        }
    </style>
    @include('partials.dashboard-styles')
</head>
<body>

    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <div id="main-content">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm sticky-top">
            <div class="container-fluid px-4">
                <button class="btn btn-light me-3" id="sidebarToggle">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <span class="navbar-brand d-none d-md-block fw-bold text-primary">@yield('page_title', 'Dashboard')</span>
                
                <div class="ms-auto d-flex align-items-center">
                    <div class="dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle fw-bold" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-circle-user me-1 text-primary"></i> {{ auth()->user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <a class="dropdown-item py-2" href="#"><i class="fa-solid fa-user me-2"></i> Profile</a>
                            <a class="dropdown-item py-2" href="#"><i class="fa-solid fa-key me-2"></i> Password</a>
                            <hr class="dropdown-divider">
                            <a class="dropdown-item py-2 text-danger" href="#"
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <!-- DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('sidebarToggle');
            const close = document.getElementById('sidebarClose');
            const sidebar = document.getElementById('sidebar');
            
            if(toggle && sidebar) {
                toggle.addEventListener('click', (e) => {
                    e.stopPropagation();
                    sidebar.classList.toggle('active');
                });
            }

            if(close && sidebar) {
                close.addEventListener('click', () => {
                    sidebar.classList.remove('active');
                });
            }

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', (e) => {
                if (window.innerWidth < 992 && sidebar && sidebar.classList.contains('active')) {
                    if (!sidebar.contains(e.target) && e.target !== toggle) {
                        sidebar.classList.remove('active');
                    }
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
