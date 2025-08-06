@extends('layouts.admin')

@section('title', 'Edit Infografis')

@section('content')
    <div class="container my-5">
        <h2 class="text-center mb-4">Edit Infografis</h2>

        <form action="{{ route('admin.infografis.update', $infografis) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="judul" class="form-label">Judul</label>
                <input type="text" name="judul" class="form-control" value="{{ old('judul', $infografis->judul) }}" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" required>{{ old('deskripsi', $infografis->deskripsi) }}</textarea>
            </div>
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
             <input type="date" name="tanggal" class="form-control" value="{{ $infografis->tanggal->format('Y-m-d') }}" required>


            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar</label>
                <input type="file" name="gambar" class="form-control">
                @if ($infografis->gambar)
                    <img src="{{ asset('storage/' . $infografis->gambar) }}" class="img-fluid mt-3" width="100%">
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
