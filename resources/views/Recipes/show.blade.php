@extends('layout.main')

@section('title', $recipe->title)

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">{{ $recipe->title }}</h2>

    <!-- Gambar Resep -->
    <div class="text-center mb-4">
        <img src="{{ asset($recipe->image ?? 'https://via.placeholder.com/600x400') }}" 
            class="img-fluid rounded" alt="{{ $recipe->title }}">
    </div>

    <!-- Detail Resep -->
    <div class="row">
        <div class="col-md-12">
            <!-- Deskripsi -->
            <h4>Deskripsi</h4>
            <p>{{ $recipe->description ?? 'Tidak ada deskripsi.' }}</p>

            <!-- Bahan-bahan -->
            <h4>Bahan-bahan</h4>
            <ul>
                @foreach(explode("\n", $recipe->ingredients) as $ingredient)
                    <li>{{ $ingredient }}</li>
                @endforeach
            </ul>

            <!-- Langkah-langkah -->
            <h4>Langkah-langkah</h4>
            <ol>
                @foreach(explode("\n", $recipe->steps) as $step)
                    <li>{{ $step }}</li>
                @endforeach
            </ol>
        </div>
    </div>
</div>
@endsection
