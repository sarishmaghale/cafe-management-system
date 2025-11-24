<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Example-app</title>

    <!-- Bootstrap + FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        :root {
            --bg-color: #f5f5f8;
            --text-color: #222;
            --sidebar-bg: #1e1e2f;
            --sidebar-hover: #343454;
            --navbar-bg: #343454;
            --active-color: #4fc3f7;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: var(--bg-color);
            color: var(--text-color);
            transition: background 0.3s, color 0.3s;
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
            padding: 0.6rem 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar .nav-link,
        .navbar-brand,
        .navbar .btn {
            color: #fff !important;
        }

        /* Remove button outline on focus */
        #sidebarToggle:focus {
            box-shadow: none;
        }

        /* Sidebar */
        #sidebar {
            position: fixed;
            top: 56px;
            left: 0;
            width: 60px;
            /* collapsed by default */
            height: 100%;
            background: var(--sidebar-bg);
            overflow-y: auto;
            transition: width 0.3s;
            padding-top: 1rem;
        }

        #sidebar.expanded {
            width: 200px;
        }

        #sidebar .nav-link {
            color: #cfcfe8;
            padding: 10px 15px;
            display: flex;
            align-items: center;
            white-space: nowrap;
            font-size: 15px;
            transition: all 0.3s;
        }

        #sidebar .nav-link i {
            width: 22px;
        }

        #sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.18);
            color: #fff !important;
            border-left: 4px solid var(--active-color);
        }

        /* Hide text when collapsed */
        #sidebar:not(.expanded) .nav-link span {
            display: none;
        }

        #sidebar:not(.expanded) .submenu a span {
            display: none;
        }

        #sidebar:not(.expanded) .nav-link {
            justify-content: center;
        }

        /* Submenu */
        .submenu {
            display: none;
            flex-direction: column;
            padding-left: 15px;
        }

        .submenu.show {
            display: flex;
        }

        /* Main content */
        #content {
            margin-left: 60px;
            margin-top: 56px;
            padding: 20px;
            transition: margin-left 0.3s;
        }

        #sidebar.expanded+#content {
            margin-left: 200px;
        }

        /* User dropdown */
        #userDropdownWrapper {
            position: fixed;
            top: 10px;
            right: 10px;
            z-index: 1100;
        }

        /* Card shadow effect */
        .card {
            border-radius: 0.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            transition: box-shadow 0.3s;
        }

        .card:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.25);
        }

        .chart-container {
            position: relative;
            width: 100%;
            height: 350px;
            /* desktop height */
        }

        @media (max-width: 768px) {
            .chart-container {
                height: 140px;
                /* mobile height */
            }
        }

        .chart-container canvas {
            display: block;
            width: 100% !important;
            height: 100% !important;
        }
    </style>
    @stack('styles')
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Navbar -->
    <nav class="navbar navbar-dark">
        <button class="btn btn-dark" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <a class="navbar-brand ms-3" href="#">Example-app</a>
        <div></div>
    </nav>

    <!-- User Dropdown -->
    <div id="userDropdownWrapper">
        <div class="dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center fw-medium text-white"
                data-bs-toggle="dropdown">
                <img src="{{ asset('images/userLogo.png') }}" class="rounded-circle" width="35" height="35">
                <span class="ms-2">{{ Auth::user()->name }}</span>
            </a>

            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="/profile">Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">@csrf
                        <button class="dropdown-item text-danger">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- Sidebar -->
    <div id="sidebar">
        <nav class="nav flex-column">
            <a class="nav-link" href="/"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
            <a class="nav-link" href="{{ route('stations.index') }}"><i class="fas fa-building"></i>
                <span>Stations</span></a>
            <a class="nav-link" href="{{ route('products.show') }}"><i class="fas fa-box"></i> <span>Products</span></a>
            <a class="nav-link" href="{{ route('bills.show') }}"><i class="fas fa-shopping-cart"></i>
                <span>Bills</span></a>
            <a class="nav-link" href="{{ route('translator.index') }}"><i class="fas fa-language"></i>
                <span>Translator</span></a>

            <!-- Components Dropdown -->
            <a class="nav-link d-flex justify-content-between align-items-center" id="componentsToggle"
                href="javascript:void(0)">
                <i class="fas fa-cogs"></i> <span>Components</span>
                <i class="fas fa-chevron-down ms-auto"></i>
            </a>

            <div class="submenu" id="componentsMenu">
                <a class="nav-link" href="{{ route('stations.add') }}"><i class="fas fa-user-cog"></i> <span>Update
                        Stations</span></a>
                <a class="nav-link" href=""><i class="fas fa-search"></i> <span>Search
                        Receipt</span></a>
                <a class="nav-link" href="/roles"><i class="fas fa-user-shield"></i> <span>Roles</span></a>
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
                    if (submenu) submenu.classList.add("show");

                    // Optionally mark parent toggle as active
                    const parentToggle = submenu?.previousElementSibling;
                    if (parentToggle) parentToggle.classList.add("active");
                }
            });

        });
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: '{{ session('success') }}',
                timer: 2500,
            });
        @endif
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}'
            });
        @endif
    </script>
    @stack('scripts')
</body>

</html>
