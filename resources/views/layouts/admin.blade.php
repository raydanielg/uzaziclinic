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
    <!-- Animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
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
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand {
            padding: 1.5rem;
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--primary-color);
            border-bottom: 1px solid #f1f5f9;
            flex-shrink: 0;
        }

        .sidebar-brand span {
            color: #ef4444;
            font-size: 0.75rem;
            display: block;
            text-transform: uppercase;
        }

        .sidebar-content {
            flex-grow: 1;
            overflow-y: auto;
            padding-bottom: 80px;
        }

        .sidebar-content::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar-content::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }

        .nav-section-title {
            padding: 1.25rem 1.5rem 0.5rem;
            font-size: 0.65rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .sidebar-nav .nav-link {
            padding: 0.65rem 1.5rem;
            color: #475569;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.2s;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .nav-link-content {
            display: flex;
            align-items: center;
        }

        .sidebar-nav .nav-link i.menu-icon {
            margin-right: 0.75rem;
            width: 20px;
            text-align: center;
            font-size: 1rem;
            color: #64748b;
        }

        .sidebar-nav .nav-link:hover {
            background-color: var(--sidebar-hover-bg);
            color: var(--primary-color);
        }

        .sidebar-nav .nav-link.active {
            color: var(--primary-color);
            background-color: var(--sidebar-active-bg);
            border-right: 3px solid var(--primary-color);
        }

        .dropdown-toggle-icon {
            font-size: 0.7rem;
            transition: transform 0.3s;
        }

        .nav-item.show .dropdown-toggle-icon {
            transform: rotate(180deg);
        }

        .sidebar-dropdown {
            background-color: #fafafa;
            display: none;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .nav-item.show .sidebar-dropdown {
            display: block;
        }

        .sidebar-dropdown .nav-link {
            padding-left: 3.25rem;
            font-size: 0.85rem;
            font-weight: 400;
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

        /* Logout button */
        .logout-container {
            padding: 1rem 1.5rem;
            background: #fff;
            border-top: 1px solid #f1f5f9;
            position: absolute;
            bottom: 0;
            width: 100%;
            z-index: 1001;
        }

        /* Dashboard Cards */
        .stat-card {
            background: #ffffff !important;
            border-radius: 12px;
            padding: 1.25rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            height: 100%;
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.75rem;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .stat-title {
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--text-muted);
            margin-bottom: 0.15rem;
            line-height: 1.2;
        }

        .stat-value {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1e293b;
        }

        /* Colors */
        .bg-indigo-light { background-color: #e0e7ff !important; color: #4338ca !important; }
        .bg-green-light { background-color: #dcfce7 !important; color: #15803d !important; }
        .bg-orange-light { background-color: #ffedd5 !important; color: #c2410c !important; }
        .bg-purple-light { background-color: #f3e8ff !important; color: #7e22ce !important; }
        .bg-blue-light { background-color: #dbeafe !important; color: #1d4ed8 !important; }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div id="sidebar" class="animate__animated animate__slideInLeft">
        <div class="sidebar-brand">
            Admin Panel
        </div>
        
        <div class="sidebar-content">
            <div class="sidebar-nav">
                <!-- Dashboard -->
                <div class="nav-item {{ request()->routeIs('admin.dashboard') ? 'show' : '' }}">
                    <a href="javascript:void(0)" class="nav-link dropdown-btn {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <span class="nav-link-content">
                            <i class="fa-solid fa-gauge-high menu-icon"></i> Dashboard
                        </span>
                        <i class="fa-solid fa-chevron-down dropdown-toggle-icon"></i>
                    </a>
                    <ul class="sidebar-dropdown">
                        <li><a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Main Dashboard</a></li>
                        <li><a href="{{ route('admin.analytics') }}" class="nav-link {{ request()->routeIs('admin.analytics') ? 'active' : '' }}">Analytics Dashboard</a></li>
                    </ul>
                </div>

                <!-- User Management -->
                <div class="nav-section-title">Administration</div>
                <div class="nav-item">
                    <a href="javascript:void(0)" class="nav-link dropdown-btn">
                        <span class="nav-link-content">
                            <i class="fa-solid fa-users-gear menu-icon"></i> User Management
                        </span>
                        <i class="fa-solid fa-chevron-down dropdown-toggle-icon"></i>
                    </a>
                    <ul class="sidebar-dropdown">
                        <li><a href="{{ route('admin.users.index') }}" class="nav-link">All Users</a></li>
                        <li><a href="{{ route('admin.users.create') }}" class="nav-link">Add New User</a></li>
                        <li><a href="{{ route('admin.users.roles') }}" class="nav-link">Roles & Permissions</a></li>
                        <li><a href="{{ route('admin.users.logs') }}" class="nav-link">Activity Logs</a></li>
                    </ul>
                </div>

                <!-- Patient Management -->
                <div class="nav-section-title">Medical Services</div>
                <div class="nav-item">
                    <a href="javascript:void(0)" class="nav-link dropdown-btn">
                        <span class="nav-link-content">
                            <i class="fa-solid fa-user-nurse menu-icon"></i> Patient Management
                        </span>
                        <i class="fa-solid fa-chevron-down dropdown-toggle-icon"></i>
                    </a>
                    <ul class="sidebar-dropdown">
                        <li><a href="{{ route('admin.patients.index') }}" class="nav-link">All Patients</a></li>
                        <li><a href="{{ route('admin.patients.create') }}" class="nav-link">Add New Patient</a></li>
                        <li><a href="{{ route('admin.patients.categories') }}" class="nav-link">Patient Categories</a></li>
                        <li><a href="{{ route('admin.patients.history') }}" class="nav-link">Medical History Archive</a></li>
                    </ul>
                </div>

                <!-- Doctor Management -->
                <div class="nav-item">
                    <a href="javascript:void(0)" class="nav-link dropdown-btn">
                        <span class="nav-link-content">
                            <i class="fa-solid fa-user-doctor menu-icon"></i> Doctor Management
                        </span>
                        <i class="fa-solid fa-chevron-down dropdown-toggle-icon"></i>
                    </a>
                    <ul class="sidebar-dropdown">
                        <li><a href="{{ route('admin.doctors.index') }}" class="nav-link">All Doctors</a></li>
                        <li><a href="{{ route('admin.doctors.create') }}" class="nav-link">Add New Doctor</a></li>
                        <li><a href="{{ route('admin.doctors.schedules') }}" class="nav-link">Doctor Schedules</a></li>
                        <li><a href="{{ route('admin.doctors.specializations') }}" class="nav-link">Doctor Specializations</a></li>
                    </ul>
                </div>

                <!-- Appointment Management -->
                <div class="nav-item">
                    <a href="javascript:void(0)" class="nav-link dropdown-btn">
                        <span class="nav-link-content">
                            <i class="fa-solid fa-calendar-check menu-icon"></i> Appointments
                        </span>
                        <i class="fa-solid fa-chevron-down dropdown-toggle-icon"></i>
                    </a>
                    <ul class="sidebar-dropdown">
                        <li><a href="{{ route('admin.appointments.index') }}" class="nav-link">All Appointments</a></li>
                        <li><a href="{{ route('admin.appointments.today') }}" class="nav-link">Today's Appointments</a></li>
                        <li><a href="{{ route('admin.appointments.upcoming') }}" class="nav-link">Upcoming Appointments</a></li>
                        <li><a href="{{ route('admin.appointments.cancelled') }}" class="nav-link">Cancelled Appointments</a></li>
                    </ul>
                </div>

                <!-- Pharmacy & Inventory -->
                <div class="nav-section-title">Operations</div>
                <div class="nav-item">
                    <a href="javascript:void(0)" class="nav-link dropdown-btn">
                        <span class="nav-link-content">
                            <i class="fa-solid fa-pills menu-icon"></i> Pharmacy & Inventory
                        </span>
                        <i class="fa-solid fa-chevron-down dropdown-toggle-icon"></i>
                    </a>
                    <ul class="sidebar-dropdown">
                        <li><a href="{{ route('admin.pharmacy.stock') }}" class="nav-link">Medicines Stock</a></li>
                        <li><a href="{{ route('admin.pharmacy.create') }}" class="nav-link">Add New Medicine</a></li>
                        <li><a href="{{ route('admin.pharmacy.alerts') }}" class="nav-link">Stock Alerts</a></li>
                        <li><a href="{{ route('admin.pharmacy.suppliers') }}" class="nav-link">Suppliers List</a></li>
                        <li><a href="{{ route('admin.pharmacy.orders') }}" class="nav-link">Purchase Orders</a></li>
                        <li><a href="{{ route('admin.pharmacy.expiry') }}" class="nav-link">Expiry Tracking</a></li>
                    </ul>
                </div>

                <!-- Lab Management -->
                <div class="nav-item">
                    <a href="javascript:void(0)" class="nav-link dropdown-btn">
                        <span class="nav-link-content">
                            <i class="fa-solid fa-microscope menu-icon"></i> Lab Management
                        </span>
                        <i class="fa-solid fa-chevron-down dropdown-toggle-icon"></i>
                    </a>
                    <ul class="sidebar-dropdown">
                        <li><a href="{{ route('admin.lab.catalog') }}" class="nav-link">Lab Tests Catalog</a></li>
                        <li><a href="{{ route('admin.lab.results') }}" class="nav-link">Test Results</a></li>
                        <li><a href="{{ route('admin.lab.equipment') }}" class="nav-link">Lab Equipment</a></li>
                        <li><a href="{{ route('admin.lab.reports') }}" class="nav-link">Lab Reports</a></li>
                    </ul>
                </div>

                <!-- E-commerce Store -->
                <div class="nav-item">
                    <a href="javascript:void(0)" class="nav-link dropdown-btn">
                        <span class="nav-link-content">
                            <i class="fa-solid fa-cart-shopping menu-icon"></i> E-commerce Store
                        </span>
                        <i class="fa-solid fa-chevron-down dropdown-toggle-icon"></i>
                    </a>
                    <ul class="sidebar-dropdown">
                        <li><a href="{{ route('admin.store.index') }}" class="nav-link">All Products</a></li>
                        <li><a href="{{ route('admin.store.create') }}" class="nav-link">Add New Product</a></li>
                        <li><a href="{{ route('admin.store.categories') }}" class="nav-link">Product Categories</a></li>
                        <li><a href="{{ route('admin.store.orders') }}" class="nav-link">Orders List</a></li>
                        <li><a href="{{ route('admin.store.reviews') }}" class="nav-link">Product Reviews</a></li>
                    </ul>
                </div>

                <!-- Billing & Finance -->
                <div class="nav-section-title">Financials</div>
                <div class="nav-item">
                    <a href="javascript:void(0)" class="nav-link dropdown-btn">
                        <span class="nav-link-content">
                            <i class="fa-solid fa-file-invoice-dollar menu-icon"></i> Billing & Finance
                        </span>
                        <i class="fa-solid fa-chevron-down dropdown-toggle-icon"></i>
                    </a>
                    <ul class="sidebar-dropdown">
                        <li><a href="{{ route('admin.finance.invoices') }}" class="nav-link">All Invoices</a></li>
                        <li><a href="{{ route('admin.finance.receipts') }}" class="nav-link">Receipts</a></li>
                        <li><a href="{{ route('admin.finance.payments') }}" class="nav-link">Payment History</a></li>
                        <li><a href="{{ route('admin.insurance.index') }}" class="nav-link">Insurance Claims</a></li>
                        <li><a href="{{ route('admin.settings.gateways') }}" class="nav-link">Tax Settings</a></li>
                    </ul>
                </div>

                <!-- Reports -->
                <div class="nav-item">
                    <a href="javascript:void(0)" class="nav-link dropdown-btn">
                        <span class="nav-link-content">
                            <i class="fa-solid fa-chart-line menu-icon"></i> Reports
                        </span>
                        <i class="fa-solid fa-chevron-down dropdown-toggle-icon"></i>
                    </a>
                    <ul class="sidebar-dropdown">
                        <li><a href="{{ route('admin.reports.sales') }}" class="nav-link">Sales Report</a></li>
                        <li><a href="{{ route('admin.reports.patients') }}" class="nav-link">Patient Report</a></li>
                        <li><a href="{{ route('admin.reports.doctors') }}" class="nav-link">Doctor Performance</a></li>
                        <li><a href="{{ route('admin.reports.stock') }}" class="nav-link">Stock Report</a></li>
                        <li><a href="{{ route('admin.reports.revenue') }}" class="nav-link">Revenue Report</a></li>
                        <li><a href="{{ route('admin.reports.appointments') }}" class="nav-link">Appointment Report</a></li>
                    </ul>
                </div>

                <!-- System & Notifications -->
                <div class="nav-section-title">System</div>
                <div class="nav-item">
                    <a href="javascript:void(0)" class="nav-link dropdown-btn">
                        <span class="nav-link-content">
                            <i class="fa-solid fa-gears menu-icon"></i> System Settings
                        </span>
                        <i class="fa-solid fa-chevron-down dropdown-toggle-icon"></i>
                    </a>
                    <ul class="sidebar-dropdown">
                        <li><a href="{{ route('admin.settings.general') }}" class="nav-link">General Settings</a></li>
                        <li><a href="{{ route('admin.settings.email') }}" class="nav-link">Email Configuration</a></li>
                        <li><a href="{{ route('admin.settings.sms') }}" class="nav-link">SMS Configuration</a></li>
                        <li><a href="{{ route('admin.settings.gateways') }}" class="nav-link">Payment Gateways</a></li>
                        <li><a href="{{ route('admin.settings.backup') }}" class="nav-link">Backup & Restore</a></li>
                    </ul>
                </div>

                <div class="nav-item">
                    <a href="javascript:void(0)" class="nav-link dropdown-btn">
                        <span class="nav-link-content">
                            <i class="fa-solid fa-bell menu-icon"></i> Notifications
                        </span>
                        <i class="fa-solid fa-chevron-down dropdown-toggle-icon"></i>
                    </a>
                    <ul class="sidebar-dropdown">
                        <li><a href="{{ route('admin.notifications.send') }}" class="nav-link">Send Notification</a></li>
                        <li><a href="{{ route('admin.notifications.history') }}" class="nav-link">Notification History</a></li>
                        <li><a href="{{ route('admin.notifications.emailTemplates') }}" class="nav-link">Email Templates</a></li>
                        <li><a href="{{ route('admin.notifications.smsTemplates') }}" class="nav-link">SMS Templates</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="logout-container">
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-outline-danger w-100 text-start border-0">
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
            <h5 class="mb-0 fw-bold">@yield('page_title', 'Dashboard')</h5>
            <div class="d-flex align-items-center">
                <button class="btn btn-light position-relative me-3 rounded-circle">
                    <i class="fa-regular fa-bell"></i>
                </button>
                <div class="dropdown">
                    <div class="d-flex align-items-center bg-light px-3 py-1 rounded-pill cursor-pointer" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                        <div class="avatar me-2 bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 32px; height: 32px;">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="me-2">
                            <div class="small fw-bold">{{ auth()->user()->name }}</div>
                            <div class="text-muted" style="font-size: 0.65rem;">Administrator</div>
                        </div>
                        <i class="fa-solid fa-chevron-down small text-muted"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                        <li><a class="dropdown-item" href="#"><i class="fa-regular fa-user me-2"></i> Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fa-solid fa-gears me-2"></i> Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa-solid fa-right-from-bracket me-2"></i> Sign Out
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="content-body">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Dropdown toggle logic
            const dropdownBtns = document.querySelectorAll('.dropdown-btn');
            dropdownBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const parent = this.parentElement;
                    const isOpen = parent.classList.contains('show');
                    
                    // Close other open dropdowns in the same section if desired
                    // (Optional: comment out if you want multiple open)
                    // document.querySelectorAll('.nav-item.show').forEach(item => {
                    //     if (item !== parent) item.classList.remove('show');
                    // });

                    parent.classList.toggle('show');
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
