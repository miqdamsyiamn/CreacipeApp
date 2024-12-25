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

    <!-- notif untuk search -->
    @if(isset($message))
    <div class="alert alert-info">{{ $message }}</div>
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
                        <th>Created Date</th>
                        <th>Approved Date</th>
                        <th>Declined Date</th>
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
                        <!-- Tanggal Dibuat -->
                        <td>{{ $recipe->created_at->format('d F Y H:i') }}</td>
                        <!-- Tanggal Approved -->
                        <td>
                            {{ $recipe->accepted_date ? \Carbon\Carbon::parse($recipe->accepted_date)->format('d F Y H:i') : '-' }}
                        </td>
                        <!-- Tanggal Declined -->
                        <td>
                            {{ $recipe->declined_date ? \Carbon\Carbon::parse($recipe->declined_date)->format('d F Y H:i') : '-' }}
                        </td>
                        <!-- Status Resep -->
                        <td>
                            <span class="badge 
                    {{ $recipe->status_recipes_id == 1 ? 'bg-warning' : ($recipe->status_recipes_id == 2 ? 'bg-success' : 'bg-danger') }}">
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

                            <!-- Tombol Decline dengan Modal -->
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#declineModal{{ $recipe->id }}">Decline</button>

                            <!-- Modal Decline -->
                            <div class="modal fade" id="declineModal{{ $recipe->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('editor.recipes.decline', $recipe->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Alasan Penolakan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <textarea name="decline_reason" class="form-control" placeholder="Masukkan alasan singkat..." required></textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-danger">Kirim</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Tombol Delete -->
                            <form action="{{ route('editor.recipes.delete', $recipe->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-dark btn-sm mt-1">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada resep untuk dikelola.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!-- Paginasi -->
    <div class="d-flex justify-content-center mt-4">
        {{ $recipes->links('pagination::simple-bootstrap-4') }}
    </div>
</div>
@endsection