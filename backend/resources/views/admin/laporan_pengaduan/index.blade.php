@extends('layouts.admin')

@section('title', 'Laporan Pengaduan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Laporan Pengaduan</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.laporan-pengaduan.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Laporan
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filter Section -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <select class="form-control" id="status-filter">
                                <option value="">Semua Status</option>
                                <option value="pending">Menunggu</option>
                                <option value="diproses">Diproses</option>
                                <option value="selesai">Selesai</option>
                                <option value="ditolak">Ditolak</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" id="prioritas-filter">
                                <option value="">Semua Prioritas</option>
                                <option value="rendah">Rendah</option>
                                <option value="normal">Normal</option>
                                <option value="tinggi">Tinggi</option>
                                <option value="kritis">Kritis</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="search-input" placeholder="Cari judul, nama pelapor, atau kategori...">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-secondary btn-block" onclick="applyFilters()">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Pelapor</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                    <th>Prioritas</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($laporanPengaduan as $index => $laporan)
                                <tr>
                                    <td>{{ $index + 1 + ($laporanPengaduan->currentPage() - 1) * $laporanPengaduan->perPage() }}</td>
                                    <td>
                                        <strong>{{ $laporan->judul }}</strong>
                                        @if($laporan->file_lampiran)
                                            <br><small class="text-muted"><i class="fas fa-paperclip"></i> Ada lampiran</small>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $laporan->nama_pelapor }}<br>
                                        <small class="text-muted">{{ $laporan->email_pelapor }}</small>
                                    </td>
                                    <td>{{ $laporan->kategori_pengaduan }}</td>
                                    <td>
                                        <span class="badge badge-{{ $laporan->status_color }}">
                                            {{ $laporan->status_label }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $laporan->priority_color }}">
                                            {{ $laporan->priority_label }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $laporan->tanggal_pengaduan->format('d/m/Y H:i') }}
                                        @if($laporan->tanggal_selesai)
                                            <br><small class="text-success">Selesai: {{ $laporan->tanggal_selesai->format('d/m/Y') }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.laporan-pengaduan.show', $laporan->id) }}" 
                                               class="btn btn-info btn-sm" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.laporan-pengaduan.edit', $laporan->id) }}" 
                                               class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if($laporan->file_lampiran)
                                                <a href="{{ route('admin.laporan-pengaduan.download', $laporan->id) }}" 
                                                   class="btn btn-success btn-sm" title="Download">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            @endif
                                            <button type="button" class="btn btn-danger btn-sm" 
                                                    onclick="deleteLaporan({{ $laporan->id }})" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
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
                    <div class="d-flex justify-content-center">
                        {{ $laporanPengaduan->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus laporan pengaduan ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function applyFilters() {
    const status = document.getElementById('status-filter').value;
    const prioritas = document.getElementById('prioritas-filter').value;
    const search = document.getElementById('search-input').value;
    
    let url = new URL(window.location);
    
    if (status) url.searchParams.set('status', status);
    else url.searchParams.delete('status');
    
    if (prioritas) url.searchParams.set('prioritas', prioritas);
    else url.searchParams.delete('prioritas');
    
    if (search) url.searchParams.set('search', search);
    else url.searchParams.delete('search');
    
    window.location.href = url.toString();
}

function deleteLaporan(id) {
    if (confirm('Apakah Anda yakin ingin menghapus laporan pengaduan ini?')) {
        const form = document.getElementById('deleteForm');
        form.action = `/admin/laporan-pengaduan/${id}`;
        form.submit();
    }
}

// Set filter values from URL params
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    
    if (urlParams.get('status')) {
        document.getElementById('status-filter').value = urlParams.get('status');
    }
    
    if (urlParams.get('prioritas')) {
        document.getElementById('prioritas-filter').value = urlParams.get('prioritas');
    }
    
    if (urlParams.get('search')) {
        document.getElementById('search-input').value = urlParams.get('search');
    }
});
</script>
@endpush
