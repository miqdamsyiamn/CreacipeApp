@extends('layout.editor')

@section('title', 'Dashboard Editor')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Dashboard Editor</h1>
    <p class="text-center">Selamat datang di dashboard editor. Anda dapat mengelola resep di sini.</p>
    <div class="text-center">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRecipeModalEditor">Tambah Resep</button>
        <button class="btn btn-secondary">Lihat Semua Resep</button>
    </div>
</div>
@endsection
