<div class="modal fade" id="editRecipeModal{{ $recipe->id }}" tabindex="-1" aria-labelledby="editRecipeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('editor.recipes.update', $recipe->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Edit Resep</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <!-- Judul -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $recipe->title }}" required>
                    </div>
                    <!-- Deskripsi -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="3">{{ $recipe->description }}</textarea>
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
                    <!-- Gambar -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Foto Resep</label>
                        <input type="file" class="form-control" id="image" name="image">
                        <img src="{{ asset($recipe->image) }}" class="img-fluid mt-2" style="max-height: 150px;">
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
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>