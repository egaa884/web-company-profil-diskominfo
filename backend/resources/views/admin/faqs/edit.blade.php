@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Edit FAQ</h1>
    <form action="{{ route('admin.faqs.update', $faq) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Judul</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $faq->title }}" required>
        </div>
        <div class="mb-3">
            <label for="question" class="form-label">Pertanyaan</label>
            <input type="text" name="question" id="question" class="form-control" value="{{ $faq->question }}" required>
        </div>
        <div class="mb-3">
            <label for="answer" class="form-label">Jawaban</label>
            <textarea name="answer" id="answer" class="form-control" rows="4" required>{{ $faq->answer }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection 