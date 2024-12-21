<!-- resources/views/profile/edit.blade.php -->
@extends('layout.profile')

@section('title', 'Edit Profil')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h3 class="mb-4">Edit Profil</h3>
                    
                    <!-- Form Edit Profil -->
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Nama -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" name="name" id="name" 
                                   class="form-control" 
                                   value="{{ old('name', $user->name) }}" 
                                   required>
                        </div>
                        
                        <!-- Foto Profil -->
                        <div class="mb-3">
                            <label for="profile_photo" class="form-label">Foto Profil</label>
                            <input type="file" name="profile_picture" id="profile_picture" 
                                   class="form-control" 
                                   accept="image/*">
                            @if($user->profile_picture_url)
                                <small class="form-text text-muted">Foto saat ini: 
                                    <img src="{{ $user->profile_picture_url }}" 
                                         alt="Foto Profil" 
                                         style="width: 50px; height: 50px; object-fit: cover;">
                                </small>
                            @endif
                        </div>
                        
                        <!-- Bio -->
                        <div class="mb-3">
                            <label for="bio" class="form-label">Bio</label>
                            <textarea name="bio" id="bio" 
                                      class="form-control" 
                                      rows="3">{{ old('bio', $user->bio) }}</textarea>
                        </div>
                        
                        <!-- Tombol Simpan -->
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
