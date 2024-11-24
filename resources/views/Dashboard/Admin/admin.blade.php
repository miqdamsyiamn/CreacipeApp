@extends('layout.dashboard')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Dashboard Admin</h1>
    <div class="row">
        <!-- Card untuk Mengelola Editor -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Kelola Editor</h5>
                    <p class="card-text">Tambahkan atau hapus editor, dan aktifkan status mereka.</p>
                    <a href="{{ route('admin.editors') }}" class="btn btn-primary">Kelola Editor</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <!-- Card untuk Mengelola Member -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Kelola Member</h5>
                    <p class="card-text">Aktifkan atau nonaktifkan member sesuai kebutuhan.</p>
                    <a href="" class="btn btn-primary">Kelola Member</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
