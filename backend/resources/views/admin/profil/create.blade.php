@extends('layouts.admin')
@section('title', 'Tambah Profil')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Tambah Profil</h4>
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
            <form action="{{ route('admin.profil.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="kategori" class="form-label">Kategori</label>
                    <select name="kategori" id="kategori" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ old('kategori') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="konten" class="form-label">Konten</label>
                    <textarea name="konten" id="konten" class="form-control" rows="7">{{ old('konten') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="gambar" class="form-label">Upload Gambar (opsional)</label>
                    <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
                    <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                </div>
                <div class="mb-3">
                    <label for="pdf" class="form-label">Upload PDF (opsional)</label>
                    <input type="file" name="pdf" id="pdf" class="form-control" accept="application/pdf">
                    <small class="text-muted">Format: PDF. Maksimal 2MB</small>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.profil.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection 