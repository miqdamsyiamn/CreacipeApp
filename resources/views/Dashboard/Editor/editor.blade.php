@extends('layout.editor')

@section('title', 'Dashboard Editor')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Dashboard Editor</h1>
    <p class="text-center">Selamat datang di dashboard editor. Anda dapat mengelola resep di sini.</p>
    <div class="text-center">
        <a href="{{ route('editor.recipes.index') }}" class="btn btn-primary">Kelola Resep</a>
        <a href="{{ route('dashboard.editor.recipes.index') }}" class="btn btn-secondary">Lihat Semua Resep</a>
    </div>
</div>
@endsection
