<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Full Page Card</title>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

body {
    margin: 0;
    padding: 0;
    background: #F4F2EE;
    font-family: 'Inter', sans-serif;
    color: #333;
}

/* ===================================== */
/* PAGE WRAPPER */
/* ===================================== */
.page-wrapper {
    width: 100%;
    min-height: 100vh;
    padding: 60px 20px;
    display: flex;
    justify-content: center;
}

.content-container {
    width: 100%;
    max-width: 1100px;
}

/* ===================================== */
/* CARD */
/* ===================================== */
.static-highlight-card {
    display: flex;
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 10px 35px rgba(0, 0, 0, 0.10);
    overflow: hidden;
    transition: 0.35s ease;
}

.static-highlight-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 45px rgba(0, 0, 0, 0.13);
}

/* Side Accent */
.sidebar-accent {
    width: 30px;
    background: linear-gradient(180deg, #8B4513, #5C2F0A);
}

/* Card Content */
.card-content-area {
    padding: 45px 55px;
    width: 100%;
}

.card-title {
    color: #4A2B00;
    font-size: 2.4rem;
    font-weight: 700;
    margin: 0 0 30px;
    padding-bottom: 18px;
    border-bottom: 2px solid #E8DDC6;
}

/* Content Styling */
.card-body {
    font-size: 1.15rem;
    line-height: 1.85;
    color: #333;
}

.card-body p {
    margin-bottom: 16px;
}

/* ===================================== */
/* RESPONSIVE */
/* ===================================== */
@media(max-width: 600px) {

    .card-content-area {
        padding: 28px;
    }

    .card-title {
        font-size: 1.8rem;
    }

    .sidebar-accent {
        width: 14px;
    }

    .card-body {
        font-size: 1rem;
    }
}
</style>

</head>
<body>

<div class="page-wrapper">
    <div class="content-container">

        <div class="static-highlight-card">
            <div class="sidebar-accent"></div>

            <div class="card-content-area">

                <h3 class="card-title">
                    {{ $menu->nama }}
                </h3>

                <div class="card-body">

                    {{-- ========================================= --}}
                    {{-- MENAMPILKAN SEMUA ITEM DALAM SATU CARD --}}
                    {{-- ========================================= --}}

                    @foreach($menu_data as $item)

                        <h4 style="margin-top:25px; margin-bottom:10px; color:#5A3A00; font-weight:600;">
                            {{ $item->title }}
                        </h4>

                        <div style="margin-bottom:20px;">
                            {!! $item->content !!}
                        </div>

                        @if(!$loop->last)
                            <hr style="border:0; border-top:1px solid #E8DDC6; margin:25px 0;">
                        @endif

                    @endforeach

                    @if($menu_data->isEmpty())
                        <p>Tidak ada data untuk ditampilkan.</p>
                    @endif

                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>
