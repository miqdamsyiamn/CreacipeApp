<!-- resources/views/profile/showprofile.blade.php -->
@extends('layout.profile')

@section('title', 'Profil Saya')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body text-center">
                    <!-- Foto Profil -->
                    <img src="{{ $user->profile_picture ? asset($user->profile_picture) : asset('assets/default-profile.png') }}" 
     alt="Foto Profil" 
     class="rounded-circle mb-4" 
     style="width: 150px; height: 150px; object-fit: cover;">

                    
                    <!-- Nama -->
                    <h3>{{ $user->name }}</h3>
                    
                    <!-- Bio -->
                    <p class="text-muted">{{ $user->bio ?? 'Belum ada bio.' }}</p>
                    
                    <!-- Tombol Edit -->
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                        <i class="bi bi-pencil-square"></i> Edit Profil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
