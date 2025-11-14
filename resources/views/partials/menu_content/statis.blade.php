<style>
/* FONT */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

.static-highlight-card {
    display: flex;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    margin-bottom: 30px;
    font-family: 'Inter', sans-serif;
    transition: 0.3s ease-in-out;
}

.static-highlight-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
}

.sidebar-accent {
    width: 22px;
    background: linear-gradient(180deg, #8B4513, #5C2F0A);
}

.card-content-area {
    padding: 25px 30px;
    width: 100%;
}

.card-title {
    color: #4A2B00;
    font-size: 1.6em;
    font-weight: 700;
    margin-top: 0;
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 2px solid #F0EAD6;
}

/* ================================ */
/* DROPDOWN SMOOTH VERSION */
/* ================================ */

.dropdown-container {
    margin-top: 10px;
}

.dropdown-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #F8F4EC;
    padding: 15px 18px;
    border-radius: 10px;
    cursor: pointer;
    border: 1px solid #E2D8C3;
    transition: background 0.25s ease, box-shadow 0.25s ease;
}

.dropdown-header:hover {
    background: #F1E9DA;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}

.dropdown-title {
    font-size: 1rem;
    font-weight: 600;
    color: #4A2B00;
}

.dropdown-arrow {
    transition: transform 0.35s ease;
}

/* Smooth Dropdown Body */
.dropdown-body {
    max-height: 0;
    overflow: hidden;
    opacity: 0;
    transform: translateY(-6px);
    transition: 
        max-height 0.45s ease,
        opacity 0.35s ease,
        transform 0.35s ease;
    background: #FFF;
    border-left: 1px solid #E2D8C3;
    border-right: 1px solid #E2D8C3;
    border-bottom: 1px solid #E2D8C3;
    border-radius: 0 0 10px 10px;
    padding: 0 18px;
}

.dropdown-body.open {
    max-height: 2000px;
    opacity: 1;
    transform: translateY(0px);
    padding: 18px;
}

.dropdown-body p {
    margin-bottom: 12px;
    color: #333;
    line-height: 1.7;
}

@media(max-width: 600px) {
    .card-content-area {
        padding: 18px;
    }
    .sidebar-accent {
        width: 10px;
    }
    .dropdown-header {
        padding: 12px 14px;
    }
}
</style>

<div class="static-highlight-card">
    <div class="sidebar-accent"></div>

    <div class="card-content-area">
        <h3 class="card-title">{{ $item->title ?? $menu->nama }}</h3>

        <div class="dropdown-container">
            <div class="dropdown-header" onclick="toggleDropdown(this)">
                <span class="dropdown-title">Lihat</span>
                <span class="dropdown-arrow">&#9662;</span>
            </div>

            <div class="dropdown-body">
                {!! $item->content ?? 'Tidak ada konten.' !!}
            </div>
        </div>
    </div>
</div>

<script>
function toggleDropdown(element) {
    const body = element.nextElementSibling;
    const arrow = element.querySelector('.dropdown-arrow');

    const isOpen = body.classList.contains('open');

    // Tutup dropdown lain agar lebih rapi
    document.querySelectorAll('.dropdown-body.open').forEach(openBody => {
        if (openBody !== body) {
            openBody.classList.remove('open');
            openBody.previousElementSibling
                .querySelector('.dropdown-arrow')
                .style.transform = 'rotate(0deg)';
        }
    });

    // Toggle yang diklik
    body.classList.toggle('open', !isOpen);
    arrow.style.transform = !isOpen ? 'rotate(180deg)' : 'rotate(0deg)';
}
</script>
