@extends('layout.profile')

@section('title', 'Resepku')

@section('content')
<div class="container mt-5">
    <!-- Notifikasi Pesan Decline -->
    @if (session('decline_message'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('decline_message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <!-- Pesan Pencarian -->
    @if(isset($message))
    <div class="alert alert-info text-center">{{ $message }}</div>
    @endif


    <h1 class="text-center mb-4">Resepku</h1>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <!-- Tombol untuk menampilkan semua resep tanpa filter -->
            <a href="{{ route('member.recipes.index') }}" class="btn btn-secondary">Semua Resep</a>
        </div>

        <!-- Tombol Search Baru -->
        <div>
            <form class="d-flex" role="search" action="{{ route('member.recipes.search') }}" method="GET">
                <input class="form-control me-2" type="search" name="keyword" placeholder="Cari di koleksi resepmu"
                    aria-label="Search" value="{{ request('keyword') }}">
                <button class="btn btn-primary" type="submit">Cari</button>
            </form>
        </div>
    </div>
    <div class="row">
        @forelse($recipes as $recipe)
        <div class="col-md-4 mb-4">
            <div class="card">
                <!-- Gambar Resep -->
                @if($recipe->image)
                <img src="{{ asset($recipe->image) }}" class="card-img-top" alt="{{ $recipe->title }}">
                @else
                <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Placeholder Image">
                @endif
                <div class="card-body">
                    <!-- Judul Resep -->
                    <h5 class="card-title">{{ $recipe->title }}</h5>
                    <!-- Deskripsi Resep -->
                    <p class="card-text text-truncate" style="max-height: 3rem; overflow: hidden;">{{ $recipe->description }}</p>
                    <!-- Detail Info -->
                    <div class="d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <!-- Badge Privat -->
                                <span class="badge bg-success me-2">Privat</span>
                                <!-- Nama User -->
                                <small>{{ $recipe->user->name }}</small>
                            </div>
                        </div>
                        <!-- Status Badge -->
                        <div class="mt-2">
                            <span class="badge 
                            @if($recipe->status_recipes_id == 1) bg-warning 
                            @elseif($recipe->status_recipes_id == 2) bg-success
                            @elseif($recipe->status_recipes_id == 3) bg-danger
                            @endif">
                                @if($recipe->status_recipes_id == 1) Pending
                                @elseif($recipe->status_recipes_id == 2) Approved
                                @elseif($recipe->status_recipes_id == 3) Declined
                                @endif
                            </span>
                        </div>
                    </div>
                    <p class="text-muted mt-2" style="font-size: 0.8rem;">Dibuat pada {{ \Carbon\Carbon::parse($recipe->created_at)->isoFormat('dddd, DD MMMM YYYY') }}</p>
                    <div class="dropdown position-absolute" style="bottom: 10px; right: 10px;">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton{{ $recipe->recipe_id }}" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $recipe->recipe_id }}">
                            <!-- Hanya opsi Edit -->
                            <li><a class="dropdown-item" href="{{ route('member.recipes.edit', $recipe->recipe_id) }}">Edit Resep</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center">
            <p>Belum ada resep yang ditambahkan. Yuk, tambahkan resepmu sekarang!</p>
        </div>
        @endforelse
    </div>
    <!-- Paginasi -->
    <div class="d-flex justify-content-center mt-4">
        {{ $recipes->links('pagination::simple-bootstrap-4') }}
    </div>
</div>
@endsection
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif