@extends('layouts.admin')

@section('title', 'Detail Laporan Pengaduan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Laporan Pengaduan</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.laporan-pengaduan.edit', $laporanPengaduan->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.laporan-pengaduan.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Informasi Pengaduan -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Informasi Pengaduan</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td><strong>Judul:</strong></td>
                                                    <td>{{ $laporanPengaduan->judul }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Kategori:</strong></td>
                                                    <td>{{ $laporanPengaduan->kategori_pengaduan }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Status:</strong></td>
                                                    <td>
                                                        <span class="badge badge-{{ $laporanPengaduan->status_color }}">
                                                            {{ $laporanPengaduan->status_label }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Prioritas:</strong></td>
                                                    <td>
                                                        <span class="badge badge-{{ $laporanPengaduan->priority_color }}">
                                                            {{ $laporanPengaduan->priority_label }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Tanggal Pengaduan:</strong></td>
                                                    <td>{{ $laporanPengaduan->tanggal_pengaduan->format('d/m/Y H:i') }}</td>
                                                </tr>
                                                @if($laporanPengaduan->tanggal_selesai)
                                                <tr>
                                                    <td><strong>Tanggal Selesai:</strong></td>
                                                    <td>{{ $laporanPengaduan->tanggal_selesai->format('d/m/Y H:i') }}</td>
                                                </tr>
                                                @endif
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td><strong>Nama Pelapor:</strong></td>
                                                    <td>{{ $laporanPengaduan->nama_pelapor }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Email:</strong></td>
                                                    <td>{{ $laporanPengaduan->email_pelapor }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Telepon:</strong></td>
                                                    <td>{{ $laporanPengaduan->telepon_pelapor }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>NIK:</strong></td>
                                                    <td>{{ $laporanPengaduan->nik_pelapor }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Admin:</strong></td>
                                                    <td>{{ $laporanPengaduan->admin->name ?? 'Tidak ada' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <h6><strong>Alamat Pelapor:</strong></h6>
                                            <p>{{ $laporanPengaduan->alamat_pelapor }}</p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <h6><strong>Deskripsi Pengaduan:</strong></h6>
                                            <p>{{ $laporanPengaduan->deskripsi }}</p>
                                        </div>
                                    </div>

                                    @if($laporanPengaduan->catatan_admin)
                                    <div class="row">
                                        <div class="col-12">
                                            <h6><strong>Catatan Admin:</strong></h6>
                                            <p>{{ $laporanPengaduan->catatan_admin }}</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <!-- File Lampiran -->
                            @if($laporanPengaduan->file_lampiran)
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">File Lampiran</h5>
                                </div>
                                <div class="card-body">
                                    <div class="text-center">
                                        @if(in_array(strtolower(pathinfo($laporanPengaduan->file_lampiran, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif']))
                                            <img src="{{ $laporanPengaduan->file_url }}" class="img-fluid mb-3" alt="Lampiran">
                                        @else
                                            <i class="fas fa-file-pdf fa-3x text-danger mb-3"></i>
                                        @endif
                                        <p><strong>{{ $laporanPengaduan->file_name }}</strong></p>
                                        <a href="{{ route('admin.laporan-pengaduan.download', $laporanPengaduan->id) }}" 
                                           class="btn btn-success btn-sm">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Update Status -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Update Status</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.laporan-pengaduan.update-status', $laporanPengaduan->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-control" id="status" name="status" required>
                                                <option value="pending" {{ $laporanPengaduan->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                                <option value="diproses" {{ $laporanPengaduan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                                <option value="selesai" {{ $laporanPengaduan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                                <option value="ditolak" {{ $laporanPengaduan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="catatan_admin">Catatan Admin</label>
                                            <textarea class="form-control" id="catatan_admin" name="catatan_admin" rows="3">{{ $laporanPengaduan->catatan_admin }}</textarea>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-block">
                                            <i class="fas fa-save"></i> Update Status
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
