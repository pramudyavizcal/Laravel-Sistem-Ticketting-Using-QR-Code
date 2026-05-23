@extends('layouts.admin')

@section('title', 'Edit Admin')
@section('page-title', 'Edit Admin')
@section('breadcrumb', 'Admin Panel / Admin / Edit')

@section('content')
    <form action="{{ route('admin.admin-users.update', $adminUser) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-header">
                <div class="card-title">Data Admin</div>
            </div>
            <div class="card-body">
                <div class="form-row cols-2">
                    <div class="form-group">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $adminUser->name) }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $adminUser->email) }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password Baru</label>
                        <input type="password" name="password" class="form-control">
                        <div class="text-muted mt-1">Kosongkan jika tidak ingin mengubah password.</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-between align-center mt-3">
            <a href="{{ route('admin.admin-users.index') }}" class="btn btn-outline btn-lg">Batal</a>
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
        </div>
    </form>
@endsection
