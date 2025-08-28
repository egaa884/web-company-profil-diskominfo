@extends('layouts.admin')
@section('title', 'Daftar Laporan Pengaduan Admin')

@section('content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">Total Laporan</h4>
                            <h2 class="mb-0">{{ $statistics['total'] }}</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-file-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">Dipublikasi</h4>
                            <h2 class="mb-0">{{ $statistics['published'] }}</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">Draft</h4>
                            <h2 class="mb-0">{{ $statistics['draft'] }}</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-edit fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">Tahun Ini</h4>
                            <h2 class="mb-0">{{ $statistics['this_year'] }}</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-calendar-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Daftar Laporan Pengaduan Admin</h2>
                <a href="{{ route('admin.laporan-pengaduan-admin.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Buat Laporan Baru
                </a>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Data Table -->
    <div class="card">
        <div class="card-body">
            @if($laporanPengaduan->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Periode</th>
                                <th>Total Pengaduan</th>
                                <th>Status</th>
                                <th>Admin</th>
                                <th>Tanggal Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($laporanPengaduan as $index => $laporan)
                                <tr>
                                    <td>{{ $index + 1 + ($laporanPengaduan->currentPage() - 1) * $laporanPengaduan->perPage() }}</td>
                                    <td>
                                        <strong>{{ Str::limit($laporan->judul, 60) }}</strong>
                                        @if($laporan->file_lampiran)
                                            <i class="fas fa-paperclip text-muted ms-1" title="Ada lampiran"></i>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $laporan->bulan }} {{ $laporan->tahun }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <small>Total: {{ $laporan->total_pengaduan }}</small>
                                            <small>Selesai: {{ $laporan->pengaduan_selesai }}</small>
                                            <small>Diproses: {{ $laporan->pengaduan_diproses }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $laporan->published_color }}">
                                            {{ $laporan->published_label }}
                                        </span>
                                    </td>
                                    <td>
                                        <div>{{ $laporan->admin->name ?? 'N/A' }}</div>
                                        <small class="text-muted">{{ $laporan->admin->email ?? 'N/A' }}</small>
                                    </td>
                                    <td>
                                        <div>{{ $laporan->created_at->format('d/m/Y') }}</div>
                                        <small class="text-muted">{{ $laporan->created_at->format('H:i') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.laporan-pengaduan-admin.show', $laporan->id) }}" 
                                               class="btn btn-sm btn-info" title="Lihat">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.laporan-pengaduan-admin.edit', $laporan->id) }}" 
                                               class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if($laporan->file_lampiran)
                                                <a href="{{ route('admin.laporan-pengaduan-admin.download', $laporan->id) }}" 
                                                   class="btn btn-sm btn-success" title="Download File">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            @endif
                                            <form action="{{ route('admin.laporan-pengaduan-admin.toggle-publish', $laporan->id) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-{{ $laporan->is_published ? 'secondary' : 'primary' }}" 
                                                        title="{{ $laporan->is_published ? 'Unpublish' : 'Publish' }}">
                                                    <i class="fas fa-{{ $laporan->is_published ? 'eye-slash' : 'eye' }}"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.laporan-pengaduan-admin.destroy', $laporan->id) }}" 
                                                  method="POST" class="d-inline" 
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada data laporan pengaduan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $laporanPengaduan->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada laporan pengaduan</h5>
                    <p class="text-muted">Mulai dengan membuat laporan pengaduan baru</p>
                    <a href="{{ route('admin.laporan-pengaduan-admin.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Buat Laporan Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
