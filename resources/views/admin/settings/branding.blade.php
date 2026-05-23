@extends('layouts.admin')

@section('title', 'Branding Website')
@section('page-title', 'Branding Website')
@section('breadcrumb', 'Admin Panel / Pengaturan / Branding')

@section('content')
    <form action="{{ route('admin.settings.branding.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">Logo & Favicon</div>
                    <div class="text-muted mt-1">Atur identitas visual yang tampil di website, login, dan admin panel.</div>
                </div>
            </div>
            <div class="card-body">
                <div class="form-row cols-2">
                    <div class="form-group">
                        <label class="form-label">Logo Website</label>
                        @if($siteLogoUrl)
                            <div class="mb-1">
                                <img src="{{ $siteLogoUrl }}" alt="Logo website" style="max-height:70px;max-width:220px;border:1px solid var(--border);border-radius:8px;padding:.5rem;background:#fff">
                            </div>
                        @endif
                        <input type="file" name="site_logo" class="form-control" accept="image/*">
                        <div class="text-muted mt-1">Format JPG, PNG, WEBP, atau SVG. Maksimal 2 MB.</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Favicon</label>
                        @if($siteFaviconUrl)
                            <div class="mb-1">
                                <img src="{{ $siteFaviconUrl }}" alt="Favicon" style="width:54px;height:54px;object-fit:contain;border:1px solid var(--border);border-radius:8px;padding:.45rem;background:#fff">
                            </div>
                        @endif
                        <input type="file" name="site_favicon" class="form-control" accept="image/*,.ico">
                        <div class="text-muted mt-1">Format ICO, PNG, JPG, WEBP, atau SVG. Maksimal 1 MB.</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-between align-center mt-3">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline btn-lg">Batal</a>
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-save"></i> Simpan Branding
            </button>
        </div>
    </form>
@endsection
