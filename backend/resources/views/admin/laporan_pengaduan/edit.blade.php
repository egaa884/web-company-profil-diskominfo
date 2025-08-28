@extends('layouts.admin')

@section('title', 'Edit Laporan Pengaduan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Laporan Pengaduan</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.laporan-pengaduan.show', $laporanPengaduan->id) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                        <a href="{{ route('admin.laporan-pengaduan.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.laporan-pengaduan.update', $laporanPengaduan->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="judul">Judul Pengaduan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                                           id="judul" name="judul" value="{{ old('judul', $laporanPengaduan->judul) }}" required>
                                    @error('judul')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="kategori_pengaduan">Kategori Pengaduan <span class="text-danger">*</span></label>
                                    <select class="form-control @error('kategori_pengaduan') is-invalid @enderror" 
                                            id="kategori_pengaduan" name="kategori_pengaduan" required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="Pelayanan Publik" {{ old('kategori_pengaduan', $laporanPengaduan->kategori_pengaduan) == 'Pelayanan Publik' ? 'selected' : '' }}>Pelayanan Publik</option>
                                        <option value="Infrastruktur" {{ old('kategori_pengaduan', $laporanPengaduan->kategori_pengaduan) == 'Infrastruktur' ? 'selected' : '' }}>Infrastruktur</option>
                                        <option value="Administrasi" {{ old('kategori_pengaduan', $laporanPengaduan->kategori_pengaduan) == 'Administrasi' ? 'selected' : '' }}>Administrasi</option>
                                        <option value="Keamanan" {{ old('kategori_pengaduan', $laporanPengaduan->kategori_pengaduan) == 'Keamanan' ? 'selected' : '' }}>Keamanan</option>
                                        <option value="Kesehatan" {{ old('kategori_pengaduan', $laporanPengaduan->kategori_pengaduan) == 'Kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                                        <option value="Pendidikan" {{ old('kategori_pengaduan', $laporanPengaduan->kategori_pengaduan) == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                                        <option value="Transportasi" {{ old('kategori_pengaduan', $laporanPengaduan->kategori_pengaduan) == 'Transportasi' ? 'selected' : '' }}>Transportasi</option>
                                        <option value="Lingkungan" {{ old('kategori_pengaduan', $laporanPengaduan->kategori_pengaduan) == 'Lingkungan' ? 'selected' : '' }}>Lingkungan</option>
                                    </select>
                                    @error('kategori_pengaduan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-control @error('status') is-invalid @enderror" 
                                            id="status" name="status" required>
                                        <option value="pending" {{ old('status', $laporanPengaduan->status) == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                        <option value="diproses" {{ old('status', $laporanPengaduan->status) == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                        <option value="selesai" {{ old('status', $laporanPengaduan->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="ditolak" {{ old('status', $laporanPengaduan->status) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="prioritas">Prioritas <span class="text-danger">*</span></label>
                                    <select class="form-control @error('prioritas') is-invalid @enderror" 
                                            id="prioritas" name="prioritas" required>
                                        <option value="">Pilih Prioritas</option>
                                        <option value="rendah" {{ old('prioritas', $laporanPengaduan->prioritas) == 'rendah' ? 'selected' : '' }}>Rendah</option>
                                        <option value="normal" {{ old('prioritas', $laporanPengaduan->prioritas) == 'normal' ? 'selected' : '' }}>Normal</option>
                                        <option value="tinggi" {{ old('prioritas', $laporanPengaduan->prioritas) == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                                        <option value="kritis" {{ old('prioritas', $laporanPengaduan->prioritas) == 'kritis' ? 'selected' : '' }}>Kritis</option>
                                    </select>
                                    @error('prioritas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="nama_pelapor">Nama Pelapor <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama_pelapor') is-invalid @enderror" 
                                           id="nama_pelapor" name="nama_pelapor" value="{{ old('nama_pelapor', $laporanPengaduan->nama_pelapor) }}" required>
                                    @error('nama_pelapor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email_pelapor">Email Pelapor <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email_pelapor') is-invalid @enderror" 
                                           id="email_pelapor" name="email_pelapor" value="{{ old('email_pelapor', $laporanPengaduan->email_pelapor) }}" required>
                                    @error('email_pelapor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telepon_pelapor">Telepon Pelapor <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('telepon_pelapor') is-invalid @enderror" 
                                           id="telepon_pelapor" name="telepon_pelapor" value="{{ old('telepon_pelapor', $laporanPengaduan->telepon_pelapor) }}" required>
                                    @error('telepon_pelapor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="nik_pelapor">NIK Pelapor <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nik_pelapor') is-invalid @enderror" 
                                           id="nik_pelapor" name="nik_pelapor" value="{{ old('nik_pelapor', $laporanPengaduan->nik_pelapor) }}" 
                                           maxlength="16" pattern="[0-9]{16}" required>
                                    <small class="form-text text-muted">NIK harus 16 digit angka</small>
                                    @error('nik_pelapor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="file_lampiran">File Lampiran</label>
                                    @if($laporanPengaduan->file_lampiran)
                                        <div class="mb-2">
                                            <strong>File saat ini:</strong> {{ $laporanPengaduan->file_name }}
                                            <a href="{{ route('admin.laporan-pengaduan.download', $laporanPengaduan->id) }}" 
                                               class="btn btn-sm btn-success ml-2">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        </div>
                                    @endif
                                    <input type="file" class="form-control @error('file_lampiran') is-invalid @enderror" 
                                           id="file_lampiran" name="file_lampiran" 
                                           accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                    <small class="form-text text-muted">Format: PDF, DOC, DOCX, JPG, JPEG, PNG (Max: 2MB). Kosongkan jika tidak ingin mengubah file.</small>
                                    @error('file_lampiran')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="alamat_pelapor">Alamat Pelapor <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('alamat_pelapor') is-invalid @enderror" 
                                      id="alamat_pelapor" name="alamat_pelapor" rows="3" required>{{ old('alamat_pelapor', $laporanPengaduan->alamat_pelapor) }}</textarea>
                            @error('alamat_pelapor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi Pengaduan <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      id="deskripsi" name="deskripsi" rows="5" required>{{ old('deskripsi', $laporanPengaduan->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="catatan_admin">Catatan Admin</label>
                            <textarea class="form-control @error('catatan_admin') is-invalid @enderror" 
                                      id="catatan_admin" name="catatan_admin" rows="3">{{ old('catatan_admin', $laporanPengaduan->catatan_admin) }}</textarea>
                            @error('catatan_admin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Laporan
                            </button>
                            <a href="{{ route('admin.laporan-pengaduan.show', $laporanPengaduan->id) }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Format NIK input
document.getElementById('nik_pelapor').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '');
    if (this.value.length > 16) {
        this.value = this.value.slice(0, 16);
    }
});

// Format phone input
document.getElementById('telepon_pelapor').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9+\-\s]/g, '');
});
</script>
@endpush
