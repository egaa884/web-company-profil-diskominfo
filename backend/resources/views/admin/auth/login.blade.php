r<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Login Admin Kominfo</title>

<!-- Link ke font Google -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet" />

<style>
  /* Reset dasar */
  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }

  /* Container latar belakang di luar body */
  #background-container {
    position: fixed; /* agar tetap di belakang */
    top: 0;
    left: 0;
    width: 100vw; /* penuh lebar viewport */
    height: 100vh; /* penuh tinggi viewport */
    z-index: -1; /* di belakang semua elemen lain */
    background-image: url('/image/kominfobaru.png'); /* ganti dengan gambar latar belakang kamu */
    background-size: cover;
    background-position: center;
  }

  /* Body utama dan konten */
  body {
    font-family: 'Poppins', sans-serif;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    margin: 0;
    position: relative;
    z-index: 1; /* pastikan berada di atas latar belakang */
    color: #fff;
  }

  /* Card login modern */
  .login-card {
    background: rgba(255, 255, 255, 0.85);
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    max-width: 400px;
    width: 90%;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .login-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.3);
  }

  .login-card h3 {
    font-size: 28px;
    margin-bottom: 25px;
    color: #333;
  }

  /* Input dan label */
  .form-label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #333;
  }

  .form-control {
    width: 100%;
    padding: 15px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 16px;
    margin-bottom: 20px;
    transition: border-color 0.3s, box-shadow 0.3s;
  }

  .form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 8px rgba(0,123,255,0.3);
    outline: none;
  }

  /* Tombol login */
  .btn-primary {
    width: 100%;
    padding: 15px;
    background-color: #007bff;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  .btn-primary:hover {
    background-color: #0056b3;
  }

  /* Pesan error */
  .alert {
    margin-top: 15px;
    padding: 12px 20px;
    background-color: #f8d7da;
    color: #721c24;
    border-radius: 6px;
    border: 1px solid #f5c6cb;
    font-size: 14px;
  }


  /* Responsiveness */
  @media(max-width: 576px) {
    .login-card {
      padding: 30px 20px;
    }

    .login-card h3 {
      font-size: 24px;
    }
  }
</style>
</head>
<body>

<!-- Elemen latar belakang di luar body -->
<div id="background-container"></div>

<!-- Konten login -->
<div class="login-card">
  <h3>Login Admin</h3>

  <!-- Pesan error -->
  @if (session('error'))
    <div class="alert">{{ session('error') }}</div>
  @endif

  <form method="POST" action="{{ route('admin.login') }}">
    @csrf
    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" id="email" name="email" class="form-control" required autofocus>
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" id="password" name="password" class="form-control" required>
    </div>
    <button type="submit" class="btn-primary">Login</button>
  </form>
</div>

</body>
</html>