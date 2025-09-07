@extends('layouts.admin')

@section('title', 'Edit Berita')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Edit Berita</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') <!-- Menandakan permintaan PUT untuk update -->
                

                <div class="form-group">
                    <label for="judul">Judul</label>
                    <input type="text" name="judul" class="form-control" value="{{ old('judul', $berita->judul) }}">
                </div>

                <div class="form-group">
                    <label for="konten">Konten</label>
                    <textarea name="konten" class="form-control">{{ old('konten', $berita->konten) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control">
                        <option value="draft" {{ $berita->status == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ $berita->status == 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="category">Kategori</label>
                    <select name="category" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat }}" {{ (old('category', $berita->category) == $cat) ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="gambar">Gambar Utama</label>
                    <input type="file" name="gambar" class="form-control" accept="image/jpeg,image/jpg,image/png" onchange="validateImage(this)">
                    <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                    @if ($berita->gambar)
                        <div class="mt-2">
                            <p class="text-muted">Gambar utama saat ini:</p>
                            <img src="{{ asset('storage/' . $berita->gambar) }}" width="150" class="img-thumbnail">
                        </div>
                    @endif
                    <div id="imagePreview" class="mt-2" style="display: none;">
                        <p class="text-muted">Preview gambar utama baru:</p>
                        <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px;">
                    </div>
                    <div id="imageError" class="text-danger mt-1" style="display: none;"></div>
                </div>

                <div class="form-group">
                    <label for="images">Galeri Gambar (Multiple)</label>
                    <input type="file" name="images[]" class="form-control" accept="image/jpeg,image/jpg,image/png" multiple onchange="validateMultipleImages(this)">
                    <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB per gambar. Pilih multiple gambar dengan menahan Ctrl</small>

                    @if ($berita->images && $berita->images->count() > 0)
                        <div class="mt-2">
                            <p class="text-muted">Gambar galeri saat ini:</p>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($berita->images as $image)
                                    <div class="position-relative">
                                        <img src="{{ $image->image_url }}" width="100" height="100" class="img-thumbnail" style="object-fit: cover;">
                                        <button type="button" class="btn btn-danger btn-sm position-absolute" style="top: 0; right: 0;" onclick="removeImage({{ $image->id }})" title="Hapus gambar">×</button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div id="imagesPreview" class="mt-2" style="display: none;">
                        <p class="text-muted">Preview gambar galeri baru:</p>
                        <div id="imagesContainer" class="d-flex flex-wrap gap-2"></div>
                    </div>
                    <div id="imagesError" class="text-danger mt-1" style="display: none;"></div>
                </div>

                <div class="form-group">
                    <label for="pdf">File PDF (Opsional)</label>
                    <input type="file" name="pdf" class="form-control" accept="application/pdf" onchange="validatePdf(this)">
                    <small class="text-muted">Format: PDF. Maksimal 10MB</small>
                    @if ($berita->pdf)
                        <div class="mt-2">
                            <p class="text-muted">PDF saat ini:</p>
                            <a href="{{ asset('storage/' . $berita->pdf) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-file-pdf"></i> Lihat PDF
                            </a>
                        </div>
                    @endif
                    <div id="pdfInfo" class="mt-2" style="display: none;">
                        <span id="pdfName" class="text-success"></span>
                    </div>
                    <div id="pdfError" class="text-danger mt-1" style="display: none;"></div>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Update</button>
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

function removeImage(imageId) {
    if (confirm('Apakah Anda yakin ingin menghapus gambar ini?')) {
        // Create a form to submit delete request
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/berita/image/${imageId}`;

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';

        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        form.appendChild(methodInput);
        form.appendChild(csrfInput);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection
