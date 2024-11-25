<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Editor')</title>
    <!-- Tambahkan link ke Bootstrap atau stylesheet lainnya -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .sidebar {
            background-color: #343a40;
            height: 100vh;
            padding-top: 20px;
        }
        .sidebar a {
            color: #ffffff;
            text-decoration: none;
            padding: 10px 20px;
            display: block;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .active {
            background-color: #ffc107;
            color: #343a40;
        }
        .topbar {
            background-color: #ffc107;
            padding: 10px 20px;
        }
    </style>
</head>
<body>
    <!-- Topbar -->
    <div class="topbar d-flex justify-content-between align-items-center">
        <span>SELAMAT DATANG EDITOR | DASHBOARD</span>
        <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-dark" type="submit">Search</button>
        </form>
    </div>

    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar d-flex flex-column justify-content-between">
            <!-- Menu editor -->
            <div>
                <a href="{{ route('editor.dashboard') }}" class="active">Dashboard</a>
                <a href="#">Kelola Resep</a>
            </div>
            <!-- Logout -->
            <div class="mt-0">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100 mt-2">Logout</button>
                </form>
            </div>
        </div>
        <!-- End Sidebar -->

        <!-- Main Content -->
        <div class="flex-grow-1 p-4">
            @yield('content') <!-- Konten spesifik halaman -->
        </div>
    </div>

    <!-- Tambahkan link ke JavaScript Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
