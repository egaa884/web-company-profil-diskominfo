@extends('layouts.admin')
@section('title', 'Daftar Profil')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Daftar Profil</h4>
            <a href="{{ route('admin.profil.create') }}" class="btn btn-primary">Tambah Profil</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>Judul</th>
                            <th>Tanggal</th>
                            <th>Konten</th>
                            <th>Gambar</th>
                            <th>PDF</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($profils as $index => $profil)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $profil->kategori }}</td>
                                <td>{{ $profil->title ?: '-' }}</td>
                                <td>{{ $profil->tanggal ? \Carbon\Carbon::parse($profil->tanggal)->format('d/m/Y') : '-' }}</td>
                                <td>
                                    @if($profil->konten)
                                        {{ Str::limit($profil->konten, 100) }}
                                    @else
                                        <span class="text-muted">Tidak ada konten</span>
                                    @endif
                                </td>
                                <td>
                                    @if($profil->gambar)
                                        <img src="{{ asset('storage/' . $profil->gambar) }}" alt="Gambar" class="img-thumbnail" style="max-width: 50px; max-height: 50px;">
                                    @else
                                        <span class="text-muted">Tidak ada gambar</span>
                                    @endif
                                </td>
                                <td>
                                    @if($profil->pdf)
                                        <a href="{{ asset('storage/' . $profil->pdf) }}" target="_blank" class="btn btn-sm btn-outline-primary">Download PDF</a>
                                    @else
                                        <span class="text-muted">Tidak ada PDF</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.profil.edit', $profil->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.profil.destroy', $profil->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus profil ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data profil</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 