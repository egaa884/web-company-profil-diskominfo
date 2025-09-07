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
                <label for="konten" class="form-label">Konten</label>
                <textarea name="konten" id="konten" class="form-control" rows="6" required>{{ old('konten') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="gambar" class="form-label">Thumbnail Gambar Utama</label>
                <input type="file" name="gambar" id="gambar" class="form-control" accept="image/jpeg,image/jpg,image/png" onchange="validateImage(this)">
                <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                <div id="imagePreview" class="mt-2" style="display: none;">
                    <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px;">
                </div>
                <div id="imageError" class="text-danger mt-1" style="display: none;"></div>
            </div>

            <div class="mb-3">
                <label for="images" class="form-label">Galeri Gambar (Multiple)</label>
                <input type="file" name="images[]" id="images" class="form-control" accept="image/jpeg,image/jpg,image/png" multiple onchange="validateMultipleImages(this)">
                <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB per gambar. Pilih multiple gambar dengan menahan Ctrl</small>
                <div id="imagesPreview" class="mt-2" style="display: none;">
                    <div id="imagesContainer" class="d-flex flex-wrap gap-2"></div>
                </div>
                <div id="imagesError" class="text-danger mt-1" style="display: none;"></div>
            </div>

            <div class="mb-3">
                <label for="pdf" class="form-label">File PDF (Opsional)</label>
                <input type="file" name="pdf" id="pdf" class="form-control" accept="application/pdf" onchange="validatePdf(this)">
                <small class="text-muted">Format: PDF. Maksimal 10MB</small>
                <div id="pdfInfo" class="mt-2" style="display: none;">
                    <span id="pdfName" class="text-success"></span>
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
    const infoDiv = document.getElementById('pdfInfo');
    const pdfName = document.getElementById('pdfName');

    // Reset error and info
    errorDiv.style.display = 'none';
    infoDiv.style.display = 'none';

    if (file) {
        // Check file size (10MB = 10 * 1024 * 1024 bytes)
        if (file.size > 10 * 1024 * 1024) {
            errorDiv.textContent = 'Ukuran file terlalu besar. Maksimal 10MB.';
            errorDiv.style.display = 'block';
            input.value = '';
            return;
        }

        // Check file type
        if (file.type !== 'application/pdf') {
            errorDiv.textContent = 'Format file tidak didukung. Gunakan file PDF.';
            errorDiv.style.display = 'block';
            input.value = '';
            return;
        }

        // Show file info
        pdfName.textContent = 'File dipilih: ' + file.name;
        infoDiv.style.display = 'block';
    }
}

function validateMultipleImages(input) {
    const files = input.files;
    const errorDiv = document.getElementById('imagesError');
    const previewDiv = document.getElementById('imagesPreview');
    const container = document.getElementById('imagesContainer');

    // Reset error and preview
    errorDiv.style.display = 'none';
    previewDiv.style.display = 'none';
    container.innerHTML = '';

    if (files && files.length > 0) {
        let hasError = false;

        for (let i = 0; i < files.length; i++) {
            const file = files[i];

            // Check file size (2MB = 2 * 1024 * 1024 bytes)
            if (file.size > 2 * 1024 * 1024) {
                errorDiv.textContent = `Ukuran file "${file.name}" terlalu besar. Maksimal 2MB.`;
                errorDiv.style.display = 'block';
                hasError = true;
                input.value = '';
                return;
            }

            // Check file type
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!allowedTypes.includes(file.type)) {
                errorDiv.textContent = `Format file "${file.name}" tidak didukung. Gunakan JPG, JPEG, atau PNG.`;
                errorDiv.style.display = 'block';
                hasError = true;
                input.value = '';
                return;
            }
        }

        if (!hasError) {
            // Show previews
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();

                reader.onload = function(e) {
                    const imgDiv = document.createElement('div');
                    imgDiv.className = 'position-relative';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'img-thumbnail';
                    img.style.width = '100px';
                    img.style.height = '100px';
                    img.style.objectFit = 'cover';

                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className = 'btn btn-danger btn-sm position-absolute';
                    removeBtn.style.top = '0';
                    removeBtn.style.right = '0';
                    removeBtn.innerHTML = '×';
                    removeBtn.onclick = function() {
                        container.removeChild(imgDiv);
                        if (container.children.length === 0) {
                            previewDiv.style.display = 'none';
                        }
                    };

                    imgDiv.appendChild(img);
                    imgDiv.appendChild(removeBtn);
                    container.appendChild(imgDiv);
                };

                reader.readAsDataURL(file);
            }

            previewDiv.style.display = 'block';
        }
    }
}
</script>
@endsection
