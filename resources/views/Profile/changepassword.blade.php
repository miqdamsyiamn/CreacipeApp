@extends('layout.profile')

@section('title', 'Ubah Password')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h3 class="mb-4">Ubah Password</h3>
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <!-- Password Saat Ini -->
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Password Saat Ini</label>
                            <input type="password" id="current_password" name="current_password" class="form-control" required>
                        </div>

                        <!-- Password Baru -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="d-flex justify-content-start mt-4">
                            <button type="submit" class="btn btn-primary me-2">Simpan</button>
                            <a href="{{ route('profile.showprofile') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
