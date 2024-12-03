@extends('layout.main') <!-- Menggunakan layout utama -->

@section('title', 'Home') <!-- Mengatur judul halaman -->

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
<div class="text-center mb-5">
    <h2>Cari dan Temukan Resep dari Komunitas</h2>
    <p>Melalui fitur pencarian, kamu dapat menemukan resep berdasarkan bahan atau kategori yang diinginkan.</p>
</div>
<div class="row">
    <div class="col-md-4">
        <img src="https://via.placeholder.com/300x200" class="img-fluid custom-border" alt="Resep 1">
        <h4 class="mt-3">Resep Terbaru</h4>
        <p>Cari resep terbaru untuk inspirasi memasak harianmu.</p>
    </div>
    <div class="col-md-4">
        <img src="https://via.placeholder.com/300x200" class="img-fluid custom-border" alt="Resep 2">
        <h4 class="mt-3">Populer</h4>
        <p>Resep populer yang paling banyak dicoba oleh pengguna.</p>
    </div>
    <div class="col-md-4">
        <img src="https://via.placeholder.com/300x200" class="img-fluid custom-border" alt="Resep 3">
        <h4 class="mt-3">Komunitas</h4>
        <p>Bagikan resep terbaikmu dengan komunitas kami.</p>
    </div>
</div>
@endsection

@section('modal') <!-- Bagian Modal -->
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
