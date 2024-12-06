@extends('layout.editor')

@section('title', 'Kelola Resep')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Kelola Resep</h1>

    <!-- Notifikasi -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabel Kelola Resep -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Daftar Resep</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recipes as $recipe)
                        <tr>
                            <!-- Judul Resep -->
                            <td>{{ $recipe->title }}</td>
                            <!-- Nama Member -->
                            <td>{{ $recipe->user->name }}</td>
                            <!-- Status Resep -->
                            <td>
                                <span class="badge 
                                    {{ $recipe->status_id == 1 ? 'bg-warning' : ($recipe->status_id == 2 ? 'bg-success' : 'bg-danger') }}">
                                    {{ $recipe->status->name }}
                                </span>
                            </td>
                            <!-- Aksi -->
                            <td>
                                <!-- Tombol Approve -->
                                <form action="{{ route('editor.recipes.approve', $recipe->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                </form>

                                <!-- Tombol Decline -->
                                <form action="{{ route('editor.recipes.decline', $recipe->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-danger btn-sm">Decline</button>
                                </form>

                                <!-- Tombol Delete -->
                                <form action="{{ route('editor.recipes.delete', $recipe->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-dark btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada resep untuk dikelola.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginasi -->
    <div class="d-flex justify-content-center mt-4">
        {{ $recipes->links() }}
    </div>
</div>
@endsection
