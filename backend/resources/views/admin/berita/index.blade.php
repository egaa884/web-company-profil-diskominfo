@extends('layouts.admin')
@section('title', 'Daftar Berita')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Daftar Berita</h4>
        <a href="{{ route('admin.berita.create') }}" class="btn btn-primary">Tambah Berita</a>
    </div>

    <div class="d-flex flex-wrap gap-2 mb-4">
        <a href="{{ route('admin.berita.index') }}"
           class="btn btn-secondary {{ !request('category') ? 'active' : '' }}">
           Semua Berita
        </a>
        @foreach ($categories as $category)
            <a href="{{ route('admin.berita.index', ['category' => $category]) }}"
               class="btn btn-info {{ request('category') == $category ? 'active' : '' }}">
               {{ $category }}
            </a>
        @endforeach
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Status</th>
                            <th>Kategori</th>
                            <th>Pengunjung</th>
                            <th>Hot News</th>
                            <th>Ditambahkan Pada</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($beritas as $berita)
                            <tr>
                                <td>{{ $berita->judul }}</td>
                                <td>
                                    <span class="badge {{ $berita->status == 'published' ? 'bg-success' : 'bg-warning text-dark' }}">
                                        {{ ucfirst($berita->status) }}
                                    </span>
                                </td>
                                <td>{{ $berita->category }}</td>
                                <td>
                                    <span class="badge bg-primary">
                                        <i class="fas fa-eye"></i> {{ number_format($berita->views) }}
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('admin.berita.toggle-hot', $berita) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm {{ $berita->is_hot ? 'btn-danger' : 'btn-success' }}">
                                            <i class="fas {{ $berita->is_hot ? 'fa-fire' : 'fa-plus' }}"></i>
                                            {{ $berita->is_hot ? 'Hapus Hot' : 'Jadikan Hot' }}
                                        </button>
                                    </form>
                                </td>
                                <td>{{ $berita->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.berita.show', $berita) }}" class="btn btn-sm btn-info">Lihat</a>
                                    <a href="{{ route('admin.berita.edit', $berita) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.berita.destroy', $berita) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada berita yang ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                @if($beritas->hasPages())
                    <nav aria-label="Pagination">
                        <ul class="pagination justify-content-center">
                            {{-- Previous Page Link --}}
                            @if ($beritas->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">Previous</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $beritas->previousPageUrl() }}" rel="prev">Previous</a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($beritas->getUrlRange(1, $beritas->lastPage()) as $page => $url)
                                @if ($page == $beritas->currentPage())
                                    <li class="page-item active">
                                        <span class="page-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($beritas->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $beritas->nextPageUrl() }}" rel="next">Next</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">Next</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .container {
        padding: 20px;
    }

    .card {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background-color: #2d2f6e;
        color: white;
        padding: 15px;
        text-align: left;
    }

    .card-body {
        padding: 20px;
    }

    .table {
        width: 100%;
        margin-bottom: 20px;
    }

    .btn-primary {
        background-color: #2d2f6e;
        color: white;
    }

    .pagination {
        text-align: center;
        margin-top: 20px;
    }

    /* Bootstrap 5 Pagination Styling - Compact Horizontal Layout */
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.125rem;
        margin-top: 20px;
        padding: 0;
        flex-wrap: nowrap;
        overflow-x: auto;
        white-space: nowrap;
    }

    /* Ensure Previous and Next buttons are always horizontal */
    .pagination .page-item:first-child,
    .pagination .page-item:last-child {
        flex-shrink: 0;
    }

    /* Hide arrow icons in Previous and Next buttons */
    .pagination .page-item:first-child .page-link::before,
    .pagination .page-item:last-child .page-link::after,
    .pagination .page-item:first-child .page-link i,
    .pagination .page-item:last-child .page-link i,
    .pagination .page-item:first-child .page-link svg,
    .pagination .page-item:last-child .page-link svg {
        display: none !important;
    }

    /* Hide any content inside Previous/Next that might be icons */
    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        font-family: inherit !important;
    }

    .pagination .page-item:first-child .page-link::after,
    .pagination .page-item:last-child .page-link::before {
        display: none !important;
    }

    .pagination .page-link {
        color: #2d2f6e;
        background-color: #fff;
        border: 1px solid #dee2e6;
        padding: 0.2rem 0.4rem;
        margin: 0;
        border-radius: 0.2rem;
        text-decoration: none;
        transition: all 0.15s ease;
        font-size: 0.8rem;
        line-height: 1.1;
        min-width: 1.8rem;
        max-width: 2.5rem;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .pagination .page-link:hover {
        color: #1a1d4a;
        background-color: #f8f9fa;
        border-color: #adb5bd;
        transform: translateY(-1px);
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .pagination .page-item.active .page-link {
        background-color: #2d2f6e;
        border-color: #2d2f6e;
        color: white;
        font-weight: 600;
    }

    .pagination .page-item.disabled .page-link {
        color: #6c757d;
        background-color: #f8f9fa;
        border-color: #dee2e6;
        cursor: not-allowed;
        opacity: 0.5;
    }

    .pagination .page-item:first-child .page-link {
        border-top-left-radius: 0.2rem;
        border-bottom-left-radius: 0.2rem;
    }

    .pagination .page-item:last-child .page-link {
        border-top-right-radius: 0.2rem;
        border-bottom-right-radius: 0.2rem;
    }

    /* Hide page numbers on very small screens to keep Previous/Next visible */
    @media (max-width: 480px) {
        .pagination .page-item:not(.page-item:first-child):not(.page-item:last-child):not(.active) {
            display: none;
        }

        .pagination::before {
            content: "...";
            color: #6c757d;
            margin: 0 0.25rem;
            font-size: 0.8rem;
        }
    }

    /* View Counter Styling */
    .badge {
        font-size: 0.9em;
        font-weight: 700;
        padding: 8px 14px;
        border-radius: 6px;
        display: inline-block;
        min-width: 50px;
        text-align: center;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .bg-primary {
        background: linear-gradient(135deg, #007bff, #0056b3) !important;
        color: white !important;
        border: 1px solid #0056b3;
    }

    .bg-primary:hover {
        background: linear-gradient(135deg, #0056b3, #004085) !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    /* Responsiveness */
    @media (max-width: 768px) {
        .table th, .table td {
            padding: 8px;
        }
    }
</style>
@endsection