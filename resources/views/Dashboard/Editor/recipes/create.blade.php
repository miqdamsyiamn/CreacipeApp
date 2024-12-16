<style>
    /* Form Styling */
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

    .input-group-text {
        background-color: #3cb371;
        color: white;
        border: none;
        border-radius: 12px 0 0 12px;
    }

    .input-group .form-control {
        border-radius: 0 12px 12px 0;
    }

    .form-label {
        font-weight: bold;
        color: #3cb371;
    }

    textarea.form-control {
        resize: none;
    }

    /* Modal Styling */
    .modal-header {
        background: linear-gradient(45deg, #2e8b57, #3cb371);
        color: white;
        border-bottom: none;
    }

    .modal-footer {
        background-color: #f9f9f9;
        border-top: none;
    }

    .btn-custom {
        background: linear-gradient(45deg, #2e8b57, #3cb371);
        color: white;
        border-radius: 12px;
        font-weight: bold;
        padding: 10px 20px;
        transition: background-color 0.3s ease;
    }

    .btn-custom:hover {
        background: #2e8b57;
        color: #fff;
    }

    /* File Input Styling */
    input[type="file"] {
        border: none;
        padding: 5px 10px;
        border-radius: 12px;
        background: #f9f9f9;
        transition: background-color 0.3s ease;
    }

    input[type="file"]:hover {
        background: #f3f3f3;
    }

    /* Tooltip Style */
    .form-text {
        font-size: 0.85rem;
        color: #6c757d;
    }

    /* Modal Transition */
    .modal.fade .modal-dialog {
        transform: translateY(-50px);
        opacity: 0;
        transition: all 0.3s ease-in-out;
    }

    .modal.show .modal-dialog {
        transform: translateY(0);
        opacity: 1;
    }
</style>

<!-- Modal Tambah Resep (Editor) -->
<div class="modal fade" id="addRecipeModalEditor" tabindex="-1" aria-labelledby="addRecipeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="addRecipeModalLabel"><i class="bi bi-pencil-square"></i> Tambah Resep (Editor)</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Form -->
            <form action="{{ route('editor.recipes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- Judul -->
                    <div class="mb-4">
                        <label for="title" class="form-label"><i class="bi bi-card-text"></i> Judul Resep</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-book"></i></span>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Contoh: Nasi Goreng Spesial" required>
                        </div>
                    </div>
                    <!-- Deskripsi -->
                    <div class="mb-4">
                        <label for="description" class="form-label"><i class="bi bi-info-circle"></i> Deskripsi (Opsional)</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Berikan deskripsi singkat atau cerita di balik resep ini..."></textarea>
                    </div>
                    <!-- Bahan -->
                    <div class="mb-4">
                        <label for="ingredients" class="form-label"><i class="bi bi-basket"></i> Bahan-bahan</label>
                        <textarea class="form-control" id="ingredients" name="ingredients" rows="5" placeholder="Pisahkan setiap bahan dengan enter" required></textarea>
                        <small class="form-text">Pisahkan setiap bahan dengan menekan enter.</small>
                    </div>
                    <!-- Langkah -->
                    <div class="mb-4">
                        <label for="steps" class="form-label"><i class="bi bi-list-check"></i> Langkah-langkah</label>
                        <textarea class="form-control" id="steps" name="steps" rows="5" placeholder="Pisahkan setiap langkah dengan enter" required></textarea>
                        <small class="form-text">Pisahkan setiap langkah dengan menekan enter.</small>
                    </div>
                    <!-- Foto -->
                    <div class="mb-4">
                        <label for="image" class="form-label"><i class="bi bi-image"></i> Foto Resep (Opsional)</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>
                    <!-- Status Resep -->
                    <div class="mb-4">
                        <label for="status" class="form-label"><i class="bi bi-check-circle"></i> Status Resep</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="pending">Pending</option>
                            <option value="approved">Disetujui</option>
                            <option value="rejected">Ditolak</option>
                        </select>
                        <small class="form-text">Pilih status resep.</small>
                    </div>
                    <!-- Komentar Editor -->
                    <div class="mb-4">
                        <label for="editor_comment" class="form-label"><i class="bi bi-pencil"></i> Komentar Editor</label>
                        <textarea class="form-control" id="editor_comment" name="editor_comment" rows="3" placeholder="Tulis komentar atau catatan tambahan untuk resep ini..."></textarea>
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
