@extends('admin.layouts.app')

@section('title', 'Dashboard Operator')

@section('content')

<style>
    /* Layout grid yang lebih rapat */
    .stats,
    .dashboard-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 18px;
        margin-bottom: 20px;
    }

    /* Kartu statistik */
    .stat-card {
        padding: 16px 18px;
        border-radius: 10px;
        color: #fff;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.2s ease-in-out;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .stat-card .icon {
        font-size: 2rem;
        opacity: 0.75;
    }

    .stat-card .text h3 {
        margin: 0;
        font-size: 1.9rem;
        font-weight: 600;
        line-height: 1.2;
    }

    .stat-card .text p {
        margin: 2px 0 0;
        font-size: 0.9rem;
        opacity: 0.85;
    }

    /* Kartu menu */
    .dashboard-card {
        display: block;
        text-decoration: none;
        background-color: #fff;
        border-radius: 10px;
        padding: 22px 16px;
        text-align: center;
        color: #333;
        box-shadow: 0 1px 6px rgba(0, 0, 0, 0.05);
        transition: all 0.2s ease-in-out;
    }

    .dashboard-card:hover {
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        transform: translateY(-1px);
    }

    .dashboard-card i {
        font-size: 2.1rem;
        margin-bottom: 8px;
    }

    .dashboard-card h3 {
        font-size: 1.05rem;
        margin: 4px 0;
        font-weight: 600;
    }

    .dashboard-card p {
        font-size: 0.82rem;
        color: #6c757d;
        margin: 0;
    }

    /* Warna spesifik */
    .dashboard-card.produk i {
        color: #5b50a3;
    }

    .dashboard-card.toko i {
        color: #28a745;
    }

    .stat-card.blue {
        background-color: #5b50a3;
    }

    .stat-card.green {
        background-color: #28a745;
    }

    /* Header dashboard */
    .dashboard-header {
        margin-bottom: 15px;
    }

    .dashboard-header h2 {
        font-size: 1.6rem;
        margin-bottom: 4px;
    }

    .dashboard-header p {
        font-size: 0.9rem;
        color: #666;
        margin: 0;
    }

    /* Biar tampilan lebih menyatu */
    .dashboard {
        margin-top: -10px;
    }
</style>

<div class="dashboard">
    <div class="dashboard-header">
        <h2>Dashboard Operator</h2>
        <p>Kelola data Produk dan Toko.</p>
    </div>

    <div class="stats">
        <div class="stat-card blue">
            <div class="icon"><i class="fas fa-box"></i></div>
            <div class="text">
                <h3>{{ $stats['productCount'] ?? 0 }}</h3>
                <p>Produk</p>
            </div>
        </div>

        <div class="stat-card green">
            <div class="icon"><i class="fas fa-store"></i></div>
            <div class="text">
                <h3>{{ $stats['storeCount'] ?? 0 }}</h3>
                <p>Toko</p>
            </div>
        </div>
    </div>

    <div class="dashboard-cards">
        <a href="{{ route('admin.produk.index') }}" class="dashboard-card produk">
            <i class="fas fa-gifts"></i>
            <h3>Produk</h3>
            <p>Daftar lengkap produk</p>
        </a>

        <a href="{{ route('admin.toko.index') }}" class="dashboard-card toko">
            <i class="fas fa-store"></i>
            <h3>Toko</h3>
            <p>Daftar toko & produk terkait</p>
        </a>
    </div>
</div>

@endsection
