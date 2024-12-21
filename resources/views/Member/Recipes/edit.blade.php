@extends('layout.profile')

@section('title', 'Edit Resep')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Edit Resep</h1>
    <form action="{{ route('member.recipes.update', $recipe->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Judul Resep</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $recipe->title }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi (Opsional)</label>
            <textarea class="form-control" id="description" name="description">{{ $recipe->description }}</textarea>
        </div>
        <div class="mb-3">
            <label for="ingredients" class="form-label">Bahan-bahan</label>
            <textarea class="form-control" id="ingredients" name="ingredients" rows="5">{{ implode("\n", json_decode($recipe->ingredients)) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="steps" class="form-label">Langkah-langkah</label>
            <textarea class="form-control" id="steps" name="steps" rows="5">{{ implode("\n", json_decode($recipe->steps)) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Foto Resep (Opsional)</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
            @if($recipe->image)
                <img src="{{ asset($recipe->image) }}" alt="Foto Resep" class="img-fluid mt-2" style="max-height: 200px;">
            @endif
        </div>
        <button type="submit" class="btn btn-success w-100">Simpan Perubahan</button>
    </form>
</div>
@endsection