@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Kategori FAQ</h1>
    <form action="{{ route('admin.faq-categories.update', $faqCategory) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nama Kategori</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $faqCategory->name }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.faq-categories.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection 