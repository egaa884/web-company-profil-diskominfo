@extends('layouts.admin')

@section('title', 'Detail Publikasi')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Publikasi</h1>
        <div>
            <a href="{{ route('admin.publikasi.edit', $publikasi->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.publikasi.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Publikasi</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong>Judul:</strong>
                        </div>
                        <div class="col-md-9">
                            {{ $publikasi->judul }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong>Kategori:</strong>
                        </div>
                        <div class="col-md-9">
                            @switch($publikasi->kategori)
                                @case('pengaduan')
                                    <span class="badge bg-primary">Laporan Pengaduan</span>
                                    @break
                                @case('penerima')
                                    <span class="badge bg-success">Laporan Penerimaan</span>
                                    @break
                                @case('surveikepuasan')
                                    <span class="badge bg-info">Survei Kepuasan</span>
                                    @break
                                @case('surveievaluasi')
                                    <span class="badge bg-warning">Survei Evaluasi</span>
                                    @break
                                @default
                                    <span class="badge bg-secondary">{{ $publikasi->kategori }}</span>
                            @endswitch
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong>Slug:</strong>
                        </div>
                        <div class="col-md-9">
                            <code>{{ $publikasi->slug }}</code>
                        </div>
                    </div>

                    @if($publikasi->ringkasan)
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong>Ringkasan:</strong>
                        </div>
                        <div class="col-md-9">
                            {{ $publikasi->ringkasan }}
                        </div>
                    </div>
                    @endif

                    @if($publikasi->isi)
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong>Isi Lengkap:</strong>
                        </div>
                        <div class="col-md-9">
                            <div class="border p-3 bg-light rounded">
                                {!! nl2br(e($publikasi->isi)) !!}
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($publikasi->file_path)
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong>File:</strong>
                        </div>
                        <div class="col-md-9">
                            <a href="{{ $publikasi->file_path }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-external-link-alt"></i> Lihat File
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Status & Metadata</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Status Publikasi:</strong><br>
                        @if($publikasi->is_published)
                            <span class="badge bg-success">Dipublikasi</span>
                        @else
                            <span class="badge bg-secondary">Draft</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <strong>Tanggal Publikasi:</strong><br>
                        @if($publikasi->published_at)
                            {{ $publikasi->published_at->format('d/m/Y H:i') }}
                        @else
                            <span class="text-muted">Belum dipublikasi</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <strong>Dibuat:</strong><br>
                        {{ $publikasi->created_at->format('d/m/Y H:i') }}
                    </div>

                    <div class="mb-3">
                        <strong>Diperbarui:</strong><br>
                        {{ $publikasi->updated_at->format('d/m/Y H:i') }}
                    </div>

                    @if($publikasi->meta)
                    <div class="mb-3">
                        <strong>Metadata:</strong><br>
                        <div class="border p-2 bg-light rounded">
                            <pre class="mb-0"><code>{{ json_encode($publikasi->meta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.publikasi.edit', $publikasi->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Publikasi
                        </a>
                        
                        <form action="{{ route('admin.publikasi.destroy', $publikasi->id) }}" method="POST" 
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus publikasi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash"></i> Hapus Publikasi
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


