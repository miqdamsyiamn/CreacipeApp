@extends('layout.editor') <!-- Layout khusus untuk editor -->

@section('title', 'Semua Resep')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Semua Resep</h2>
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
                        <a href="{{ route('recipes.showeditor', $recipe->id) }}" class="btn btn-primary">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">Tidak ada resep yang tersedia.</p>
        @endforelse
    </div>
    <div class="d-flex justify-content-center">
        {{ $recipes->links() }} <!-- Pagination -->
    </div>
</div>
@endsection
