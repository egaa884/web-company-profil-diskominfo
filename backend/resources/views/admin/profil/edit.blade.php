@extends('layouts.admin')
@section('title', 'Edit Profil')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Edit Profil</h4>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('admin.profil.update', $profil->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="kategori" class="form-label">Kategori</label>
                    <select name="kategori" id="kategori" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $key => $value)
                            <option value="{{ $key }}" {{ old('kategori', $profil->kategori) == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="konten" class="form-label">Konten</label>
                    <textarea name="konten" id="konten" class="form-control" rows="7">{{ old('konten', $profil->konten) }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="gambar" class="form-label">Upload Gambar (opsional)</label>
                    @if($profil->gambar)
                        <div class="mb-2">
                            <p class="text-muted">Gambar saat ini:</p>
                            <img src="{{ asset('storage/' . $profil->gambar) }}" alt="Gambar saat ini" class="img-thumbnail" style="max-width: 200px;">
                        </div>
                    @endif
                    <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
                    <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                </div>
                <div class="mb-3">
                    <label for="pdf" class="form-label">Upload PDF (opsional)</label>
                    @if($profil->pdf)
                        <div class="mb-2">
                            <p class="text-muted">PDF saat ini:</p>
                            <a href="{{ asset('storage/' . $profil->pdf) }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat PDF</a>
                        </div>
                    @endif
                    <input type="file" name="pdf" id="pdf" class="form-control" accept="application/pdf">
                    <small class="text-muted">Format: PDF. Maksimal 2MB</small>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.profil.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection 