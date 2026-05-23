@extends('layouts.admin')

@section('title', 'Admin')
@section('page-title', 'Manajemen Admin')
@section('breadcrumb', 'Admin Panel / Admin')

@section('content')
    <div class="d-flex align-center justify-between mb-3">
        <div>
            <h2 style="font-size:1.5rem;font-weight:800;color:var(--text)">Daftar Admin</h2>
            <p class="text-muted mt-1">{{ $admins->total() }} admin terdaftar</p>
        </div>
        <a href="{{ route('admin.admin-users.create') }}" class="btn btn-primary">
            <i class="fas fa-user-plus"></i> Tambah Admin
        </a>
    </div>

    <div class="card">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Dibuat</th>
                        <th style="width:180px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($admins as $admin)
                        <tr>
                            <td>
                                <div style="font-weight:700;color:var(--text)">{{ $admin->name }}</div>
                                <div class="text-sm text-muted">{{ $admin->events_count ?? $admin->events()->count() }} event</div>
                            </td>
                            <td>{{ $admin->email }}</td>
                            <td class="text-muted text-sm">{{ $admin->created_at?->format('d M Y H:i') }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.admin-users.edit', $admin) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.admin-users.destroy', $admin) }}" method="POST"
                                        onsubmit="return confirm('Hapus admin ini? Event yang dibuat admin ini tidak ikut terhapus, tetapi tidak lagi memiliki pemilik.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted" style="padding:2rem">
                                Belum ada admin tambahan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $admins->links() }}
    </div>
@endsection
