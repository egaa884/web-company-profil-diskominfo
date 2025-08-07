@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Tambah FAQ</h1>
    <form action="{{ route('admin.faqs.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Judul</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="question" class="form-label">Pertanyaan</label>
            <input type="text" name="question" id="question" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="answer" class="form-label">Jawaban</label>
            <textarea name="answer" id="answer" class="form-control" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection 