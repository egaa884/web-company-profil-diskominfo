@extends('layouts.admin')
@section('title', 'Kelola Komentar')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Kelola Komentar</h4>
    </div>

    <div class="d-flex flex-wrap gap-2 mb-4">
        <a href="{{ route('admin.comments.index') }}"
           class="btn btn-secondary {{ !request('status') ? 'active' : '' }}">
           Semua Komentar
        </a>
        <a href="{{ route('admin.comments.index', ['status' => 'pending']) }}"
           class="btn btn-warning {{ request('status') == 'pending' ? 'active' : '' }}">
           Menunggu Moderasi
        </a>
        <a href="{{ route('admin.comments.index', ['status' => 'approved']) }}"
           class="btn btn-success {{ request('status') == 'approved' ? 'active' : '' }}">
           Disetujui
        </a>
        <a href="{{ route('admin.comments.index', ['status' => 'rejected']) }}"
           class="btn btn-danger {{ request('status') == 'rejected' ? 'active' : '' }}">
           Ditolak
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Pengirim</th>
                            <th>Berita</th>
                            <th>Komentar</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($comments as $comment)
                            <tr>
                                <td>
                                    <div>
                                        <strong>{{ $comment->name }}</strong>
                                        @if($comment->email)
                                            <br><small class="text-muted">{{ $comment->email }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('admin.berita.show', $comment->berita) }}" target="_blank">
                                        {{ Str::limit($comment->berita->judul, 50) }}
                                    </a>
                                </td>
                                <td>
                                    <div style="max-width: 300px;">
                                        {{ Str::limit($comment->comment, 100) }}
                                        @if(strlen($comment->comment) > 100)
                                            <span class="text-muted">...</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge {{ $comment->is_approved ? 'bg-success' : 'bg-warning text-dark' }}">
                                        {{ $comment->is_approved ? 'Disetujui' : 'Menunggu' }}
                                    </span>
                                </td>
                                <td>{{ $comment->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    @if(!$comment->is_approved)
                                        <form action="{{ route('admin.comments.approve', $comment) }}" method="POST" style="display:inline;" onsubmit="return confirm('Setujui komentar ini?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success" title="Setujui">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.comments.reject', $comment) }}" method="POST" style="display:inline;" onsubmit="return confirm('Tolak komentar ini?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-warning" title="Tolak">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus komentar ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    @if(request('status') === 'pending')
                                        Tidak ada komentar yang menunggu moderasi.
                                    @elseif(request('status') === 'approved')
                                        Tidak ada komentar yang disetujui.
                                    @elseif(request('status') === 'rejected')
                                        Tidak ada komentar yang ditolak.
                                    @else
                                        Tidak ada komentar yang ditemukan.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                @if($comments->hasPages())
                    <nav aria-label="Pagination">
                        <ul class="pagination justify-content-center">
                            {{-- Previous Page Link --}}
                            @if ($comments->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">Previous</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $comments->previousPageUrl() }}" rel="prev">Previous</a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($comments->getUrlRange(1, $comments->lastPage()) as $page => $url)
                                @if ($page == $comments->currentPage())
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
                            @if ($comments->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $comments->nextPageUrl() }}" rel="next">Next</a>
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

    .btn {
        margin-right: 5px;
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
    .pagination .page-item:last-child .page-link i {
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

    /* Responsiveness */
    @media (max-width: 768px) {
        .table th, .table td {
            padding: 8px;
            font-size: 14px;
        }

        .table td div {
            max-width: 200px;
        }
    }
</style>
@endsection