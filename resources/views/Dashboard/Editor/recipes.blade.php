@extends('layout.dashboard')

@section('title', 'Kelola Resep')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Kelola Resep</h1>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Judul</th>
                <th>Dibuat oleh</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recipes as $recipe)
            <tr>
                <td>{{ $recipe->id }}</td>
                <td>{{ $recipe->title }}</td>
                <td>{{ $recipe->user->name }}</td>
                <td>{{ ucfirst($recipe->status) }}</td>
                <td>
                    <form action="{{ route('editor.recipes.approve', $recipe->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success btn-sm">Approve</button>
                    </form>
                    <form action="{{ route('editor.recipes.decline', $recipe->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-warning btn-sm">Decline</button>
                    </form>
                    <form action="{{ route('editor.recipes.delete', $recipe->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
