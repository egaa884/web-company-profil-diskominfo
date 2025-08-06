@extends('layouts.admin')

@section('title', 'Daftar Infografis')

@section('content')
    <div class="container my-5">
        <h2 class="text-center mb-4">Infografis Terbaru</h2>
        
        <!-- Tombol untuk menambah infografis baru -->
        <div class="text-right mb-4">
            <a href="{{ route('admin.infografis.create') }}" class="btn btn-primary">Tambah Infografis</a>
        </div>

        <!-- Menampilkan daftar infografis -->
        <div class="row">
            @foreach ($infografis as $infografisItem)
                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm">
                        <!-- Menampilkan gambar infografis -->
                        <img src="{{ asset('storage/' . $infografisItem->gambar) }}" class="card-img-top" alt="Infografis">
                        <div class="card-body">
                            <!-- Menampilkan judul dan tanggal infografis -->
                            <h5 class="card-title">{{ $infografisItem->judul }}</h5>
                            <p class="card-text">{{ \Carbon\Carbon::parse($infografisItem->tanggal)->format('d M Y') }} | Admin</p>
                            
                            <!-- Tombol Edit dan Hapus -->
                            <a href="{{ route('admin.infografis.edit', $infografisItem) }}" class="btn btn-warning">Edit</a>

                            <!-- Form untuk menghapus infografis -->
                            <form action="{{ route('admin.infografis.destroy', $infografisItem) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
