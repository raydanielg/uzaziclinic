<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - {{ config('app.name') }}</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --sidebar-width: 260px;
            --primary-color: #6366f1;
            --bg-light: #f8fafc;
            --sidebar-bg: #ffffff;
            --text-muted: #64748b;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        #sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: var(--sidebar-bg);
            border-right: 1px solid #e2e8f0;
            z-index: 1000;
            transition: all 0.3s;
        }

        .sidebar-brand {
            padding: 1.5rem;
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--primary-color);
            border-bottom: 1px solid #f1f5f9;
        }

        .sidebar-brand span {
            color: #ef4444;
            font-size: 0.75rem;
            display: block;
            text-transform: uppercase;
        }

        .nav-section-title {
            padding: 1.5rem 1.5rem 0.5rem;
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .sidebar-nav .nav-link {
            padding: 0.75rem 1.5rem;
            color: #475569;
            font-weight: 500;
            display: flex;
            align-items: center;
            transition: all 0.2s;
        }

        .sidebar-nav .nav-link i {
            margin-right: 0.75rem;
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        .sidebar-nav .nav-link:hover, .sidebar-nav .nav-link.active {
            color: var(--primary-color);
            background-color: #f5f3ff;
        }

        /* Main Content */
        #main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s;
        }

        /* Topbar */
        .topbar {
            height: 70px;
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .content-body {
            padding: 2rem;
        }

        /* Dashboard Cards */
        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            border: none;
            display: flex;
            align-items: center;
            height: 100%;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            font-size: 1.25rem;
        }

        .stat-title {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin-bottom: 0.25rem;
        }

        .stat-value {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
        }

        /* Colors */
        .bg-indigo-light { background-color: #e0e7ff; color: #4338ca; }
        .bg-green-light { background-color: #dcfce7; color: #15803d; }
        .bg-orange-light { background-color: #ffedd5; color: #c2410c; }
        .bg-purple-light { background-color: #f3e8ff; color: #7e22ce; }
        .bg-blue-light { background-color: #dbeafe; color: #1d4ed8; }

        /* Logout button */
        .logout-btn {
            position: absolute;
            bottom: 20px;
            left: 0;
            width: 100%;
            padding: 0 1.5rem;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div id="sidebar">
        <div class="sidebar-brand">
            Malkia
            <span>Admin Panel</span>
        </div>
        
        <div class="sidebar-nav">
            <div class="nav-section-title">Main</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-link active">
                <i class="fa-solid fa-gauge-high"></i> Dashboard
            </a>

            <div class="nav-section-title">Accounting</div>
            <a href="#" class="nav-link"><i class="fa-solid fa-file-invoice"></i> Vouchers</a>
            <a href="#" class="nav-link"><i class="fa-solid fa-book"></i> Accounts</a>
            <a href="#" class="nav-link"><i class="fa-solid fa-building-columns"></i> Banks</a>

            <div class="nav-section-title">Mothers & Content</div>
            <a href="#" class="nav-link"><i class="fa-solid fa-users-line"></i> Mothers Intake</a>
            <a href="#" class="nav-link"><i class="fa-solid fa-newspaper"></i> Articles</a>

            <div class="nav-section-title">ERP System</div>
            <a href="#" class="nav-link"><i class="fa-solid fa-graduation-cap"></i> ELMS Courses</a>
            <a href="#" class="nav-link"><i class="fa-solid fa-boxes-stacked"></i> Inventory</a>
        </div>

        <div class="logout-btn">
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-outline-danger w-100 text-start">
                <i class="fa-solid fa-right-from-bracket me-2"></i> Sign Out
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div id="main-content">
        <div class="topbar">
            <h5 class="mb-0 fw-bold">Dashboard</h5>
            <div class="d-flex align-items-center">
                <button class="btn btn-light position-relative me-3 rounded-circle">
                    <i class="fa-regular fa-bell"></i>
                </button>
                <div class="d-flex align-items-center bg-light px-3 py-1 rounded-pill">
                    <div class="avatar me-2 bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 32px; height: 32px;">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div>
                        <div class="small fw-bold">{{ auth()->user()->name }}</div>
                        <div class="text-muted" style="font-size: 0.65rem;">Administrator</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-body">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
