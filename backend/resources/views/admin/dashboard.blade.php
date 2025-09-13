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

    <!-- Statistics Charts -->
    <div class="statistics-charts">
        <div class="charts-header">
            <h2 class="charts-title">
                <i class="fas fa-chart-line"></i>
                Analisis Data & Statistik
            </h2>
            <div class="charts-meta">
                <small class="text-muted">
                    <i class="fas fa-clock"></i>
                    Data terakhir diperbarui: {{ now()->format('d M Y H:i') }}
                </small>
            </div>
        </div>

        <!-- Charts Container -->
        <div class="charts-container">
            <!-- Main Statistics Chart -->
            <div class="chart-card">
                <div class="chart-header">
                    <h4><i class="fas fa-chart-pie"></i> Distribusi Konten</h4>
                </div>
                <div class="chart-content">
                    <canvas id="contentChart" width="400" height="300"></canvas>
                </div>
            </div>

            <!-- Berita Status Chart -->
            <div class="chart-card">
                <div class="chart-header">
                    <h4><i class="fas fa-newspaper"></i> Status Berita</h4>
                </div>
                <div class="chart-content">
                    <canvas id="beritaChart" width="400" height="300"></canvas>
                </div>
            </div>

            <!-- Comments Chart -->
            <div class="chart-card">
                <div class="chart-header">
                    <h4><i class="fas fa-comments"></i> Status Komentar</h4>
                </div>
                <div class="chart-content">
                    <canvas id="commentsChart" width="400" height="300"></canvas>
                </div>
            </div>

            <!-- Monthly Trend Chart -->
            <div class="chart-card chart-card-large">
                <div class="chart-header">
                    <h4><i class="fas fa-calendar-alt"></i> Tren Bulanan</h4>
                </div>
                <div class="chart-content">
                    <canvas id="monthlyChart" width="800" height="300"></canvas>
                </div>
            </div>

            <!-- Views Chart -->
            <div class="chart-card">
                <div class="chart-header">
                    <h4><i class="fas fa-eye"></i> Analisis Pengunjung</h4>
                </div>
                <div class="chart-content">
                    <canvas id="viewsChart" width="400" height="300"></canvas>
                </div>
            </div>

            <!-- Reports Chart -->
            <div class="chart-card">
                <div class="chart-header">
                    <h4><i class="fas fa-file-alt"></i> Status Laporan</h4>
                </div>
                <div class="chart-content">
                    <canvas id="reportsChart" width="400" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Statistics Summary Cards -->
        <div class="stats-summary">
            <div class="summary-row">
                <div class="summary-item">
                    <div class="summary-value">{{ \App\Models\Berita::count() }}</div>
                    <div class="summary-label">Total Berita</div>
                </div>
                <div class="summary-item">
                    <div class="summary-value">{{ \App\Models\Comment::count() }}</div>
                    <div class="summary-label">Total Komentar</div>
                </div>
                <div class="summary-item">
                    <div class="summary-value">{{ \App\Models\LaporanPengaduanAdmin::count() }}</div>
                    <div class="summary-label">Laporan Pengaduan</div>
                </div>
                <div class="summary-item">
                    <div class="summary-value">{{ number_format(\App\Models\Berita::sum('views')) }}</div>
                    <div class="summary-label">Total Views</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Original Statistics Cards -->
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

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Initialize charts when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Color scheme matching dashboard theme
    const colors = {
        primary: '#667eea',
        secondary: '#764ba2',
        success: '#48bb78',
        info: '#17a2b8',
        warning: '#ffc107',
        danger: '#dc3545',
        light: '#f8f9fa',
        dark: '#2d3748'
    };

    // Content Distribution Chart
    const contentChart = new Chart(document.getElementById('contentChart'), {
        type: 'doughnut',
        data: {
            labels: ['Berita', 'Komentar', 'Laporan', 'Admin'],
            datasets: [{
                data: [
                    {{ \App\Models\Berita::count() }},
                    {{ \App\Models\Comment::count() }},
                    {{ \App\Models\LaporanPengaduanAdmin::count() }},
                    {{ \App\Models\Admin::count() }}
                ],
                backgroundColor: [
                    colors.primary,
                    colors.success,
                    colors.info,
                    colors.secondary
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });

    // Berita Status Chart
    const beritaChart = new Chart(document.getElementById('beritaChart'), {
        type: 'bar',
        data: {
            labels: ['Published', 'Draft', 'Hot News'],
            datasets: [{
                label: 'Jumlah Berita',
                data: [
                    {{ \App\Models\Berita::where('status', 'published')->count() }},
                    {{ \App\Models\Berita::where('status', 'draft')->count() }},
                    {{ \App\Models\Berita::where('is_hot', true)->count() }}
                ],
                backgroundColor: [
                    colors.success,
                    colors.warning,
                    colors.danger
                ],
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Comments Chart
    const commentsChart = new Chart(document.getElementById('commentsChart'), {
        type: 'pie',
        data: {
            labels: ['Approved', 'Pending'],
            datasets: [{
                data: [
                    {{ \App\Models\Comment::where('is_approved', true)->count() }},
                    {{ \App\Models\Comment::where('is_approved', false)->count() }}
                ],
                backgroundColor: [
                    colors.success,
                    colors.warning
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                }
            }
        }
    });

    // Monthly Trend Chart
    const monthlyChart = new Chart(document.getElementById('monthlyChart'), {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Berita',
                data: [
                    {{ \App\Models\Berita::whereYear('created_at', now()->year)->whereMonth('created_at', 1)->count() }},
                    {{ \App\Models\Berita::whereYear('created_at', now()->year)->whereMonth('created_at', 2)->count() }},
                    {{ \App\Models\Berita::whereYear('created_at', now()->year)->whereMonth('created_at', 3)->count() }},
                    {{ \App\Models\Berita::whereYear('created_at', now()->year)->whereMonth('created_at', 4)->count() }},
                    {{ \App\Models\Berita::whereYear('created_at', now()->year)->whereMonth('created_at', 5)->count() }},
                    {{ \App\Models\Berita::whereYear('created_at', now()->year)->whereMonth('created_at', 6)->count() }},
                    {{ \App\Models\Berita::whereYear('created_at', now()->year)->whereMonth('created_at', 7)->count() }},
                    {{ \App\Models\Berita::whereYear('created_at', now()->year)->whereMonth('created_at', 8)->count() }},
                    {{ \App\Models\Berita::whereYear('created_at', now()->year)->whereMonth('created_at', 9)->count() }},
                    {{ \App\Models\Berita::whereYear('created_at', now()->year)->whereMonth('created_at', 10)->count() }},
                    {{ \App\Models\Berita::whereYear('created_at', now()->year)->whereMonth('created_at', 11)->count() }},
                    {{ \App\Models\Berita::whereYear('created_at', now()->year)->whereMonth('created_at', 12)->count() }}
                ],
                borderColor: colors.primary,
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: colors.primary,
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }, {
                label: 'Komentar',
                data: [
                    {{ \App\Models\Comment::whereYear('created_at', now()->year)->whereMonth('created_at', 1)->count() }},
                    {{ \App\Models\Comment::whereYear('created_at', now()->year)->whereMonth('created_at', 2)->count() }},
                    {{ \App\Models\Comment::whereYear('created_at', now()->year)->whereMonth('created_at', 3)->count() }},
                    {{ \App\Models\Comment::whereYear('created_at', now()->year)->whereMonth('created_at', 4)->count() }},
                    {{ \App\Models\Comment::whereYear('created_at', now()->year)->whereMonth('created_at', 5)->count() }},
                    {{ \App\Models\Comment::whereYear('created_at', now()->year)->whereMonth('created_at', 6)->count() }},
                    {{ \App\Models\Comment::whereYear('created_at', now()->year)->whereMonth('created_at', 7)->count() }},
                    {{ \App\Models\Comment::whereYear('created_at', now()->year)->whereMonth('created_at', 8)->count() }},
                    {{ \App\Models\Comment::whereYear('created_at', now()->year)->whereMonth('created_at', 9)->count() }},
                    {{ \App\Models\Comment::whereYear('created_at', now()->year)->whereMonth('created_at', 10)->count() }},
                    {{ \App\Models\Comment::whereYear('created_at', now()->year)->whereMonth('created_at', 11)->count() }},
                    {{ \App\Models\Comment::whereYear('created_at', now()->year)->whereMonth('created_at', 12)->count() }}
                ],
                borderColor: colors.success,
                backgroundColor: 'rgba(72, 187, 120, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: colors.success,
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
                }
            }
        }
    });

    // Views Chart
    const viewsChart = new Chart(document.getElementById('viewsChart'), {
        type: 'bar',
        data: {
            labels: ['Total Views', 'Rata-rata per Berita'],
            datasets: [{
                label: 'Views',
                data: [
                    {{ \App\Models\Berita::sum('views') }},
                    {{ \App\Models\Berita::avg('views') ?: 0 }}
                ],
                backgroundColor: [
                    colors.info,
                    colors.primary
                ],
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    },
                    ticks: {
                        callback: function(value) {
                            if (value >= 1000) {
                                return (value / 1000).toFixed(1) + 'K';
                            }
                            return value;
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Reports Chart
    const reportsChart = new Chart(document.getElementById('reportsChart'), {
        type: 'doughnut',
        data: {
            labels: ['Dipublikasi', 'Draft'],
            datasets: [{
                data: [
                    {{ \App\Models\LaporanPengaduanAdmin::where('is_published', true)->count() }},
                    {{ \App\Models\LaporanPengaduanAdmin::where('is_published', false)->count() }}
                ],
                backgroundColor: [
                    colors.success,
                    colors.secondary
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                }
            }
        }
    });
});
</script>

<style>
/* Statistics Charts Styles */
.statistics-charts {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 30px;
    margin-bottom: 40px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    position: relative;
    overflow: hidden;
}

.statistics-charts::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #667eea, #764ba2);
}

.charts-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 1px solid #e9ecef;
}

.charts-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2d3748;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.charts-title i {
    color: #667eea;
}

.charts-meta {
    text-align: right;
}

.charts-meta small {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #718096;
    font-size: 0.875rem;
}

.charts-meta i {
    color: #a0aec0;
}

/* Charts Container */
.charts-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 25px;
    margin-bottom: 30px;
}

.chart-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border: 1px solid #e9ecef;
    overflow: hidden;
    transition: all 0.3s ease;
}

.chart-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
}

.chart-card-large {
    grid-column: 1 / -1;
}

.chart-header {
    padding: 20px 25px;
    background: linear-gradient(135deg, #f8f9fa, #ffffff);
    border-bottom: 1px solid #e9ecef;
}

.chart-header h4 {
    margin: 0;
    font-size: 1.1rem;
    font-weight: 600;
    color: #2d3748;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.chart-header i {
    color: #667eea;
}

.chart-content {
    padding: 25px;
    position: relative;
    min-height: 300px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Statistics Summary */
.stats-summary {
    background: white;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border: 1px solid #e9ecef;
}

.summary-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

.summary-item {
    text-align: center;
    padding: 20px;
    background: linear-gradient(135deg, #f8f9fa, #ffffff);
    border-radius: 12px;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.summary-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

.summary-value {
    font-size: 2rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 5px;
    display: block;
}

.summary-label {
    font-size: 0.9rem;
    color: #718096;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Chart.js Custom Styles */
.chartjs-render-monitor {
    max-width: 100% !important;
    max-height: 100% !important;
}

/* Responsive Design */
@media (max-width: 768px) {
    .statistics-charts {
        padding: 20px;
        margin-bottom: 30px;
    }

    .charts-header {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }

    .charts-title {
        font-size: 1.3rem;
    }

    .charts-container {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .chart-card-large {
        grid-column: 1;
    }

    .chart-content {
        padding: 20px;
        min-height: 250px;
    }

    .summary-row {
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .summary-item {
        padding: 15px;
    }

    .summary-value {
        font-size: 1.5rem;
    }
}

@media (max-width: 576px) {
    .charts-container {
        grid-template-columns: 1fr;
    }

    .summary-row {
        grid-template-columns: 1fr;
    }

    .chart-content {
        padding: 15px;
        min-height: 200px;
    }

    .summary-item {
        padding: 12px;
    }
}

/* Animation */
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

.statistics-charts {
    animation: fadeInUp 0.6s ease-out;
}

.chart-card:nth-child(1) { animation-delay: 0.1s; }
.chart-card:nth-child(2) { animation-delay: 0.2s; }
.chart-card:nth-child(3) { animation-delay: 0.3s; }
.chart-card:nth-child(4) { animation-delay: 0.4s; }
.chart-card:nth-child(5) { animation-delay: 0.5s; }
.chart-card:nth-child(6) { animation-delay: 0.6s; }

.chart-card {
    animation: fadeInUp 0.6s ease-out;
    animation-fill-mode: both;
}

.stats-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 1px solid #e9ecef;
}

.stats-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2d3748;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.stats-title i {
    color: #667eea;
}

.stats-meta {
    text-align: right;
}

.stats-meta small {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #718096;
    font-size: 0.875rem;
}

.stats-meta i {
    color: #a0aec0;
}

/* Statistics Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 25px;
    margin-bottom: 30px;
}

.stat-card {
    background: white;
    border-radius: 16px;
    padding: 25px;
    display: flex;
    align-items: center;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    border: 1px solid #e9ecef;
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

.stat-card-primary::before { background: linear-gradient(90deg, #667eea, #764ba2); }
.stat-card-success::before { background: linear-gradient(90deg, #48bb78, #38a169); }
.stat-card-info::before { background: linear-gradient(90deg, #17a2b8, #138496); }
.stat-card-warning::before { background: linear-gradient(90deg, #ffc107, #e0a800); }
.stat-card-secondary::before { background: linear-gradient(90deg, #6c757d, #545b62); }
.stat-card-danger::before { background: linear-gradient(90deg, #dc3545, #c82333); }

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    margin-right: 20px;
    flex-shrink: 0;
}

.stat-card-primary .stat-icon { background: linear-gradient(135deg, #667eea, #764ba2); color: white; }
.stat-card-success .stat-icon { background: linear-gradient(135deg, #48bb78, #38a169); color: white; }
.stat-card-info .stat-icon { background: linear-gradient(135deg, #17a2b8, #138496); color: white; }
.stat-card-warning .stat-icon { background: linear-gradient(135deg, #ffc107, #e0a800); color: white; }
.stat-card-secondary .stat-icon { background: linear-gradient(135deg, #6c757d, #545b62); color: white; }
.stat-card-danger .stat-icon { background: linear-gradient(135deg, #dc3545, #c82333); color: white; }

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
    margin-bottom: 8px;
}

.stat-breakdown {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.stat-breakdown span {
    font-size: 0.8rem;
    font-weight: 500;
}

.stat-published { color: #48bb78; }
.stat-draft { color: #ed8936; }
.stat-approved { color: #48bb78; }
.stat-pending { color: #ed8936; }
.stat-completed { color: #48bb78; }
.stat-views { color: #4299e1; }
.stat-active { color: #48bb78; }
.stat-hot { color: #ff6b6b; }

/* Recent Activity Summary */
.recent-summary {
    background: white;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border: 1px solid #e9ecef;
}

.summary-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

.summary-card {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.summary-card:hover {
    background: #e9ecef;
    transform: translateY(-2px);
}

.summary-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 16px;
    flex-shrink: 0;
}

.summary-content h4 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2d3748;
    margin: 0 0 2px 0;
    line-height: 1;
}

.summary-content p {
    font-size: 0.8rem;
    color: #718096;
    margin: 0;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .statistics-overview {
        padding: 20px;
        margin-bottom: 30px;
    }

    .stats-header {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }

    .stats-title {
        font-size: 1.3rem;
    }

    .stats-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .stat-card {
        padding: 20px;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        font-size: 20px;
        margin-right: 15px;
    }

    .stat-number {
        font-size: 2rem;
    }

    .summary-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .summary-card {
        padding: 12px;
        gap: 12px;
    }

    .summary-icon {
        width: 35px;
        height: 35px;
        font-size: 14px;
    }

    .summary-content h4 {
        font-size: 1.3rem;
    }
}

@media (max-width: 576px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }

    .summary-grid {
        grid-template-columns: 1fr;
    }

    .stat-card {
        flex-direction: column;
        text-align: center;
    }

    .stat-icon {
        margin-right: 0;
        margin-bottom: 15px;
    }

    .stat-content {
        text-align: center;
    }

    .summary-card {
        justify-content: center;
    }
}

/* Animation */
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

.statistics-overview {
    animation: fadeInUp 0.6s ease-out;
}

.stat-card:nth-child(1) { animation-delay: 0.1s; }
.stat-card:nth-child(2) { animation-delay: 0.2s; }
.stat-card:nth-child(3) { animation-delay: 0.3s; }
.stat-card:nth-child(4) { animation-delay: 0.4s; }
.stat-card:nth-child(5) { animation-delay: 0.5s; }
.stat-card:nth-child(6) { animation-delay: 0.6s; }

.stat-card {
    animation: fadeInUp 0.6s ease-out;
    animation-fill-mode: both;
}
</style>
