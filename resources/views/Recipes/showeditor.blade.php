@foreach($recipes as $recipe)
    <div class="modal fade" id="recipeModal{{ $recipe->id }}" tabindex="-1" aria-labelledby="recipeModalLabel{{ $recipe->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="recipeModalLabel{{ $recipe->id }}">{{ $recipe->title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <img src="{{ asset($recipe->image ?? 'https://via.placeholder.com/600x400') }}" 
                            class="img-fluid rounded" alt="{{ $recipe->title }}">
                    </div>
                    <h4>Deskripsi</h4>
                    <p>{{ $recipe->description ?? 'Tidak ada deskripsi.' }}</p>

                    <h4>Bahan-bahan</h4>
                    <ul>
                        @foreach(json_decode($recipe->ingredients) as $ingredient)
                            <li>{{ $ingredient }}</li>
                        @endforeach
                    </ul>

                    <h4>Langkah-langkah</h4>
                    <ol>
                        @foreach(json_decode($recipe->steps) as $step)
                            <li>{{ $step }}</li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endforeach
