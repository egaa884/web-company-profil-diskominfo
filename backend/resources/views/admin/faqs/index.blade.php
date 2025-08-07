@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>FAQ</h1>
    <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary mb-3">Tambah FAQ</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Judul</th>
                <th>Pertanyaan</th>
                <th>Jawaban</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($faqs as $faq)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $faq->title }}</td>
                <td>{{ $faq->question }}</td>
                <td>{{ Str::limit(strip_tags($faq->answer), 50) }}</td>
                <td>
                    <a href="{{ route('admin.faqs.edit', $faq) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection 