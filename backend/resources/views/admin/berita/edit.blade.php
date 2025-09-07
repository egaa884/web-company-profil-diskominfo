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
                    <label for="nama_pembuat">Nama Pembuat</label>
                    <input type="text" name="nama_pembuat" class="form-control" value="{{ old('nama_pembuat', $berita->nama_pembuat) }}" placeholder="Masukkan nama pembuat berita">
                </div>

                <div class="form-group">
                    <label for="deskripsi_singkat">Deskripsi Singkat</label>
                    <textarea name="deskripsi_singkat" class="form-control" rows="3" placeholder="Masukkan deskripsi singkat berita (opsional)">{{ old('deskripsi_singkat', $berita->deskripsi_singkat) }}</textarea>
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
                    <label for="gambar">Gambar</label>
                    <input type="file" name="gambar" class="form-control" accept="image/jpeg,image/jpg,image/png" onchange="validateImage(this)">
                    <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                    @if ($berita->gambar)
                        <div class="mt-2">
                            <p class="text-muted">Gambar saat ini:</p>
                            <img src="{{ asset('storage/' . $berita->gambar) }}" width="150" class="img-thumbnail">
                        </div>
                    @endif
                    <div id="imagePreview" class="mt-2" style="display: none;">
                        <p class="text-muted">Preview gambar baru:</p>
                        <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px;">
                    </div>
                    <div id="imageError" class="text-danger mt-1" style="display: none;"></div>
                </div>

                <div class="form-group">
                    <label for="lampiran_pdf">Lampiran PDF</label>
                    <input type="file" name="lampiran_pdf" class="form-control" accept="application/pdf" onchange="validatePdf(this)">
                    <small class="text-muted">Format: PDF. Maksimal 10MB</small>
                    @if ($berita->lampiran_pdf)
                        <div class="mt-2">
                            <p class="text-muted">PDF saat ini:</p>
                            <div class="alert alert-info">
                                <i class="fas fa-file-pdf text-danger"></i>
                                <a href="{{ asset('storage/' . $berita->lampiran_pdf) }}" target="_blank" class="ms-2">
                                    {{ basename($berita->lampiran_pdf) }}
                                </a>
                            </div>
                        </div>
                    @endif
                    <div id="pdfPreview" class="mt-2" style="display: none;">
                        <p class="text-muted">Preview PDF baru:</p>
                        <div class="alert alert-info">
                            <i class="fas fa-file-pdf text-danger"></i>
                            <span id="pdfFileName" class="ms-2"></span>
                        </div>
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
