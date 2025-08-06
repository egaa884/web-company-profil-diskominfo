<nav class="navbar navbar-expand-lg navbar-custom border-bottom">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
              <img src="{{ asset('image/logo.png') }}" alt="Logo" width="43" height="40" class="d-inline-block align-middle mr-2">
            ADMIN KOMINFO</a>
        <div class="d-flex align-items-center">
            <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                @csrf
                <button class="btn btn-sm btn-outline-danger">Logout</button>
            </form>
        </div>
    </div>
</nav>

<style>
/* Navbar dasar */
.navbar-custom {
    background-color: #ffffff; /* Warna latar modern bersih */
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    transition: background-color 0.3s, box-shadow 0.3s;
}

/* Hover efek untuk navbar (opsional) */
.navbar-custom:hover {
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

/* Logo dan brand */
.navbar-brand {
    font-size: 1.5em;
    font-weight: 600;
    color: #2c3e50;
    letter-spacing: 1px;
    transition: color 0.3s;
}
.navbar-brand:hover {
    color: #2980b9;
}

/* Tombol logout */
.btn-outline-danger {
    border-radius: 50px;
    padding: 5px 15px;
    font-weight: 500;
    transition: all 0.2s;
}
.btn-outline-danger:hover {
    background-color: #dc3545;
    color: #fff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

/* Responsif: kecilkan teks dan padding di layar kecil */
@media(max-width: 768px) {
    .navbar-brand {
        font-size: 1.2em;
    }
}
</style>