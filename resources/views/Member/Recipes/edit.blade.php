@extends('layout.profile')

@section('title', 'Edit Resep')

@section('content')
<div class="container mt-5">
    <!-- notif eror image -->
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <!-- Tombol Kembali -->
    <a href="{{ route('member.recipes.index') }}" class="btn btn-secondary mb-3">← Kembali</a>
    <h1 class="text-center mb-4">Edit Resep</h1>

    <!-- Form Edit Resep -->
    <form action="{{ route('member.recipes.update', $recipe->recipe_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Judul Resep -->
        <div class="mb-3">
            <label for="title" class="form-label">Judul Resep</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $recipe->title }}" required>
        </div>

        <!-- Deskripsi Resep -->
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="description" required name="description">{{ $recipe->description }}</textarea>
        </div>

        <!-- Dynamic Bahan-bahan -->
        <h5>Bahan-bahan</h5>
        <div id="bahan-container">
            @foreach(json_decode($recipe->ingredients) as $ingredient)
            <div class="input-group mb-2">
                <input type="text" name="ingredients[]" class="form-control" value="{{ $ingredient }}" required>
                <button type="button" class="btn btn-danger remove-bahan">Hapus</button>
            </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-secondary" id="add-bahan">+ Bahan</button>

        <!-- Dynamic Langkah-langkah -->
        <h5 class="mt-4">Langkah-langkah</h5>
        <div id="langkah-container">
            @foreach(json_decode($recipe->steps) as $step)
            <div class="input-group mb-2">
                <input type="text" name="steps[]" class="form-control" value="{{ $step }}" required>
                <button type="button" class="btn btn-danger remove-langkah">Hapus</button>
            </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-secondary" id="add-langkah">+ Langkah</button>

        <!-- Foto Resep -->
        <div class="mb-3 mt-4">
            <label for="image" class="form-label">Foto Resep</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
            <!-- Menampilkan Foto Resep Saat Ini -->
            @if($recipe->image)
            <img src="{{ asset($recipe->image) }}" alt="Foto Resep" class="img-fluid mt-2" style="max-height: 200px;">
            @endif
        </div>

        <!-- Kategori -->
        <div class="mb-3">
            <label for="category" class="form-label">Kategori</label>
            <select name="category" id="category" class="form-select" required>
                <option value="">Pilih Kategori</option>
                <option value="Masakan Indonesia" {{ $recipe->category == 'Masakan Indonesia' ? 'selected' : '' }}>Masakan Indonesia</option>
                <option value="Masakan Luar Negeri" {{ $recipe->category == 'Masakan Luar Negeri' ? 'selected' : '' }}>Masakan Luar Negeri</option>
            </select>
        </div>

        <!-- Tombol Simpan -->
        <button type="submit" class="btn btn-success w-100">Simpan Perubahan</button>
    </form>
</div>
@endsection
