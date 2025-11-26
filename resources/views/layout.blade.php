<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BrewBerry</title>

    <!-- Bootstrap + FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <style>
        :root {
            --bg-color: #f8f9fa;
            --text-color: #2d3748;
            --sidebar-bg: #1a202c;
            --sidebar-hover: #2d3748;
            --navbar-bg: #ffffff;
            --active-color: #3b82f6;
            --active-bg: rgba(59, 130, 246, 0.1);
            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--bg-color);
            color: var(--text-color);
            transition: background 0.3s ease, color 0.3s ease;
            font-size: 14px;
            line-height: 1.6;
        }

        .no-spin::-webkit-outer-spin-button,
        .no-spin::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Navbar */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1050;
            background: var(--navbar-bg);
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: var(--shadow-sm);
            border-bottom: 1px solid var(--border-color);
            height: 64px;
        }

        .navbar-brand {
            color: var(--text-color) !important;
            font-weight: 700;
            font-size: 1.25rem;
            letter-spacing: -0.5px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        #sidebarToggle {
            background: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-color);
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        #sidebarToggle:hover {
            background: var(--bg-color);
            border-color: var(--active-color);
            color: var(--active-color);
        }

        #sidebarToggle:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            outline: none;
        }

        /* Sidebar */
        #sidebar {
            position: fixed;
            top: 64px;
            left: 0;
            width: 70px;
            height: calc(100vh - 64px);
            background: var(--sidebar-bg);
            overflow-y: auto;
            overflow-x: hidden;
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 1rem 0;
            box-shadow: var(--shadow-md);
            z-index: 1040;
        }

        #sidebar::-webkit-scrollbar {
            width: 6px;
        }

        #sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        #sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }

        #sidebar.expanded {
            width: 260px;
        }

        #sidebar .nav-link {
            color: #cbd5e0;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            white-space: nowrap;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            margin: 2px 8px;
            border-radius: 8px;
            position: relative;
        }

        #sidebar .nav-link:hover {
            background: var(--sidebar-hover);
            color: #ffffff;
            transform: translateX(2px);
        }

        #sidebar .nav-link i {
            width: 20px;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #sidebar .nav-link span {
            margin-left: 12px;
            opacity: 1;
            transition: opacity 0.2s ease;
        }

        #sidebar .nav-link.active {
            background: var(--active-bg);
            color: var(--active-color) !important;
            border-left: 3px solid var(--active-color);
            font-weight: 600;
        }

        #sidebar .nav-link.active i {
            color: var(--active-color);
        }

        /* Hide text when collapsed */
        #sidebar:not(.expanded) .nav-link span {
            opacity: 0;
            display: none;
        }

        #sidebar:not(.expanded) .submenu a span {
            opacity: 0;
            display: none;
        }

        #sidebar:not(.expanded) .nav-link {
            justify-content: center;
            padding: 12px;
        }

        #sidebar:not(.expanded) .nav-link .fa-chevron-down {
            display: none;
        }

        /* Submenu */
        .submenu {
            display: none;
            flex-direction: column;
            padding-left: 0;
            margin-left: 8px;
            margin-right: 8px;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            overflow: hidden;
            margin-top: 4px;
        }

        .submenu.show {
            display: flex;
        }

        .submenu .nav-link {
            margin: 0;
            border-radius: 0;
            padding-left: 48px;
            font-size: 13px;
            border-left: none;
        }

        .submenu .nav-link:first-child {
            padding-top: 8px;
        }

        .submenu .nav-link:last-child {
            padding-bottom: 8px;
        }

        .submenu .nav-link.active {
            background: rgba(59, 130, 246, 0.15);
            border-left: 3px solid var(--active-color);
        }

        #componentsToggle .fa-chevron-down {
            font-size: 12px;
            transition: transform 0.3s ease;
            margin-left: auto;
        }

        #componentsToggle.active .fa-chevron-down,
        .submenu.show~#componentsToggle .fa-chevron-down {
            transform: rotate(180deg);
        }

        /* Main content */
        #content {
            margin-left: 70px;
            margin-top: 64px;
            padding: 2rem;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: calc(100vh - 64px);
        }

        #sidebar.expanded+#content {
            margin-left: 260px;
        }

        /* User dropdown */
        #userDropdownWrapper {
            position: fixed;
            top: 12px;
            right: 20px;
            z-index: 1100;
        }

        #userDropdownWrapper .nav-link {
            color: var(--text-color) !important;
            padding: 6px 12px;
            border-radius: 12px;
            transition: all 0.2s ease;
            background: var(--bg-color);
            border: 1px solid var(--border-color);
        }

        #userDropdownWrapper .nav-link:hover {
            background: #ffffff;
            box-shadow: var(--shadow-sm);
        }

        #userDropdownWrapper .dropdown-menu {
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-lg);
            border-radius: 12px;
            padding: 8px;
            margin-top: 8px;
            min-width: 200px;
        }

        #userDropdownWrapper .dropdown-item {
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        #userDropdownWrapper .dropdown-item:hover {
            background: var(--bg-color);
            color: var(--active-color);
        }

        #userDropdownWrapper .dropdown-divider {
            margin: 8px 0;
            opacity: 0.5;
        }

        /* Card improvements */
        .card {
            border-radius: 12px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
            background: #ffffff;
        }

        .card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .card-header {
            background: #ffffff;
            border-bottom: 1px solid var(--border-color);
            padding: 1.25rem 1.5rem;
            font-weight: 600;
            font-size: 1.1rem;
            color: var(--text-color);
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Chart container */
        .chart-container {
            position: relative;
            width: 100%;
            height: 350px;
            padding: 1rem;
        }

        @media (max-width: 768px) {
            .chart-container {
                height: 240px;
            }

            #sidebar {
                width: 0;
                padding: 0;
            }

            #sidebar.expanded {
                width: 260px;
                padding: 1rem 0;
            }

            #content {
                margin-left: 0;
            }

            #sidebar.expanded+#content {
                margin-left: 0;
            }

            .navbar {
                padding: 0.75rem 1rem;
            }

            #userDropdownWrapper {
                right: 10px;
            }
        }

        .chart-container canvas {
            display: block;
            width: 100% !important;
            height: 100% !important;
        }

        /* Button improvements */
        .btn {
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }

        /* Form improvements */
        .form-control,
        .form-select {
            border-radius: 8px;
            border: 1px solid var(--border-color);
            padding: 0.625rem 0.875rem;
            transition: all 0.2s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--active-color);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* Table improvements */
        .table {
            border-radius: 8px;
            overflow: hidden;
        }

        .table thead th {
            background: var(--bg-color);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
            color: #64748b;
            border-bottom: 2px solid var(--border-color);
        }

        /* Badge improvements */
        .badge {
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            font-weight: 500;
        }

        /* SweetAlert2 customization */
        .swal2-popup {
            border-radius: 16px;
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
    </style>
    @stack('styles')
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Navbar -->
    <nav class="navbar navbar-light">
        <button class="btn" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <a class="navbar-brand ms-3" href="#">BrewBerry</a>
        <div></div>
    </nav>

    <!-- User Dropdown -->
    <div id="userDropdownWrapper">
        <div class="dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown" href="#"
                role="button">
                <img src="{{ asset('images/userLogo.png') }}" class="rounded-circle" width="32" height="32"
                    alt="User">
                <span class="ms-2 fw-medium">{{ Auth::user()->name }}</span>
            </a>

            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="/profile"><i class="fas fa-user me-2"></i>Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">@csrf
                        <button class="dropdown-item text-danger"><i
                                class="fas fa-sign-out-alt me-2"></i>Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- Sidebar -->
    <div id="sidebar">
        <nav class="nav flex-column">
            <a class="nav-link" href="/">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            <a class="nav-link" href="{{ route('stations.index') }}">
                <i class="fas fa-building"></i>
                <span>Stations</span>
            </a>
            <a class="nav-link" href="{{ route('products.show') }}">
                <i class="fas fa-box"></i>
                <span>Products</span>
            </a>
            <a class="nav-link" href="{{ route('bills.show') }}">
                <i class="fas fa-shopping-cart"></i>
                <span>Bills</span>
            </a>
            <a class="nav-link" href="{{ route('translator.index') }}">
                <i class="fas fa-language"></i>
                <span>Translator</span>
            </a>
            <a class="nav-link" href="{{ route('kitchen.index') }}">
                <i class="fas fa-utensils"></i>
                <span>Kitchen</span>
            </a>

            <!-- Components Dropdown -->
            <a class="nav-link d-flex justify-content-between align-items-center" id="componentsToggle"
                href="javascript:void(0)">
                <span><i class="fas fa-cogs"></i> <span>Components</span></span>
                <i class="fas fa-chevron-down"></i>
            </a>

            <div class="submenu" id="componentsMenu">
                <a class="nav-link" href="{{ route('stations.add') }}">
                    <i class="fas fa-user-cog"></i>
                    <span>Update Stations</span>
                </a>
                <a class="nav-link" href="{{ route('users.index') }}">
                    <i class="fas fa-search"></i>
                    <span>Update users</span>
                </a>
                <a class="nav-link" href="/roles">
                    <i class="fas fa-user-shield"></i>
                    <span>Roles</span>
                </a>
            </div>
        </nav>
    </div>

    <!-- Main content -->
    <div id="content">
        @yield('content')
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sidebar = document.getElementById("sidebar");
            const toggleBtn = document.getElementById("sidebarToggle");
            const componentsToggle = document.getElementById("componentsToggle");
            const componentsMenu = document.getElementById("componentsMenu");

            // Sidebar collapsed by default
            sidebar.classList.remove("expanded");

            // Toggle sidebar
            toggleBtn.addEventListener("click", () => {
                sidebar.classList.toggle("expanded");
            });

            // Toggle submenu
            componentsToggle.addEventListener("click", () => {
                componentsMenu.classList.toggle("show");
                componentsToggle.classList.toggle("active");
            });

            // Highlight active link
            const currentPath = window.location.pathname;
            document.querySelectorAll("#sidebar .nav-link").forEach(link => {
                const linkHref = link.getAttribute("href");
                if (!linkHref || linkHref === "javascript:void(0)") return;

                const linkPath = new URL(link.href, window.location.origin).pathname;

                // Exact match or inside a subpath
                if (currentPath === linkPath || currentPath.startsWith(linkPath + "/")) {
                    link.classList.add("active");

                    // Open submenu if this link is inside one
                    const submenu = link.closest(".submenu");
                    if (submenu) {
                        submenu.classList.add("show");
                        // Mark parent toggle as active
                        const parentToggle = document.getElementById("componentsToggle");
                        if (parentToggle) parentToggle.classList.add("active");
                    }
                }
            });

        });

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: '{{ session('success') }}',
                timer: 1500,
                showConfirmButton: false,
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                confirmButtonColor: '#3b82f6'
            });
        @endif
    </script>
    @stack('scripts')
</body>

</html>
