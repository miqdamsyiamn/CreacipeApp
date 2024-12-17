@extends('layout.profile')

@section('title', 'Resepku')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Resepmu</h1>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <button class="btn btn-secondary">Terakhir Dilihat</button>
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
                            @if($recipe->status_id == 1) bg-warning 
                            @elseif($recipe->status_id == 2) bg-success
                            @elseif($recipe->status_id == 3) bg-danger
                            @endif">
                                @if($recipe->status_id == 1) Pending
                                @elseif($recipe->status_id == 2) Approved
                                @elseif($recipe->status_id == 3) Declined
                                @endif
                            </span>
                        </div>
                    </div>
                    <p class="text-muted mt-2" style="font-size: 0.8rem;">Dibuat pada {{ \Carbon\Carbon::parse($recipe->created_at)->isoFormat('dddd, DD MMMM YYYY') }}</p>
                    <div class="dropdown position-absolute" style="bottom: 10px; right: 10px;">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton{{ $recipe->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $recipe->id }}">
                            <!-- Hanya opsi Edit -->
                            <li><a class="dropdown-item" href="{{ route('member.recipes.edit', $recipe->id) }}">Edit Resep</a></li>
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
    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $recipes->links() }}
    </div>
</div>
@endsection
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif