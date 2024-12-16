@extends('layout.main') <!-- Menggunakan layout utama -->

@section('title', 'Home') <!-- Judul halaman -->

@section('hero') <!-- Hero Section -->
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000"> <!-- Slides every 3 seconds -->
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active slide-1">
            <div class="carousel-caption d-none d-md-block">
                <h1>Masak Makin Menyenangkan</h1>
                <p>Temukan dan bagikan resep lezat untuk masakan harianmu</p>
            </div>
        </div>
        <div class="carousel-item slide-2">
            <div class="carousel-caption d-none d-md-block">
                <h1>Resep Terbaru</h1>
                <p>Jelajahi kreasi resep terbaru dari komunitas kita</p>
            </div>
        </div>
        <div class="carousel-item slide-3">
            <div class="carousel-caption d-none d-md-block">
                <h1>Koleksi Resep</h1>
                <p>Bagikan inspirasi dan ide memasakmu</p>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
@endsection

@section('content') <!-- Konten Utama -->
<div class="container mt-5">
    <h2 class="text-center mb-4">Resep Pilihan</h2>
    <div class="row">
        
        @forelse($approvedRecipes as $recipe) <!-- Variabel dari controller -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ asset($recipe->image ?? 'https://via.placeholder.com/300x200') }}" 
                        class="card-img-top" alt="{{ $recipe->title }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $recipe->title }}</h5>
                        <p class="card-text text-truncate">{{ $recipe->description }}</p>
                        <!-- Menampilkan nama pembuat -->
                        <p class="card-text"><strong>Diposting oleh:</strong> {{ $recipe->user->name }}</p>
                        @auth
                            <!-- Tampilkan tombol untuk membuka modal resep -->
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#recipeModal{{ $recipe->id }}">Lihat Resep</button>
                        @else
                            <!-- Tampilkan tombol untuk membuka modal login jika belum login -->
                            <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#loginModal">Login untuk Lihat Resep</button>
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">Belum ada resep yang disetujui.</p>
        @endforelse
    </div>
</div>
@endsection

@section('modal') <!-- Bagian Modal -->
    @include('recipes.show') <!-- Menyertakan modal resep -->
    @include('layout.login') <!-- Memanggil modal login -->
    @include('layout.register') <!-- Memanggil modal register -->
@endsection

@section('scripts') <!-- Bagian Script -->
    @if(session('user_details'))
        <script>
            // Jika registrasi berhasil, tampilkan modal detail registrasi
            var registrationDetailsModal = new bootstrap.Modal(document.getElementById('registrationDetailsModal'));
            registrationDetailsModal.show();
        </script>
    @endif
@endsection
