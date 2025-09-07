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
                                <td colspan="5" class="text-center">Tidak ada berita yang ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="pagination">
                {{ $beritas->appends(request()->query())->links() }}
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

    /* Responsiveness */
    @media (max-width: 768px) {
        .table th, .table td {
            padding: 8px;
        }
    }
</style>
@endsection