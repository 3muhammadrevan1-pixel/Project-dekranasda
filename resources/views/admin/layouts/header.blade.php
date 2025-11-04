<header class="navbar">
    <div class="left-section">
        <button class="toggle-btn"><i class="fas fa-bars"></i></button>
        <h1>Dashboard Admin Dekranasda</h1>
    </div>

    <div class="nav-right">
        <!-- Dropdown User (Hanya tampil jika sudah login) -->
        @auth
        <div class="user-menu">
            <div class="user-avatar" id="user-icon">
                <i class="fas fa-user"></i>
            </div>

            <div class="dropdown" id="user-dropdown">
                <div class="user-info">
                    <div class="avatar-small"><i class="fas fa-user"></i></div>
                    <div>
                        <strong>{{ Auth::user()->name }}</strong><br>
                        <small class="text-muted">{{ ucfirst(Auth::user()->role) }}</small>
                    </div>
                </div>
                <hr>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>
        @else
        <!-- Jika belum login, tampilkan link ke halaman login -->
        <a href="{{ route('login') }}" class="login-link user-menu" style="text-decoration: none; color: inherit;">
             <i class="fas fa-sign-in-alt"></i> Login
        </a>
        @endauth
    </div>
</header>

<style>
/* ====== NAVBAR ====== */
.navbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #ffffff;
    padding: 12px 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    border-radius: 10px;
    position: relative;
}

.left-section {
    display: flex;
    align-items: center;
    gap: 12px;
}

.navbar h1 {
    font-size: 1.4rem;
    color: #333;
    margin: 0;
}

.toggle-btn {
    background: none;
    border: none;
    font-size: 1.4rem;
    cursor: pointer;
    color: #333;
}

.nav-right {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 16px;
}

/* ===== USER AVATAR & LOGIN LINK (Gaya baru untuk konsistensi) ===== */
.user-avatar, .login-link {
    width: 46px;
    height: 46px;
    background: #edf3ff;
    color: #0d6efd;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.6rem;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(13, 110, 253, 0.15);
}

.user-avatar:hover, .login-link:hover {
    background: #0d6efd;
    color: white;
    transform: scale(1.07);
    box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3);
}

.login-link {
    font-size: 0.8rem; /* Lebih kecil untuk teks 'Login' */
    width: auto;
    border-radius: 8px;
    padding: 0 12px;
    height: 38px;
}


/* ===== DROPDOWN ===== */
.user-menu {
    position: relative;
}

.user-menu .dropdown {
    display: none;
    position: absolute;
    right: 0;
    top: 60px;
    width: 220px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    padding: 14px;
    animation: fadeSlide 0.25s ease;
    z-index: 999;
}

@keyframes fadeSlide {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ===== USER INFO ===== */
.user-info {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 10px;
}

.avatar-small {
    width: 38px;
    height: 38px;
    background: #edf3ff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #0d6efd;
    font-size: 1.2rem;
}

.user-info div {
    line-height: 1.2;
}

.user-info strong {
    color: #222;
    font-size: 14px;
}

.user-info small {
    color: #777;
    font-size: 13px;
}

/* ===== GARIS PEMBATAS ===== */
.user-menu hr {
    border: none;
    border-top: 1px solid #eee;
    margin: 10px 0;
}

/* ===== LOGOUT BUTTON ===== */
.logout-btn {
    width: 100%;
    background: #fff3f3;
    border: 1px solid #ffd2d2;
    border-radius: 8px;
    color: #d9534f;
    padding: 8px 0;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.25s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.logout-btn:hover {
    background: #ffcccc;
    color: #c9302c;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const userIcon = document.getElementById('user-icon');
    const userDropdown = document.getElementById('user-dropdown');
    
    // Pastikan userIcon ada (hanya ada saat user sudah login)
    if (userIcon) {
        userIcon.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdown.style.display = userDropdown.style.display === 'block' ? 'none' : 'block';
        });

        document.addEventListener('click', function(e) {
            // Cek apakah user-menu ada, dan pastikan klik tidak di dalamnya
            const userMenu = document.querySelector('.user-menu');
            if (userMenu && !userMenu.contains(e.target)) {
                userDropdown.style.display = 'none';
            }
        });
    }
});
</script>
