@extends('layouts.admin')
@section('title', 'Edit Berita')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Berita</h5>
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

                    <form action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data" id="newsForm">
                        @csrf
                        @method('PUT')

                        <!-- Informasi Utama Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card border-primary">
                                    <div class="card-header bg-primary text-white">
                                        <h6 class="mb-0"><i class="fas fa-info-circle"></i> Informasi Utama</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="judul" class="form-label">Judul Berita <span class="text-danger">*</span></label>
                                                <input type="text" name="judul" id="judul" class="form-control" value="{{ old('judul', $berita->judul) }}" required>
                                                <div class="invalid-feedback" id="judulError"></div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="category" class="form-label">Kategori <span class="text-danger">*</span></label>
                                                <select name="category" id="category" class="form-select" required>
                                                    <option value="">-- Pilih Kategori --</option>
                                                    @foreach ($categories as $cat)
                                                        <option value="{{ $cat }}" {{ (old('category', $berita->category) == $cat) ? 'selected' : '' }}>{{ $cat }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="deskripsi_singkat" class="form-label">Deskripsi Singkat (Excerpt)</label>
                                            <textarea name="deskripsi_singkat" id="deskripsi_singkat" class="form-control" rows="3" placeholder="Ringkasan singkat berita (opsional)" maxlength="300">{{ old('deskripsi_singkat', $berita->deskripsi_singkat) }}</textarea>
                                            <small class="text-muted">
                                                <span id="excerptCounter">0</span>/300 karakter
                                                <span class="text-info ms-2">
                                                    <i class="fas fa-info-circle"></i> Excerpt akan ditampilkan di halaman berita sebagai ringkasan
                                                </span>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Media & Berkas Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card border-success">
                                    <div class="card-header bg-success text-white">
                                        <h6 class="mb-0"><i class="fas fa-images"></i> Media & Berkas</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="gambar" class="form-label">Gambar Utama <span class="text-danger">*</span></label>
                                                <input type="file" name="gambar" id="gambar" class="form-control" accept="image/jpeg,image/jpg,image/png" onchange="validateImage(this)">
                                                <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                                                @if ($berita->gambar)
                                                    <div class="mt-2">
                                                        <p class="text-muted">Gambar utama saat ini:</p>
                                                        <img src="{{ asset('storage/' . $berita->gambar) }}" width="150" class="img-thumbnail">
                                                    </div>
                                                @endif
                                                <div id="imagePreview" class="mt-2" style="display: none;">
                                                    <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px;">
                                                </div>
                                                <div id="imageError" class="text-danger mt-1" style="display: none;"></div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="lampiran_pdf" class="form-label">Lampiran PDF</label>
                                                <input type="file" name="lampiran_pdf" id="lampiran_pdf" class="form-control" accept="application/pdf" onchange="validatePdf(this)">
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
                                                    <div class="alert alert-info">
                                                        <i class="fas fa-file-pdf text-danger"></i>
                                                        <span id="pdfFileName" class="ms-2"></span>
                                                    </div>
                                                </div>
                                                <div id="pdfError" class="text-danger mt-1" style="display: none;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Konten Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card border-info">
                                    <div class="card-header bg-info text-white">
                                        <h6 class="mb-0"><i class="fas fa-edit"></i> Konten Berita</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="konten" class="form-label">Isi Berita <span class="text-danger">*</span></label>
                                            <textarea name="konten" id="konten" class="form-control" rows="12" required placeholder="Tulis isi berita di sini...">{{ old('konten', $berita->konten) }}</textarea>
                                            <small class="text-muted">
                                                Minimal 30 karakter.
                                                <span id="contentCounter" class="ms-2">0</span> karakter
                                            </small>
                                            <div class="invalid-feedback" id="kontenError"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pengaturan Berita Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card border-warning">
                                    <div class="card-header bg-warning text-dark">
                                        <h6 class="mb-0"><i class="fas fa-cogs"></i> Pengaturan Berita</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="status" class="form-label">Status Publikasi <span class="text-danger">*</span></label>
                                                <select name="status" id="status" class="form-select" required>
                                                    <option value="draft" {{ $berita->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                                    <option value="published" {{ $berita->status == 'published' ? 'selected' : '' }}>Publish</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="nama_pembuat" class="form-label">Penulis</label>
                                                <input type="text" name="nama_pembuat" id="nama_pembuat" class="form-control" value="{{ old('nama_pembuat', $berita->nama_pembuat ?? 'Admin Diskominfo') }}" placeholder="Nama penulis">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary" id="submitBtn">
                                        <i class="fas fa-save"></i> Update Berita
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

<script>
// Simple form validation and character counting
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('newsForm');
    const judulInput = document.getElementById('judul');
    const kontenTextarea = document.getElementById('konten');
    const deskripsiTextarea = document.getElementById('deskripsi_singkat');
    const submitBtn = document.getElementById('submitBtn');

    // Real-time validation for title
    judulInput.addEventListener('input', function() {
        validateTitle();
    });

    // Real-time validation for content
    kontenTextarea.addEventListener('input', function() {
        validateContent();
        updateContentCounter();
    });

    // Character counter for excerpt
    deskripsiTextarea.addEventListener('input', function() {
        const maxLength = 300;
        const currentLength = this.value.length;
        const counter = document.getElementById('excerptCounter');

        if (currentLength > maxLength) {
            this.value = this.value.substring(0, maxLength);
        }

        if (counter) {
            counter.textContent = this.value.length;
            counter.className = this.value.length > 250 ? 'text-warning' : this.value.length > 280 ? 'text-danger' : '';
        }
    });

    // Initialize counters on page load
    const initialExcerptCounter = document.getElementById('excerptCounter');
    if (initialExcerptCounter && deskripsiTextarea.value) {
        initialExcerptCounter.textContent = deskripsiTextarea.value.length;
    }

    const initialContentCounter = document.getElementById('contentCounter');
    if (initialContentCounter && kontenTextarea.value) {
        initialContentCounter.textContent = kontenTextarea.value.length;
    }

    function validateTitle() {
        const errorDiv = document.getElementById('judulError');
        const value = judulInput.value.trim();

        if (value.length === 0) {
            judulInput.classList.add('is-invalid');
            errorDiv.textContent = 'Judul berita wajib diisi';
            return false;
        } else if (value.length < 5) {
            judulInput.classList.add('is-invalid');
            errorDiv.textContent = 'Judul terlalu pendek (minimal 5 karakter)';
            return false;
        } else if (value.length > 200) {
            judulInput.classList.add('is-invalid');
            errorDiv.textContent = 'Judul terlalu panjang (maksimal 200 karakter)';
            return false;
        } else {
            judulInput.classList.remove('is-invalid');
            errorDiv.textContent = '';
            return true;
        }
    }

    function validateContent() {
        const errorDiv = document.getElementById('kontenError');
        const value = kontenTextarea.value.trim();

        if (value.length === 0) {
            kontenTextarea.classList.add('is-invalid');
            errorDiv.textContent = 'Konten berita wajib diisi';
            return false;
        } else if (value.length < 30) {
            kontenTextarea.classList.add('is-invalid');
            errorDiv.textContent = `Konten terlalu pendek (${value.length}/30 karakter minimal)`;
            return false;
        } else {
            kontenTextarea.classList.remove('is-invalid');
            errorDiv.textContent = '';
            return true;
        }
    }

    function updateContentCounter() {
        const counter = document.getElementById('contentCounter');
        if (counter) {
            counter.textContent = kontenTextarea.value.length;
            counter.className = kontenTextarea.value.length < 30 ? 'text-warning' : 'text-success';
        }
    }

    // Form submission validation
    form.addEventListener('submit', function(e) {
        const isTitleValid = validateTitle();
        const isContentValid = validateContent();

        if (!isTitleValid || !isContentValid) {
            e.preventDefault();
            submitBtn.disabled = true;
            setTimeout(() => {
                submitBtn.disabled = false;
            }, 2000);
        }
    });
});

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

<style>
.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
    transition: box-shadow 0.15s ease-in-out;
}

.card:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.card-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
}

/* Character counter colors */
.text-warning {
    color: #fd7e14 !important;
}

.text-danger {
    color: #dc3545 !important;
}

.text-success {
    color: #198754 !important;
}

/* Form validation improvements */
.is-invalid {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

.invalid-feedback {
    display: block;
    color: #dc3545;
    font-size: 0.875rem;
}

/* Alert improvements */
.alert {
    border-radius: 0.375rem;
}

.alert-info {
    background-color: #d1ecf1;
    border-color: #bee5eb;
    color: #0c5460;
}

/* Responsive improvements */
@media (max-width: 768px) {
    .container-fluid {
        padding-left: 15px;
        padding-right: 15px;
    }

    .card-body {
        padding: 1rem;
    }

    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 10px;
    }

    .d-flex.justify-content-between .btn {
        width: 100%;
    }

    /* Smaller text on mobile */
    .form-label {
        font-size: 0.875rem;
    }

    small.text-muted {
        font-size: 0.75rem;
    }
}

/* Focus states */
.form-control:focus,
.form-select:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

/* Button hover states */
.btn:hover {
    transform: translateY(-1px);
    transition: all 0.2s ease;
}

/* Custom scrollbar for textarea */
.form-control::-webkit-scrollbar {
    width: 8px;
}

.form-control::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.form-control::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 4px;
}

.form-control::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>
@endsection
