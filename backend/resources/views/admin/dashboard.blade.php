@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<div class="dashboard-wrapper">
    <!-- Welcome Section -->
    <div class="welcome-section">
        <div class="welcome-content">
            <h1 class="welcome-title">Selamat Datang, {{ auth('admin')->user()->name }}</h1>
            <p class="welcome-subtitle">Dashboard Admin Komunikasi dan Informatika Madiun</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <!-- Total Berita -->
        <div class="stat-card stat-card-primary">
            <div class="stat-icon">
                <i class="fas fa-newspaper"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ \App\Models\Berita::count() }}</h3>
                <p class="stat-label">Total Berita</p>
            </div>
            <div class="stat-action">
                <a href="{{ route('admin.berita.index') }}" class="stat-link">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Berita Terbit -->
        <div class="stat-card stat-card-success">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ \App\Models\Berita::where('status', 'published')->count() }}</h3>
                <p class="stat-label">Berita Terbit</p>
            </div>
            <div class="stat-action">
                <a href="{{ route('admin.berita.index') }}" class="stat-link">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Berita Draft -->
        <div class="stat-card stat-card-warning">
            <div class="stat-icon">
                <i class="fas fa-edit"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ \App\Models\Berita::where('status', 'draft')->count() }}</h3>
                <p class="stat-label">Berita Draft</p>
            </div>
            <div class="stat-action">
                <a href="{{ route('admin.berita.index') }}" class="stat-link">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Total Pengunjung -->
        <div class="stat-card stat-card-info">
            <div class="stat-icon">
                <i class="fas fa-eye"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ number_format(\App\Models\Berita::sum('views')) }}</h3>
                <p class="stat-label">Total Pengunjung</p>
            </div>
            <div class="stat-action">
                <a href="{{ route('admin.berita.index') }}" class="stat-link">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Laporan Pengaduan -->
        <div class="stat-card stat-card-danger">
            <div class="stat-icon">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ \App\Models\LaporanPengaduanAdmin::count() }}</h3>
                <p class="stat-label">Laporan Pengaduan</p>
            </div>
            <div class="stat-action">
                <a href="{{ route('admin.laporan-pengaduan-admin.index') }}" class="stat-link">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Hot News -->
        <div class="stat-card stat-card-hot">
            <div class="stat-icon">
                <i class="fas fa-fire"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ \App\Models\Berita::where('is_hot', true)->count() }}</h3>
                <p class="stat-label">Hot News</p>
            </div>
            <div class="stat-action">
                <a href="{{ route('admin.berita.index') }}" class="stat-link">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Total Comments -->
        <div class="stat-card stat-card-comments">
            <div class="stat-icon">
                <i class="fas fa-comments"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ \App\Models\Comment::count() }}</h3>
                <p class="stat-label">Total Komentar</p>
            </div>
            <div class="stat-action">
                <a href="{{ route('admin.comments.index') }}" class="stat-link">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Pending Comments -->
        <div class="stat-card stat-card-pending">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ \App\Models\Comment::where('is_approved', false)->count() }}</h3>
                <p class="stat-label">Menunggu Moderasi</p>
            </div>
            <div class="stat-action">
                <a href="{{ route('admin.comments.index', ['status' => 'pending']) }}" class="stat-link">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <h2 class="section-title">Aksi Cepat</h2>
        <div class="actions-grid">
            <a href="{{ route('admin.berita.create') }}" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-plus"></i>
                </div>
                <div class="action-content">
                    <h4>Tambah Berita</h4>
                    <p>Buat berita baru</p>
                </div>
            </a>

            <a href="{{ route('admin.berita.index') }}" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-list"></i>
                </div>
                <div class="action-content">
                    <h4>Kelola Berita</h4>
                    <p>Lihat dan edit berita</p>
                </div>
            </a>

            <a href="{{ route('admin.laporan-pengaduan-admin.index') }}" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="action-content">
                    <h4>Laporan Pengaduan</h4>
                    <p>Kelola laporan masyarakat</p>
                </div>
            </a>

            <a href="{{ route('admin.publikasi.index') }}" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-upload"></i>
                </div>
                <div class="action-content">
                    <h4>Publikasi</h4>
                    <p>Kelola dokumen publik</p>
                </div>
            </a>

            <a href="{{ route('admin.comments.index') }}" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-comments"></i>
                </div>
                <div class="action-content">
                    <h4>Kelola Komentar</h4>
                    <p>Semua komentar pengunjung</p>
                </div>
            </a>

            <a href="{{ route('admin.comments.index', ['status' => 'pending']) }}" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="action-content">
                    <h4>Komentar Ditolak</h4>
                    <p>Komentar yang perlu ditinjau</p>
                </div>
            </a>

            <a href="{{ route('admin.comments.index', ['status' => 'approved']) }}" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="action-content">
                    <h4>Komentar Disetujui</h4>
                    <p>Komentar yang sudah disetujui</p>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Modern CSS Styling -->
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        color: #333;
    }

    .dashboard-wrapper {
        padding: 20px;
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Welcome Section */
    .welcome-section {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 40px;
        margin-bottom: 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }

    .welcome-content h1 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 10px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .welcome-subtitle {
        font-size: 1.1rem;
        color: #718096;
        font-weight: 400;
    }


    /* Statistics Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
        margin-bottom: 50px;
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #667eea, #764ba2);
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-right: 20px;
    }

    .stat-card-primary .stat-icon {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .stat-card-success .stat-icon {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        color: white;
    }

    .stat-card-warning .stat-icon {
        background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);
        color: white;
    }

    .stat-card-info .stat-icon {
        background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
        color: white;
    }

    .stat-card-danger .stat-icon {
        background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
        color: white;
    }

    .stat-card-hot .stat-icon {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
        color: white;
    }

    .stat-card-comments .stat-icon {
        background: linear-gradient(135deg, #9f7aea 0%, #805ad5 100%);
        color: white;
    }

    .stat-card-pending .stat-icon {
        background: linear-gradient(135deg, #fbb6ce 0%, #ed64a6 100%);
        color: white;
    }

    .stat-content {
        flex: 1;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 5px;
        line-height: 1;
    }

    .stat-label {
        font-size: 1rem;
        color: #718096;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-action {
        opacity: 0.7;
        transition: opacity 0.3s ease;
    }

    .stat-card:hover .stat-action {
        opacity: 1;
    }

    .stat-link {
        color: #718096;
        text-decoration: none;
        font-size: 18px;
        transition: color 0.3s ease;
    }

    .stat-link:hover {
        color: #667eea;
    }

    /* Quick Actions */
    .quick-actions {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }

    .section-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 30px;
        text-align: center;
    }

    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 25px;
    }

    .action-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        text-decoration: none;
        color: inherit;
        display: flex;
        align-items: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid #e2e8f0;
    }

    .action-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        border-color: #667eea;
    }

    .action-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
        margin-right: 20px;
        flex-shrink: 0;
    }

    .action-content h4 {
        font-size: 1.2rem;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 5px;
    }

    .action-content p {
        font-size: 0.9rem;
        color: #718096;
        margin: 0;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .dashboard-wrapper {
            padding: 15px;
        }

        .welcome-section {
            flex-direction: column;
            text-align: center;
            padding: 30px;
        }

        .welcome-content h1 {
            font-size: 2rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .quick-actions {
            padding: 30px 20px;
        }

        .actions-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .stat-card {
            padding: 20px;
        }

        .stat-number {
            font-size: 2rem;
        }
    }

    @media (max-width: 480px) {
        .welcome-content h1 {
            font-size: 1.8rem;
        }

        .stat-card {
            flex-direction: column;
            text-align: center;
        }

        .stat-icon {
            margin-right: 0;
            margin-bottom: 15px;
        }

        .action-card {
            flex-direction: column;
            text-align: center;
        }

        .action-icon {
            margin-right: 0;
            margin-bottom: 15px;
        }
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .welcome-section,
    .stat-card,
    .action-card {
        animation: fadeInUp 0.6s ease-out;
    }

    .stat-card:nth-child(1) { animation-delay: 0.1s; }
    .stat-card:nth-child(2) { animation-delay: 0.2s; }
    .stat-card:nth-child(3) { animation-delay: 0.3s; }
    .stat-card:nth-child(4) { animation-delay: 0.4s; }
    .stat-card:nth-child(5) { animation-delay: 0.5s; }
    .stat-card:nth-child(6) { animation-delay: 0.6s; }

    .action-card:nth-child(1) { animation-delay: 0.1s; }
    .action-card:nth-child(2) { animation-delay: 0.2s; }
    .action-card:nth-child(3) { animation-delay: 0.3s; }
    .action-card:nth-child(4) { animation-delay: 0.4s; }
</style>
@endsection
