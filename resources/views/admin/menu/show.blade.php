@extends('admin.layouts.app')

@section('content')
<div class="content">
    <h2 class="page-title">Detail Produk</h2>

    <div class="detail-card">
        <div class="detail-left">
            <img src="{{ asset('images/pk1.jpg') }}" alt="Produk">
        </div>

        <div class="detail-right">
            <h3 class="detail-title">Batik Coklat Khas Bogor</h3>
            <div class="detail-grid">
                <p><strong>Nama Toko</strong> Toko Batik Indah</p>
                <p><strong>Deskripsi</strong> Produk rotan asli buatan pengrajin lokal.</p>
                <p><strong>Alamat</strong> Jl. Mawar No. 45, Bogor</p>
                <p><strong>Kategori</strong> Kerajinan</p>
                <p><strong>Type</strong>Terbaru</p>
                <p><strong>Harga</strong> Rp 150.000</p>
                <p><strong>Nomor Toko</strong>089602397994</p>
                
            </div>

            <div class="detail-actions">
                <a href="{{ url('admin/produk/edit/1') }}" class="btn btn-edit">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ url('admin/produk') }}" class="btn btn-secondary">
                  Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
