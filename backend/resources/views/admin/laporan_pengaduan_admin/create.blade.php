@extends('layouts.admin')
@section('title', 'Buat Laporan Pengaduan Baru')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Buat Laporan Pengaduan Baru</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.laporan-pengaduan-admin.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.laporan-pengaduan-admin.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <!-- Basic Information -->
                            <div class="col-md-8">
                                <div class="form-group mb-3">
                                    <label for="judul" class="form-label">Judul Laporan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                                           id="judul" name="judul" value="{{ old('judul') }}" 
                                           placeholder="Masukkan judul laporan" required>
                                    @error('judul')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="bulan" class="form-label">Bulan <span class="text-danger">*</span></label>
                                            <select class="form-select @error('bulan') is-invalid @enderror" 
                                                    id="bulan" name="bulan" required>
                                                <option value="">-- Pilih Bulan --</option>
                                                @foreach($bulanList as $bulan)
                                                    <option value="{{ $bulan }}" {{ old('bulan') == $bulan ? 'selected' : '' }}>
                                                        {{ $bulan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('bulan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="tahun" class="form-label">Tahun <span class="text-danger">*</span></label>
                                            <select class="form-select @error('tahun') is-invalid @enderror" 
                                                    id="tahun" name="tahun" required>
                                                <option value="">-- Pilih Tahun --</option>
                                                @foreach($tahunList as $tahun)
                                                    <option value="{{ $tahun }}" {{ old('tahun') == $tahun ? 'selected' : '' }}>
                                                        {{ $tahun }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('tahun')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi Laporan <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                              id="deskripsi" name="deskripsi" rows="4" 
                                              placeholder="Masukkan deskripsi lengkap laporan" required>{{ old('deskripsi') }}</textarea>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="ringkasan" class="form-label">Ringkasan Laporan</label>
                                    <textarea class="form-control @error('ringkasan') is-invalid @enderror" 
                                              id="ringkasan" name="ringkasan" rows="3" 
                                              placeholder="Masukkan ringkasan laporan (opsional)">{{ old('ringkasan') }}</textarea>
                                    @error('ringkasan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="file_lampiran" class="form-label">File Lampiran</label>
                                    <input type="file" class="form-control @error('file_lampiran') is-invalid @enderror" 
                                           id="file_lampiran" name="file_lampiran" 
                                           accept=".pdf,.doc,.docx">
                                    <small class="form-text text-muted">
                                        Format: PDF, DOC, DOCX. Maksimal 10MB
                                    </small>
                                    @error('file_lampiran')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Statistics -->
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Statistik Pengaduan</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <label for="total_pengaduan" class="form-label">Total Pengaduan <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('total_pengaduan') is-invalid @enderror" 
                                                   id="total_pengaduan" name="total_pengaduan" 
                                                   value="{{ old('total_pengaduan', 0) }}" min="0" required>
                                            @error('total_pengaduan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="pengaduan_diproses" class="form-label">Sedang Diproses <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('pengaduan_diproses') is-invalid @enderror" 
                                                   id="pengaduan_diproses" name="pengaduan_diproses" 
                                                   value="{{ old('pengaduan_diproses', 0) }}" min="0" required>
                                            @error('pengaduan_diproses')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="pengaduan_selesai" class="form-label">Selesai <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('pengaduan_selesai') is-invalid @enderror" 
                                                   id="pengaduan_selesai" name="pengaduan_selesai" 
                                                   value="{{ old('pengaduan_selesai', 0) }}" min="0" required>
                                            @error('pengaduan_selesai')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="pengaduan_ditolak" class="form-label">Ditolak <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('pengaduan_ditolak') is-invalid @enderror" 
                                                   id="pengaduan_ditolak" name="pengaduan_ditolak" 
                                                   value="{{ old('pengaduan_ditolak', 0) }}" min="0" required>
                                            @error('pengaduan_ditolak')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="catatan_admin" class="form-label">Catatan Admin</label>
                                            <textarea class="form-control @error('catatan_admin') is-invalid @enderror" 
                                                      id="catatan_admin" name="catatan_admin" rows="3" 
                                                      placeholder="Catatan internal admin">{{ old('catatan_admin') }}</textarea>
                                            @error('catatan_admin')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" 
                                                   id="is_published" name="is_published" 
                                                   value="1" {{ old('is_published') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_published">
                                                Publikasikan segera
                                            </label>
                                            <small class="form-text text-muted d-block">
                                                Jika dicentang, laporan akan langsung dipublikasikan
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.laporan-pengaduan-admin.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Simpan Laporan
                                    </button>
                                </div>
                            </div>
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
    // Auto-calculate total
    document.addEventListener('DOMContentLoaded', function() {
        const totalInput = document.getElementById('total_pengaduan');
        const diprosesInput = document.getElementById('pengaduan_diproses');
        const selesaiInput = document.getElementById('pengaduan_selesai');
        const ditolakInput = document.getElementById('pengaduan_ditolak');

        function calculateTotal() {
            const diproses = parseInt(diprosesInput.value) || 0;
            const selesai = parseInt(selesaiInput.value) || 0;
            const ditolak = parseInt(ditolakInput.value) || 0;
            const total = diproses + selesai + ditolak;
            totalInput.value = total;
        }

        diprosesInput.addEventListener('input', calculateTotal);
        selesaiInput.addEventListener('input', calculateTotal);
        ditolakInput.addEventListener('input', calculateTotal);
    });
</script>
@endpush
