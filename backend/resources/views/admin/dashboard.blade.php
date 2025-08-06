@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<div class="dashboard-container">
    <div class="card">
        <div class="card-header">
            <h4>Selamat Datang, {{ auth('admin')->user()->name }}</h4>
        </div>
        <div class="card-body">
            <div class="stats">
                <!-- Statistik Total Berita -->
                <div class="stat">
                    <h5>Total Berita</h5>
                    <p>{{ \App\Models\Berita::count() }}</p>
                    <a href="{{ route('admin.berita.index') }}" class="btn btn-outline-primary btn-sm mt-3">Lihat Detail</a>
                </div>

                <!-- Statistik Berita Terbit -->
                <div class="stat">
                    <h5>Berita Terbit</h5>
                    <p>{{ \App\Models\Berita::where('status', 'published')->count() }}</p>
                    <a href="{{ route('admin.berita.index') }}" class="btn btn-outline-primary btn-sm mt-3">Lihat Detail</a>
                </div>

                <!-- Statistik Berita Draft -->
                <div class="stat">
                    <h5>Berita Draft</h5>
                    <p>{{ \App\Models\Berita::where('status', 'draft')->count() }}</p>
                    <a href="{{ route('admin.berita.index') }}" class="btn btn-outline-primary btn-sm mt-3">Lihat Detail</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CSS Styling -->
<style>
    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f7fc;
    }

    .dashboard-container {
        padding: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    .card {
        width: 80%;
        max-width: 1200px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .card-header {
        background-color: #2d2f6e;
        color: white;
        padding: 15px;
        text-align: center;
    }

    .card-body {
        padding: 30px;
    }

    .stats {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        margin-top: 20px;
    }

    .stat {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        padding: 20px;
        width: 30%;
        text-align: center;
        transition: all 0.3s ease;
    }

    .stat:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
    }

    .stat h5 {
        font-size: 16px;
        color: #5f6368;
        margin-bottom: 10px;
    }

    .stat p {
        font-size: 30px;
        font-weight: 600;
        color: #2d2f6e;
        margin: 0;
    }

    .btn-outline-primary {
        font-size: 14px;
        padding: 6px 15px;
        border-radius: 25px;
        border: 2px solid #2d2f6e;
        color: #2d2f6e;
        text-transform: uppercase;
        transition: all 0.3s;
    }

    .btn-outline-primary:hover {
        background-color: #2d2f6e;
        color: white;
        border-color: #2d2f6e;
    }

    /* Responsiveness */
    @media (max-width: 768px) {
        .stats {
            flex-direction: column;
            align-items: center;
        }

        .stat {
            width: 100%;
            margin-bottom: 20px;
        }
    }
</style>
@endsection
