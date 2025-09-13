<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Panel</title>
    @include('layouts.meta') <!-- Menyertakan meta tag -->
    @include('layouts.styles') <!-- Menyertakan CSS Styles -->
</head>
<body>

    <div class="admin-layout">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <div class="main-content">
            <div class="content-wrapper">
                @yield('content') <!-- Menampilkan konten halaman seperti dashboard atau index berita -->
            </div>
        </div>
    </div>

    @include('layouts.scripts')  <!-- Menyertakan JavaScript -->

    <style>
        /* Admin Layout Styles */
        .admin-layout {
            display: flex;
            min-height: 100vh;
            background-color: #f8fafc;
        }

        .main-content {
            flex: 1;
            margin-left: 0;
            transition: margin-left 0.3s ease;
        }

        .content-wrapper {
            padding: 30px;
            max-width: 100%;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .content-wrapper {
                padding: 20px 15px;
            }

            .main-content {
                margin-left: 0;
            }
        }

        @media (min-width: 769px) {
            .main-content {
                margin-left: 0;
            }
        }

        /* Override default Bootstrap container styles for better spacing */
        .container-fluid {
            padding: 0;
        }

        /* Ensure proper spacing for dashboard content */
        .dashboard-wrapper {
            margin: 0;
            padding: 0;
        }
    </style>
</body>
</html>
