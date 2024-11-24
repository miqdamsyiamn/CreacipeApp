@extends('layout.dashboard')

@section('title', 'Kelola Editor')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Kelola Editor</h1>

    <!-- Notifikasi Sukses -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Validasi Error -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Tambah Editor -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Tambah Editor</h5>
            <form action="{{ route('admin.editors.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>
                <button type="submit" class="btn btn-primary">Tambah Editor</button>
            </form>
        </div>
    </div>

    <!-- Daftar Editor -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Daftar Editor</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($editors as $editor)
                    <tr>
                        <td>{{ $editor->name }}</td>
                        <td>{{ $editor->email }}</td>
                        <td>
                            <span class="badge {{ $editor->status->name == 'Aktif' ? 'bg-success' : 'bg-danger' }}">
                                {{ $editor->status->name }}
                            </span>
                        </td>
                        <td>
                            <!-- Aktifkan/Nonaktifkan -->
                            <form action="{{ route('admin.editors.toggle', $editor->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-warning btn-sm">
                                    {{ $editor->status->name == 'Aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>

                            <!-- Hapus Editor -->
                            <form action="{{ route('admin.editors.delete', $editor->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada editor.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginasi -->
    <div class="d-flex justify-content-center mt-4">
        {{ $editors->links() }}
    </div>
</div>
@endsection
