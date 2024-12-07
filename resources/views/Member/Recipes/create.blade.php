<!-- Modal Tambah Resep -->
<div class="modal fade" id="addRecipeModal" tabindex="-1" aria-labelledby="addRecipeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRecipeModalLabel">Tambah Resep</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('member.recipes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- Judul -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Resep</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Judul Resep" required>
                    </div>
                    <!-- Deskripsi -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi (Opsional)</label>
                        <textarea class="form-control" id="description" name="description" placeholder="Cerita atau inspirasi dari resep ini"></textarea>
                    </div>
                    <!-- Bahan -->
                    <div class="mb-3">
                        <label for="ingredients" class="form-label">Bahan-bahan</label>
                        <textarea class="form-control" id="ingredients" name="ingredients" placeholder="Masukkan bahan-bahan, pisahkan dengan enter" rows="5" required></textarea>
                    </div>
                    <!-- Langkah -->
                    <div class="mb-3">
                        <label for="steps" class="form-label">Langkah-langkah</label>
                        <textarea class="form-control" id="steps" name="steps" placeholder="Masukkan langkah-langkah, pisahkan dengan enter" rows="5" required></textarea>
                    </div>
                    <!-- Foto -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Foto Resep (Opsional)</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Terbitkan Resep</button>
                </div>
            </form>
        </div>
    </div>
</div>
