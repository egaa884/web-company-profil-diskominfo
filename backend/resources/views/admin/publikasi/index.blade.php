@extends('layouts.admin')

@section('title', 'Manajemen Publikasi')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Publikasi</h1>
        <a href="{{ route('admin.publikasi.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Publikasi
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Publikasi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Tanggal Publikasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($publikasis as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->judul }}</td>
                            <td>
                                @switch($item->kategori)
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
                                        <span class="badge bg-secondary">{{ $item->kategori }}</span>
                                @endswitch
                            </td>
                            <td>
                                @if($item->is_published)
                                    <span class="badge bg-success">Dipublikasi</span>
                                @else
                                    <span class="badge bg-secondary">Draft</span>
                                @endif
                            </td>
                            <td>{{ $item->published_at ? $item->published_at->format('d/m/Y H:i') : '-' }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.publikasi.show', $item->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.publikasi.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.publikasi.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus publikasi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data publikasi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($publikasis->hasPages())
                <div class="d-flex justify-content-center">
                    {{ $publikasis->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "pageLength": 10,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            }
        });
    });
</script>
@endpush


