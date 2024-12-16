<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin')</title>
    <!-- Tambahkan link ke Bootstrap atau stylesheet lainnya -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/admin.css') }}">
</head>

<body>
    <!-- Topbar -->
    <div class="topbar d-flex justify-content-between align-items-center p-3" style="background-color: #3CB371; color: white;">
        <span>SELAMAT DATANG ADMIN | DASHBOARD</span>
        <!-- Kolom Pencarian -->
        <form class="d-flex" method="GET"action="{{ Request::is('admin/editors*') ? route('admin.editors.search') : (Request::is('admin/members*') ? route('admin.members.search') : '#') }}">
            <input class="form-control me-2" type="search" name="keyword" placeholder="Search" aria-label="Search" value="{{ request('keyword') }}">
            <button class="btn btn-outline-light" type="submit">Search</button>
        </form>
    </div>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar d-flex flex-column justify-content-between p-3" style="background-color: #ffffff; border-right: 1px solid #ddd; width: 250px;">
            <!-- Sidebar Menu -->
            <div>
                <a href="{{ route('admin.dashboard') }}" class="nav-link active">Dashboard</a>
                <a href="{{ route('admin.editors') }}" class="nav-link">Kelola Editor</a>
                <a href="{{ route('admin.members') }}" class="nav-link">Kelola Member</a>
            </div>
            <!-- Logout Button -->
            <div>
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