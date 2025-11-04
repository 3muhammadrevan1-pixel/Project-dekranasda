<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Dekranasda Kota Bogor</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font & Icon -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #ffffff;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0;
      overflow: hidden;
      position: relative;
    }

     .alert-custom-danger {
        background-color: #f8d7da; /* Warna background merah muda */
        color: #721c24; /* Warna teks merah tua */
        border: 1px solid #f5c6cb; /* Border merah muda */
        padding: 1rem;
        border-radius: 12px; /* Disesuaikan dengan alert lain */
        margin-bottom: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.9rem;
        text-align: left;
    }

    .alert-custom-danger .close-btn {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 1.2rem;
        line-height: 1;
        color: #721c24;
        opacity: 0.7;
        margin-left: 1rem;
        transition: opacity 0.2s;
    }
    .alert-custom-danger .close-btn:hover {
        opacity: 1;
    }
    /* Background aksen */
    .accent {
      position: absolute;
      width: 450px;
      height: 450px;
      border-radius: 50%;
      filter: blur(120px);
      opacity: 0.35;
      z-index: 0;
    }

    .accent.gold {
      background: #ffdf9e;
      top: -150px;
      right: -100px;
    }

    .accent.beige {
      background: #ffe5b4;
      bottom: -100px;
      left: -100px;
    }

    .login-card {
      position: relative;
      z-index: 1;
      background: #ffffff;
      border-radius: 24px;
      box-shadow: 0 10px 30px rgba(200, 170, 120, 0.15);
      width: 100%;
      max-width: 420px;
      padding: 45px 40px;
      text-align: center;
      animation: fadeIn 1s ease;
      border: 1px solid rgba(230, 210, 170, 0.3);
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .login-card img {
      width: 85px;
      margin-bottom: 10px;
      border-radius: 50%;
      background: #fff7e6;
      padding: 8px;
      box-shadow: 0 4px 12px rgba(255, 201, 120, 0.3);
    }

    .login-card h3 {
      font-weight: 600;
      color: #8b5e3c;
      margin-bottom: 5px;
    }

    .login-card p {
      font-size: 0.9rem;
      color: #a07a52;
      margin-bottom: 25px;
    }

    .alert {
      border-radius: 12px;
      font-size: 0.9rem;
      padding: 10px 15px;
      text-align: left;
    }

    .alert-danger {
      background: #ffeaea;
      border: 1px solid #ffb6b6;
      color: #a94442;
    }

    .form-control {
      background: #fffaf2;
      border: 1px solid #ebd8b5;
      border-radius: 12px;
      padding: 12px 15px;
      margin-bottom: 8px;
      color: #5a4632;
      transition: 0.3s;
    }

    .form-control:focus {
      background: #ffffff;
      border-color: #e7b972;
      box-shadow: 0 0 8px rgba(230, 180, 100, 0.4);
    }

    .error-text {
      color: #d67a2f;
      font-size: 0.85rem;
      text-align: left;
      margin-top: 3px;
      margin-bottom: 10px;
      padding-left: 4px;
    }

    .btn-login {
      background: linear-gradient(135deg, #f2b56a, #d69241);
      border: none;
      border-radius: 12px;
      padding: 12px;
      color: #fff;
      font-weight: 600;
      width: 100%;
      transition: all 0.3s ease;
      box-shadow: 0 6px 18px rgba(240, 160, 70, 0.35);
    }

    .btn-login:hover {
      background: linear-gradient(135deg, #eaa64f, #c67a2f);
      transform: translateY(-2px);
      box-shadow: 0 8px 22px rgba(200, 120, 40, 0.45);
    }

    .text-small {
      font-size: 0.9rem;
      color: #856d4d;
      margin-top: 15px;
    }

    .text-small a {
      color: #c98b3b;
      text-decoration: none;
      font-weight: 500;
    }

    .text-small a:hover {
      text-decoration: underline;
    }

    footer {
      position: absolute;
      bottom: 15px;
      font-size: 0.85rem;
      color: #7e6b53;
      z-index: 2;
    }

    /* ======================== */
    /*   FIX POSISI MATA RAPIH  */
    /* ======================== */
    .password-wrapper {
      position: relative;
    }

    .password-wrapper .form-control {
      padding-right: 45px;
    }

    .toggle-password {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: #b48c5b;
      font-size: 1.15rem;
      width: 24px;  /* fix lebar agar tidak bergeser */
      text-align: center;
      transition: color 0.2s;
    }

    .toggle-password:hover {
      color: #946b3a;
    }

    /* Menahan posisi biar tidak geser saat berubah */
    .toggle-password::before {
      display: inline-block;
      width: 1em;
      text-align: center;
    }
  </style>
</head>
<body>

 <div class="accent gold"></div>
  <div class="accent beige"></div>

  <div class="login-card">
  
    {{-- 1. ALERT AKUN DINONAKTIFKAN (STATUS ERROR) --}}
    @if (session('status_error'))
      <div class="alert-custom-danger" id="status-error-alert">
        <span>
        <strong style="color: #721c24;">Akun dinonaktifkan!</strong> Silakan hubungi admin.
        </span>
       <button type="button" class="close-btn" data-bs-dismiss="alert" aria-label="Close">
         &times;
        </button>
      </div>
    @endif

    {{-- 2. ALERT GAGAL LOGIN (FAILED) --}}
    @if (session('failed'))
    <div class="alert alert-danger mb-3">
       <i class="fa-solid fa-circle-exclamation me-2"></i>
       {{ session('failed') }}
     </div>
    @endif

    <img src="{{ asset('images/logo.png') }}" alt="Logo Dekranasda">
    <h3>Dekranasda Kota Bogor</h3>
    <p>Silakan login untuk mengakses sistem</p>

    <form id="loginForm" method="POST" action="{{ route('login') }}" novalidate>
     @csrf

     <!-- Input Email -->
     <div class="mb-3 text-start">
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-control" placeholder="Masukkan Email">
        @error('email')
        <div class="error-text"><i class="fa-solid fa-circle-info me-1"></i>{{ $message }}</div>
        @enderror
      </div>

      <!-- Input Password -->
      <div class="mb-3 text-start password-wrapper">
        <input id="password" type="password" name="password" required class="form-control" placeholder="Masukkan Kata Sandi">
        <i class="fa-solid fa-eye toggle-password" id="togglePassword"></i>
        @error('password')
        <div class="error-text"><i class="fa-solid fa-circle-info me-1"></i>{{ $message }}</div>
        @enderror
      </div>

      <button type="submit" id="btnLogin" class="btn btn-login mt-2">Masuk</button>

      @if (Route::has('password.request'))
        <div class="text-small mt-3">
          <a href="{{ route('password.request') }}">Lupa Kata Sandi?</a>
        </div>
      @endif
    </form>
  </div>

  <footer>
    © {{ date('Y') }} Dekranasda Kota Bogor. All rights reserved.
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // Logika untuk menutup alert kustom (tanpa Bootstrap JS)
    document.addEventListener('DOMContentLoaded', function() { 
     const alertElement = document.getElementById('status-error-alert');
     const closeButton = alertElement ? alertElement.querySelector('.close-btn') : null;
    
     if (closeButton) {
        closeButton.addEventListener('click', function() {
          alertElement.style.display = 'none';
        });
      }

      // Toggle tampil/sembunyikan password
       const togglePassword = document.getElementById('togglePassword');  
       const passwordInput = document.getElementById('password');

      if (togglePassword && passwordInput) {
    togglePassword.addEventListener('click', function () {
          const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
          passwordInput.setAttribute('type', type);
          this.classList.toggle('fa-eye');
          this.classList.toggle('fa-eye-slash');
       });
      }
    });

  </script>

</body>
</html>
