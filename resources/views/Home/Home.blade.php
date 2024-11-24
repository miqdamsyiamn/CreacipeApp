@extends('layout.main') <!-- Menggunakan layout utama -->

@section('title', 'Home') <!-- Mengatur judul halaman -->

@section('hero') <!-- Hero Section -->
<div class="container">
    <h1>Masak Makin Menyenangkan</h1>
    <p>Temukan dan bagikan resep lezat untuk masakan harianmu</p>
</div>
@endsection

@section('content') <!-- Konten Utama -->
<div class="text-center mb-5">
    <h2>Cari dan Temukan Resep dari Komunitas</h2>
    <p>Melalui fitur pencarian, kamu dapat menemukan resep berdasarkan bahan atau kategori yang diinginkan.</p>
</div>
<div class="row">
    <div class="col-md-4">
        <img src="https://via.placeholder.com/300x200" class="img-fluid" alt="Resep 1">
        <h4 class="mt-3">Resep Terbaru</h4>
        <p>Cari resep terbaru untuk inspirasi memasak harianmu.</p>
    </div>
    <div class="col-md-4">
        <img src="https://via.placeholder.com/300x200" class="img-fluid" alt="Resep 2">
        <h4 class="mt-3">Populer</h4>
        <p>Resep populer yang paling banyak dicoba oleh pengguna.</p>
    </div>
    <div class="col-md-4">
        <img src="https://via.placeholder.com/300x200" class="img-fluid" alt="Resep 3">
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

