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

    @include('layouts.navbar')  <!-- Menyertakan navbar -->
    
    <div class="d-flex">
        <!-- Sidebar -->
        @include('layouts.sidebar')
        
        <!-- Main Content -->
        <div class="container-fluid">
            @yield('content') <!-- Menampilkan konten halaman seperti dashboard atau index berita -->
        </div>
    </div>

    @include('layouts.scripts')  <!-- Menyertakan JavaScript -->
</body>
</html>
