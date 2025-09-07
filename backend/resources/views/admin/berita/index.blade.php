@extends('layouts.admin')
@section('title', 'Daftar Berita')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Daftar Berita</h4>
            <a href="{{ route('admin.berita.create') }}" class="btn btn-primary">Tambah Berita</a>
        </div>
        <div class="card-body">
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

            <!-- Filter Kategori -->
            <div class="mb-3">
                <form method="GET" class="d-flex gap-2 align-items-center">
                    <label for="category" class="form-label mb-0">Filter Kategori:</label>
                    <select name="category" id="category" class="form-select" style="width: auto;" onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    @if(request('category'))
                        <a href="{{ route('admin.berita.index') }}" class="btn btn-outline-secondary btn-sm">Reset Filter</a>
                    @endif
                </form>
            </div>
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
                    @foreach ($beritas as $berita)
                        <tr>
                            <td>{{ $berita->judul }}</td>
                            <td>{{ $berita->status }}</td>
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
                    @endforeach
                </tbody>
            </table>

            <div class="pagination">
                {{ $beritas->links() }}  <!-- Pagination untuk halaman berita -->
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
