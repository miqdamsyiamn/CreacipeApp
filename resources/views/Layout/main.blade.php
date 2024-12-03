<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Resepku')</title>
    <!-- Tambahkan link ke Bootstrap atau stylesheet lainnya -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/style.css')}}">

    @yield('styles') <!-- Untuk tambahan CSS -->
</head>
<body>
    <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light custom-navbar">
    <div class="container">
        <a class="navbar-brand" href="#">Creacipe</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }} <!-- Menampilkan nama member -->
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Profil</a></li>
                            <li><a class="dropdown-item" href="{{ route('recipes.index') }}">Koleksi Resep</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <!-- Tombol Login -->
                    <li class="nav-item">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">Masuk</button>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>


    <!-- Hero Section -->
    @hasSection('hero')
        <section class="hero-section text-center">
            @yield('hero')
        </section>
    @endif

    <!-- Content Section -->
    <section class="py-5">
        <div class="container">
            @yield('content')
        </div>
    </section>

    <!-- Modal Login -->
    @include('layout.login')

    <!-- Modal Register -->
    @include('layout.register')

    <!-- Include modal detail registrasi -->
    @include('layout.detailregister')


    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container text-center">
            <p>&copy; 2024 Resepku. Semua Hak Dilindungi.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts') <!-- Untuk tambahan JS -->
</body>
</html>
