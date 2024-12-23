<style>
    /* Styling Form */
    .form-control {
        border-radius: 12px;
        border: 1px solid #ced4da;
        padding: 12px;
        transition: all 0.3s ease-in-out;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .form-control:focus {
        border-color: #3cb371;
        box-shadow: 0 0 10px rgba(60, 179, 113, 0.3);
        outline: none;
    }

    .form-label {
        font-weight: bold;
        color: #3cb371;
    }

    .modal-header {
        background: linear-gradient(45deg, #2e8b57, #3cb371);
        color: white;
    }

    .btn-custom {
        background: linear-gradient(45deg, #2e8b57, #3cb371);
        color: white;
        border-radius: 12px;
        font-weight: bold;
    }

    .btn-custom:hover {
        background: #2e8b57;
    }
</style>

<!-- Modal Tambah Resep -->
<div class="modal fade" id="addRecipeModal" tabindex="-1" aria-labelledby="addRecipeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="addRecipeModalLabel"><i class="bi bi-pencil-square"></i> Tambah Resep</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Form -->
            <form action="{{ route('member.recipes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- Judul -->
                    <div class="mb-4">
                        <label for="title" class="form-label"><i class="bi bi-card-text"></i> Judul Resep</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Contoh: Nasi Goreng Spesial" required>
                    </div>
                    <!-- Deskripsi -->
                    <div class="mb-4">
                        <label for="description" class="form-label"><i class="bi bi-info-circle"></i> Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Deskripsi singkat resep..." required></textarea>
                    </div>

                    <!-- Dynamic Ingredients -->
                    <h5>Bahan-bahan</h5>
                    <div id="ingredients-container">
                        <div class="input-group mb-2">
                            <input type="text" name="ingredients[]" class="form-control" placeholder="Contoh: 1/2 ekor ayam" required>
                            <button type="button" class="btn btn-danger remove-ingredient">Hapus</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary mb-3" id="add-ingredient">+ Bahan</button>

                    <!-- Dynamic Steps -->
                    <h5>Langkah-langkah</h5>
                    <div id="steps-container">
                        <div class="input-group mb-2">
                            <input type="text" name="steps[]" class="form-control" placeholder="Contoh: Tumis bumbu hingga harum" required>
                            <button type="button" class="btn btn-danger remove-step">Hapus</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary mb-3" id="add-step">+ Langkah</button>

                    <!-- Foto -->
                    <div class="mb-4">
                        <label for="image" class="form-label"><i class="bi bi-image"></i> Foto Resep</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                    </div>

                    <!-- Kategori -->
                    <div class="mb-4">
                        <label for="category" class="form-label"><i class="bi bi-tags"></i> Kategori</label>
                        <select name="category" id="category" class="form-select" required>
                            <option value="">Pilih Kategori</option>
                            <option value="Masakan Indonesia">Masakan Indonesia</option>
                            <option value="Masakan Luar Negeri">Masakan Luar Negeri</option>
                        </select>
                    </div>
                </div>
                <!-- Footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-custom"><i class="bi bi-cloud-upload"></i> Terbitkan Resep</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script untuk Dynamic Field -->
<script src="{{ asset('assets/js/dynamic-fields.js') }}"></script>
