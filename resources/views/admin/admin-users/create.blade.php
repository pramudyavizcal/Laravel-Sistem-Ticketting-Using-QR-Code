@extends('layouts.admin')

@section('title', 'Tambah Admin')
@section('page-title', 'Tambah Admin')
@section('breadcrumb', 'Admin Panel / Admin / Tambah')

@section('content')
    <form action="{{ route('admin.admin-users.store') }}" method="POST">
        @csrf

        <div class="card">
            <div class="card-header">
                <div class="card-title">Akun Admin Baru</div>
            </div>
            <div class="card-body">
                <div class="form-row cols-2">
                    <div class="form-group">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>
                <div class="alert alert-info" style="margin-bottom:0">
                    <i class="fas fa-info-circle"></i>
                    Admin ini hanya dapat mengakses event, peserta, QR scanner, dan log scan untuk event yang dibuat sendiri.
                </div>
            </div>
        </div>

        <div class="d-flex justify-between align-center mt-3">
            <a href="{{ route('admin.admin-users.index') }}" class="btn btn-outline btn-lg">Batal</a>
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-save"></i> Simpan Admin
            </button>
        </div>
    </form>
@endsection
