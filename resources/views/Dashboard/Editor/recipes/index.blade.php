@extends('layout.editor') <!-- Layout khusus untuk editor -->

@section('title', 'Semua Resep')

@section('content')
<div class="container mt-4">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRecipeModalEditor">Tambah Resep</button>
    <h2 class="text-center mb-4">Semua Resep</h2>
    <!-- Notifikasi -->
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <div class="row">
        @forelse($recipes as $recipe)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ asset($recipe->image ?? 'assets/default-recipe.jpg') }}" 
                        class="card-img-top" alt="{{ $recipe->title }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $recipe->title }}</h5>
                        <p class="card-text text-truncate">{{ $recipe->description }}</p>
                        <p class="card-text"><strong>Oleh:</strong> {{ $recipe->user->name }}</p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#recipeModal{{ $recipe->id }}">Lihat Resep</button>
                    </div>
                </div>
            </div>
            <!-- Modal untuk Edit Resep -->
            @include('dashboard.editor.recipes.edit', ['recipe' => $recipe])
        @empty
            <p class="text-center">Tidak ada resep yang tersedia.</p>
        @endforelse
    </div>
    <!-- paginasi -->
    <div class="d-flex justify-content-center mt-4">
        {{ $recipes->links('pagination::simple-bootstrap-4') }}
    </div>
</div>
@endsection
