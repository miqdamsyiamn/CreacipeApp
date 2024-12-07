@extends('layout.dashboard')

@section('title', 'Kelola Member')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Kelola Member</h1>

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

    <!-- Daftar Member -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Daftar Member</h5>
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
                    @forelse($members as $member)
                    <tr>
                        <td>{{ $member->name }}</td>
                        <td>{{ $member->email }}</td>
                        <td>
                            <span class="badge {{ $member->status->name == 'Aktif' ? 'bg-success' : 'bg-danger' }}">
                                {{ $member->status->name }}
                            </span>
                        </td>
                        <td>
                            <!-- Aktifkan/Nonaktifkan -->
                            <form action="{{ route('admin.members.toggle', $member->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-warning btn-sm">
                                    {{ $member->status->name == 'Aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>

                            <!-- Hapus Member -->
                            <form action="{{ route('admin.members.delete', $member->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada Member.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginasi -->
    <div class="d-flex justify-content-center mt-4">
        {{ $members->links() }}
    </div>
</div>
@endsection
