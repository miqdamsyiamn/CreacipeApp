<!-- resources/views/profile/showprofile.blade.php -->
@extends('layout.profile')

@section('title', 'Profil Saya')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <div class="card">
                <div class="card-body text-center">
                    <!-- Foto Profil -->
                    <img src="{{ $user->profile_picture && file_exists(public_path($user->profile_picture)) 
                                ? asset($user->profile_picture) 
                                : asset('assets/profil/profil.jpg') }}"
                        alt="Foto Profil"
                        class="rounded-circle mb-4 border border-3 border-primary"
                        style="width: 150px; height: 150px; object-fit: cover;">
                    <!-- Nama -->
                    <h3>{{ $user->name }}</h3>
                    <!-- Bio -->
                    <p class="text-muted">{{ $user->bio ?? 'Belum ada bio.' }}</p>
                    <!-- Tombol Edit -->
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                        <i class="bi bi-pencil-square"></i> Edit Profil
                    </a>
                    <!-- Tombol Ubah Password -->
                    <a href="{{ route('password.change') }}" class="btn btn-warning">
                        <i class="bi bi-lock"></i> Ubah Password
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection