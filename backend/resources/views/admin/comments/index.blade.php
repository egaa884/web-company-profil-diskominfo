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
                {{ $comments->appends(request()->query())->links() }}
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