<div class="sidebar-wrapper" id="sidebar-wrapper" style="min-width: 220px;">
    <div class="sidebar-header">
        <h4 class="sidebar-title">Menu</h4>
        <small class="text-light">{{ Auth::guard('admin')->user()->name }} ({{ ucfirst(Auth::guard('admin')->user()->role) }})</small>
    </div>
    <ul class="sidebar-menu list-unstyled">
        @if(Auth::guard('admin')->user()->role === 'admin')
            <li><a href="{{ route('admin.dashboard') }}" class="sidebar-link">Dashboard</a></li>
        @endif
        <li><a href="{{ route('admin.berita.index') }}" class="sidebar-link">Berita</a></li>
        <li><a href="{{ route('admin.profil.index') }}" class="sidebar-link">Profil</a></li>
        @if(Auth::guard('admin')->user()->role === 'admin')
            <li><a href="{{ route('admin.infografis.index') }}" class="sidebar-link">Infografis</a></li>
        @endif
        <li><a href="{{ route('admin.publikasi.index') }}" class="sidebar-link">Publikasi</a></li>
        <li><a href="{{ route('admin.faqs.index') }}" class="sidebar-link">FAQ</a></li>
    </ul>
</div>

<style>
/* Container sidebar */
.sidebar-wrapper {
    background-color: #2c3e50; /* Warna gelap modern */
    color: #ecf0f1; /* Warna teks terang */
    height: 100vh;
    padding: 20px;
    box-shadow: 2px 0 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    border-radius: 8px;
}

/* Header sidebar */
.sidebar-header {
    margin-bottom: 30px;
    text-align: center;
}
.sidebar-title {
    margin: 0;
    font-size: 1.4em;
    font-weight: 700;
    letter-spacing: 1px;
    color: #fff;
}

/* Daftar menu */
.sidebar-menu {
    display: flex;
    flex-direction: column;
}
.sidebar-link {
    display: block;
    padding: 12px 20px;
    border-radius: 8px;
    color: #ecf0f1;
    font-size: 1em;
    transition: background-color 0.2s, transform 0.2s;
    text-decoration: none;
}
.sidebar-link:hover {
    background-color: #34495e; /* Warna hover yang lebih lembut */
    transform: translateX(5px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
.sidebar-link:active {
    background-color: #3b5998;
}

/* Responsif */
@media(max-width: 768px) {
    #sidebar-wrapper {
        min-width: 180px;
        padding: 15px;
    }
    .sidebar-title {
        font-size: 1.2em;
    }
}
</style>