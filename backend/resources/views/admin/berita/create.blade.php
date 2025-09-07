@extends('layouts.admin')
@section('title', 'Tambah Berita')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Tambah Berita</h5>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="judul" class="form-label">Judul</label>
                <input type="text" name="judul" id="judul" class="form-control" value="{{ old('judul') }}" required>
            </div>

            <div class="mb-3">
                <label for="deskripsi_singkat" class="form-label">Deskripsi Singkat</label>
                <textarea name="deskripsi_singkat" id="deskripsi_singkat" class="form-control" rows="3" placeholder="Masukkan deskripsi singkat berita (opsional)">{{ old('deskripsi_singkat') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="konten" class="form-label">Konten</label>
                <textarea name="konten" id="konten" class="form-control" rows="6" required>{{ old('konten') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="gambar" class="form-label">Thumbnail Gambar</label>
                <input type="file" name="gambar" id="gambar" class="form-control" accept="image/jpeg,image/jpg,image/png" onchange="validateImage(this)">
                <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                <div id="imagePreview" class="mt-2" style="display: none;">
                    <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px;">
                </div>
                <div id="imageError" class="text-danger mt-1" style="display: none;"></div>
            </div>

            <div class="mb-3">
                <label for="lampiran_pdf" class="form-label">Lampiran PDF</label>
                <input type="file" name="lampiran_pdf" id="lampiran_pdf" class="form-control" accept="application/pdf" onchange="validatePdf(this)">
                <small class="text-muted">Format: PDF. Maksimal 10MB</small>
                <div id="pdfPreview" class="mt-2" style="display: none;">
                    <div class="alert alert-info">
                        <i class="fas fa-file-pdf text-danger"></i>
                        <span id="pdfFileName" class="ms-2"></span>
                    </div>
                </div>
                <div id="pdfError" class="text-danger mt-1" style="display: none;"></div>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Publish</option>
                </select>
            </div>

            <div class="form-group">
                <label for="category">Kategori</label>
                <select name="category" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<script>
function validateImage(input) {
    const file = input.files[0];
    const errorDiv = document.getElementById('imageError');
    const previewDiv = document.getElementById('imagePreview');
    const previewImg = document.getElementById('preview');
    
    // Reset error and preview
    errorDiv.style.display = 'none';
    previewDiv.style.display = 'none';
    
    if (file) {
        // Check file size (2MB = 2 * 1024 * 1024 bytes)
        if (file.size > 2 * 1024 * 1024) {
            errorDiv.textContent = 'Ukuran file terlalu besar. Maksimal 2MB.';
            errorDiv.style.display = 'block';
            input.value = '';
            return;
        }
        
        // Check file type
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!allowedTypes.includes(file.type)) {
            errorDiv.textContent = 'Format file tidak didukung. Gunakan JPG, JPEG, atau PNG.';
            errorDiv.style.display = 'block';
            input.value = '';
            return;
        }
        
        // Show preview
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewDiv.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
}

function validatePdf(input) {
    const file = input.files[0];
    const errorDiv = document.getElementById('pdfError');
    const previewDiv = document.getElementById('pdfPreview');
    const fileNameSpan = document.getElementById('pdfFileName');
    
    // Reset error and preview
    errorDiv.style.display = 'none';
    previewDiv.style.display = 'none';
    
    if (file) {
        // Check file size (10MB = 10 * 1024 * 1024 bytes)
        if (file.size > 10 * 1024 * 1024) {
            errorDiv.textContent = 'Ukuran file terlalu besar. Maksimal 10MB.';
            errorDiv.style.display = 'block';
            input.value = '';
            return;
        }
        
        // Check file type
        const allowedTypes = ['application/pdf'];
        if (!allowedTypes.includes(file.type)) {
            errorDiv.textContent = 'Format file tidak didukung. Gunakan file PDF.';
            errorDiv.style.display = 'block';
            input.value = '';
            return;
        }
        
        // Show preview
        fileNameSpan.textContent = file.name;
        previewDiv.style.display = 'block';
    }
}
</script>
@endsection
