@extends('layouts.admin')
@section('title', 'Tambah Berita')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Tambah Berita</h5>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="judul" class="form-label">Judul</label>
                <input type="text" name="judul" id="judul" class="form-control" value="{{ old('judul') }}" required>
            </div>

            <div class="mb-3">
                <label for="konten" class="form-label">Konten</label>
                <textarea name="konten" id="konten" class="form-control" rows="6" required>{{ old('konten') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="gambar" class="form-label">Thumbnail Gambar</label>
                <input type="file" name="gambar" id="gambar" class="form-control">
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Publish</option>
                </select>
            </div>

            <div class="form-group">
                <label for="category">Kategori</label>
                <select name="category" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
