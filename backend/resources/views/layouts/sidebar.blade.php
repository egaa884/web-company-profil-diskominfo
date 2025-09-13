<div class="sidebar-wrapper" id="sidebar-wrapper">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <i class="fas fa-cogs"></i>
            <span>Admin Panel</span>
        </div>
        <div class="user-info">
            <div class="user-avatar">
                <i class="fas fa-user-circle"></i>
            </div>
            <div class="user-details">
                <div class="user-name">{{ Auth::guard('admin')->user()->name }}</div>
                <div class="user-role">{{ ucfirst(Auth::guard('admin')->user()->role) }}</div>
            </div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <ul class="nav-list">
            @if(Auth::guard('admin')->user()->role === 'admin')
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
            @endif

            <li class="nav-item">
                <a href="{{ route('admin.berita.index') }}" class="nav-link {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}">
                    <i class="fas fa-newspaper"></i>
                    <span>Berita</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.comments.index') }}" class="nav-link {{ request()->routeIs('admin.comments.*') ? 'active' : '' }}">
                    <i class="fas fa-comments"></i>
                    <span>Komentar</span>
                    @if(\App\Models\Comment::where('is_approved', false)->count() > 0)
                        <span class="badge">{{ \App\Models\Comment::where('is_approved', false)->count() }}</span>
                    @endif
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.profil.index') }}" class="nav-link {{ request()->routeIs('admin.profil.*') ? 'active' : '' }}">
                    <i class="fas fa-building"></i>
                    <span>Profil</span>
                </a>
            </li>

            @if(Auth::guard('admin')->user()->role === 'admin')
                <li class="nav-item">
                    <a href="{{ route('admin.infografis.index') }}" class="nav-link {{ request()->routeIs('admin.infografis.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-bar"></i>
                        <span>Infografis</span>
                    </a>
                </li>
            @endif

            <li class="nav-item">
                <a href="{{ route('admin.publikasi.index') }}" class="nav-link {{ request()->routeIs('admin.publikasi.*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i>
                    <span>Publikasi</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.faqs.index') }}" class="nav-link {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">
                    <i class="fas fa-question-circle"></i>
                    <span>FAQ</span>
                </a>
            </li>
        </ul>
    </nav>

    <div class="sidebar-footer">
        <a href="{{ route('admin.logout') }}" class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</div>

<style>
/* Modern Sidebar Styles */
.sidebar-wrapper {
    width: 280px;
    min-height: 100vh;
    background: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
    color: #ecf0f1;
    display: flex;
    flex-direction: column;
    box-shadow: 2px 0 20px rgba(0,0,0,0.1);
    position: relative;
    overflow: hidden;
}

.sidebar-wrapper::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #3498db, #2980b9, #1abc9c);
}

/* Sidebar Header */
.sidebar-header {
    padding: 25px 20px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    background: rgba(255,255,255,0.05);
}

.sidebar-logo {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

.sidebar-logo i {
    font-size: 24px;
    color: #3498db;
    margin-right: 12px;
}

.sidebar-logo span {
    font-size: 18px;
    font-weight: 700;
    color: #ecf0f1;
}

.user-info {
    display: flex;
    align-items: center;
}

.user-avatar {
    margin-right: 12px;
}

.user-avatar i {
    font-size: 32px;
    color: #bdc3c7;
}

.user-details {
    flex: 1;
}

.user-name {
    font-size: 14px;
    font-weight: 600;
    color: #ecf0f1;
    margin-bottom: 2px;
}

.user-role {
    font-size: 12px;
    color: #95a5a6;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Navigation */
.sidebar-nav {
    flex: 1;
    padding: 20px 0;
}

.nav-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.nav-item {
    margin-bottom: 5px;
}

.nav-link {
    display: flex;
    align-items: center;
    padding: 12px 20px;
    color: #bdc3c7;
    text-decoration: none;
    transition: all 0.3s ease;
    border-radius: 0 25px 25px 0;
    margin-right: 10px;
    position: relative;
}

.nav-link:hover {
    background: rgba(255,255,255,0.1);
    color: #ecf0f1;
    transform: translateX(5px);
}

.nav-link.active {
    background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
    color: #ffffff;
    box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
}

.nav-link.active::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 4px;
    height: 60%;
    background: #ffffff;
    border-radius: 0 2px 2px 0;
}

.nav-link i {
    width: 20px;
    margin-right: 12px;
    font-size: 16px;
    text-align: center;
}

.nav-link span {
    flex: 1;
    font-size: 14px;
    font-weight: 500;
}

.badge {
    background: #e74c3c;
    color: white;
    border-radius: 10px;
    padding: 2px 8px;
    font-size: 11px;
    font-weight: 600;
    margin-left: 8px;
    animation: pulse 2s infinite;
}

/* Sidebar Footer */
.sidebar-footer {
    padding: 20px;
    border-top: 1px solid rgba(255,255,255,0.1);
}

.logout-btn {
    display: flex;
    align-items: center;
    padding: 12px 16px;
    background: rgba(231, 76, 60, 0.1);
    color: #e74c3c;
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.3s ease;
    border: 1px solid rgba(231, 76, 60, 0.2);
}

.logout-btn:hover {
    background: #e74c3c;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
}

.logout-btn i {
    margin-right: 10px;
    font-size: 14px;
}

.logout-btn span {
    font-size: 14px;
    font-weight: 500;
}

/* Animations */
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

/* Responsive Design */
@media (max-width: 768px) {
    .sidebar-wrapper {
        width: 100%;
        min-height: auto;
        position: fixed;
        top: 0;
        left: -100%;
        z-index: 1000;
        transition: left 0.3s ease;
    }

    .sidebar-wrapper.show {
        left: 0;
    }

    .sidebar-header {
        padding: 20px;
    }

    .sidebar-logo span {
        font-size: 16px;
    }

    .nav-link {
        padding: 15px 20px;
    }

    .nav-link span {
        font-size: 16px;
    }
}

@media (max-width: 480px) {
    .sidebar-wrapper {
        width: 100%;
    }

    .nav-link {
        padding: 12px 15px;
    }

    .nav-link i {
        width: 18px;
        margin-right: 10px;
    }

    .nav-link span {
        font-size: 14px;
    }
}
</style>