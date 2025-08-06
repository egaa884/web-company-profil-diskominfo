@extends('layouts.admin')
@section('title', $berita->judul ?? 'Detail Berita')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>{{ $berita->judul ?? 'Judul Berita' }}</h2>
                </div>
                <div class="card-body">
                    @if ($berita->gambar)
                        <img src="{{ Storage::url($berita->gambar) }}" class="img-fluid mb-3" alt="{{ $berita->judul }}" style="max-width: 100%; height: auto;">
                    @endif
                    
                    <div class="mb-3">
                        <strong>Kategori:</strong> {{ $berita->category }}
                    </div>
                    
                    <div class="mb-3">
                        {!! $berita->konten ?? 'Konten tidak tersedia' !!}
                    </div>
                    
                    <div class="text-muted">
                        <small>
                            <strong>Status:</strong> {{ ucfirst($berita->status ?? 'draft') }}<br>
                            @if ($berita->published_at)
                                <strong>Dipublikasikan pada:</strong> {{ $berita->published_at->format('d M Y H:i') }}
                            @endif
                        </small>
                    </div>
                    
                    <div class="mt-3">
                        <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">Kembali ke Daftar Berita</a>
                        <a href="{{ route('admin.berita.edit', $berita) }}" class="btn btn-warning">Edit Berita</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .container {
        padding: 20px;
    }
    .card {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    }
    .card-header {
        background-color: #2d2f6e;
        color: white;
        padding: 15px;
    }
    .card-body {
        padding: 20px;
    }
    .btn {
        margin-right: 10px;
    }
</style>
@endsection