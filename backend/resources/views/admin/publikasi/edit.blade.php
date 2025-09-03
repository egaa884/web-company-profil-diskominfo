@extends('layouts.admin')
@section('title', 'Edit Publikasi')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Publikasi</h1>
        <a href="{{ route('admin.publikasi.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Publikasi</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.publikasi.update', $publikasi->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul <span class="text-danger">*</span></label>
                            <input type="text" name="judul" id="judul" class="form-control @error('judul') is-invalid @enderror" 
                                   value="{{ old('judul', $publikasi->judul) }}" required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select name="kategori" id="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                                <option value="">Pilih Kategori</option>
                                <option value="pengaduan" {{ old('kategori', $publikasi->kategori) == 'pengaduan' ? 'selected' : '' }}>Laporan Pengaduan</option>
                                <option value="penerima" {{ old('kategori', $publikasi->kategori) == 'penerima' ? 'selected' : '' }}>Laporan Penerimaan</option>
                                <option value="surveikepuasan" {{ old('kategori', $publikasi->kategori) == 'surveikepuasan' ? 'selected' : '' }}>Survei Kepuasan Masyarakat</option>
                                <option value="surveievaluasi" {{ old('kategori', $publikasi->kategori) == 'surveievaluasi' ? 'selected' : '' }}>Survei Evaluasi Pelayanan Publik</option>
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ringkasan" class="form-label">Ringkasan</label>
                            <textarea name="ringkasan" id="ringkasan" class="form-control @error('ringkasan') is-invalid @enderror" 
                                      rows="3" placeholder="Masukkan ringkasan singkat publikasi">{{ old('ringkasan', $publikasi->ringkasan) }}</textarea>
                            @error('ringkasan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="isi" class="form-label">Isi Lengkap</label>
                            <textarea name="isi" id="isi" class="form-control @error('isi') is-invalid @enderror" 
                                      rows="6" placeholder="Masukkan konten lengkap publikasi">{{ old('isi', $publikasi->isi) }}</textarea>
                            @error('isi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="file_path" class="form-label">File Path</label>
                            <div class="input-group">
                                <input type="text" name="file_path" id="file_path" 
                                       class="form-control @error('file_path') is-invalid @enderror"
                                       placeholder="Contoh: /path/to/file.pdf"
                                       value="{{ old('file_path', $publikasi->file_path) }}">
                                <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('file_upload').click()">
                                    <i class="fas fa-upload"></i>
                                </button>
                            </div>
                            <input type="file" id="file_upload" name="file_upload" class="d-none" onchange="handleFileSelect(this)">
                            <small class="text-muted">Masukkan path file jika ada atau gunakan button upload untuk memilih file dari komputer</small>
                            @if($publikasi->file_path)
                                <div class="mt-2">
                                    <small class="text-info">
                                        <i class="fas fa-file"></i> File saat ini: {{ $publikasi->file_path }}
                                    </small>
                                </div>
                            @endif
                            @error('file_path')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="published_at" class="form-label">Tanggal Publikasi</label>
                            <input type="datetime-local" name="published_at" id="published_at" 
                                   class="form-control @error('published_at') is-invalid @enderror"
                                   value="{{ old('published_at', $publikasi->published_at ? $publikasi->published_at->format('Y-m-d\TH:i') : '') }}">
                            <small class="text-muted">Kosongkan untuk menggunakan waktu saat ini</small>
                            @error('published_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_published" name="is_published" 
                                       value="1" {{ old('is_published', $publikasi->is_published) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_published">
                                    Publikasikan Sekarang
                                </label>
                            </div>
                            <small class="text-muted">Centang untuk mempublikasikan langsung</small>
                        </div>

                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-muted">Informasi Publikasi</h6>
                                <small class="text-muted">
                                    <strong>Slug:</strong> {{ $publikasi->slug }}<br>
                                    <strong>Dibuat:</strong> {{ $publikasi->created_at->format('d/m/Y H:i') }}<br>
                                    <strong>Diperbarui:</strong> {{ $publikasi->updated_at->format('d/m/Y H:i') }}<br>
                                    <strong>Status:</strong> <span id="status-display">{{ $publikasi->is_published ? 'Dipublikasi' : 'Draft' }}</span>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.publikasi.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Publikasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function handleFileSelect(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const fileName = file.name;
        
        // Update the file_path input with the selected file name
        document.getElementById('file_path').value = fileName;
        
        // Show file info
        console.log('File selected:', fileName);
        
        // You can add more validation here if needed
        const fileSize = (file.size / 1024 / 1024).toFixed(2);
        console.log('File size:', fileSize + ' MB');
    }
}

// Update status display based on checkbox
document.getElementById('is_published').addEventListener('change', function() {
    const statusDisplay = document.getElementById('status-display');
    if (this.checked) {
        statusDisplay.textContent = 'Akan Dipublikasi';
        statusDisplay.className = 'text-success';
    } else {
        statusDisplay.textContent = 'Draft';
        statusDisplay.className = 'text-muted';
    }
});

// Initialize status display on page load
document.addEventListener('DOMContentLoaded', function() {
    const isPublishedCheckbox = document.getElementById('is_published');
    const statusDisplay = document.getElementById('status-display');
    
    if (isPublishedCheckbox.checked) {
        statusDisplay.textContent = 'Akan Dipublikasi';
        statusDisplay.className = 'text-success';
    }
});
</script>
@endsection


