@extends('layouts.admin')

@section('title', 'Edit Berita')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Edit Berita</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') <!-- Menandakan permintaan PUT untuk update -->
                

                <div class="form-group">
                    <label for="judul">Judul</label>
                    <input type="text" name="judul" class="form-control" value="{{ old('judul', $berita->judul) }}">
                </div>

                <div class="form-group">
                    <label for="konten">Konten</label>
                    <textarea name="konten" class="form-control">{{ old('konten', $berita->konten) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control">
                        <option value="draft" {{ $berita->status == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ $berita->status == 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="category">Kategori</label>
                    <select name="category" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat }}" {{ (old('category', $berita->category) == $cat) ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="gambar">Gambar</label>
                    <input type="file" name="gambar" class="form-control">
                    @if ($berita->gambar)
                        <img src="{{ asset('storage/' . $berita->gambar) }}" width="150">
                    @endif
                </div>

                <button type="submit" class="btn btn-primary mt-3">Update</button>
            </form>
        </div>
    </div>
@endsection
