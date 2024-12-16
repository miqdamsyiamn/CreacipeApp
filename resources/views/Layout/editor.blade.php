<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Editor')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/editor.css') }}">
</head>

<body>
    <div class="topbar d-flex justify-content-between align-items-center">
        <span>SELAMAT DATANG EDITOR | DASHBOARD</span>
        <form class="d-flex" method="GET"
            action="{{ Request::is('editor/recipes*') ? route('editor.recipes.search') : '#' }}">
            <input class="form-control me-2" type="search" name="keyword" placeholder="Search" aria-label="Search" value="{{ request('keyword') }}">
            <button class="btn btn-outline-light" type="submit">Search</button>
        </form>

    </div>

    <div class="d-flex">
        <div class="sidebar d-flex flex-column justify-content-between">
            <div>
                <a href="{{ route('editor.dashboard') }}" class="active">Dashboard</a>
                <a href="{{ route('editor.recipes.index') }}">Kelola Resep</a>
            </div>
            <div class="mt-0">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100 mt-2">Logout</button>
                </form>
            </div>
        </div>

        <div class="flex-grow-1 p-4">
            @yield('content')
        </div>
    </div>

    {{-- @include('recipes.showeditor') --}}
    @include('dashboard.editor.recipes.create')


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>