<!-- resources/views/layout/recipe-modal.blade.php -->
@foreach($approvedRecipes as $recipe)
<div class="modal fade" id="recipeModal{{ $recipe->recipe_id }}" tabindex="-1" aria-labelledby="recipeModalLabel{{ $recipe->recipe_id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="recipeModalLabel{{ $recipe->recipe_id }}">{{ $recipe->title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Bagian Gambar Resep -->
                    <div class="col-md-5">
                        <img src="{{ asset($recipe->image ?? 'https://via.placeholder.com/600x400') }}"
                            class="img-fluid rounded" alt="{{ $recipe->title }}"
                            style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <!-- Bagian Informasi Resep -->
                    <div class="col-md-7">
                        <h4>Deskripsi</h4>
                        <p>{{ $recipe->description ?? 'Tidak ada deskripsi.' }}</p>
                        <h4>Bahan-bahan</h4>
                        <ul class="step-list">
                            @foreach(json_decode($recipe->ingredients) as $ingredient)
                            <li>{{ $ingredient }}</li>
                            @endforeach
                        </ul>
                        <h4>Langkah-langkah</h4>
                        <ol class="step-list">
                            @foreach(json_decode($recipe->steps) as $step)
                            <li>{{ $step }}</li>
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach