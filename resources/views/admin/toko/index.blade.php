@extends('admin.layouts.app')

@section('title', 'Daftar Toko')

@section('content')
@php
    // Tentukan prefix route berdasarkan role pengguna (admin/operator)
    $rolePrefix = auth()->user()->role === 'operator' ? 'operator' : 'admin';
@endphp

<div class="content">
    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="header-actions">
        <h2>Daftar Toko</h2>
        <a href="{{ route($rolePrefix . '.toko.create') }}" class="btn btn-add">
            <i class="fas fa-plus"></i> Tambah Toko
        </a>
    </div>

    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 50px; text-align: center;">ID</th>
                    <th class="text-left-header">Nama Toko</th> 
                    <th class="text-left-header">Alamat</th>
                    <th class="text-left-header">Telepon</th>
                    <th style="width:140px; text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($stores as $toko)
                    <tr class="toko-row" onclick="toggleProduk('produk-{{ $toko->id }}', this)" style="border-bottom: none !important;"> 
                        <td style="text-align: center;">{{ $toko->id }}</td>
                        <td class="text-left-data">{{ $toko->name }}</td> 
                        <td class="text-left-data">{{ $toko->alamat }}</td>
                        <td class="text-left-data">
                            @if ($toko->telepon)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $toko->telepon) }}" target="_blank" class="btn-wa" title="Hubungi via WhatsApp">
                                    <i class="fab fa-whatsapp"></i> Chat
                                </a>
                            @else
                                -
                            @endif
                        </td>
                        <td class="actions">
                            {{-- Tombol EDIT --}}
                            <a href="{{ route($rolePrefix . '.toko.edit', $toko->id) }}" class="btn btn-edit"><i class="fas fa-edit"></i></a>
                            
                            {{-- Form DELETE --}}
                            <form action="{{ route($rolePrefix . '.toko.destroy', $toko->id) }}" method="POST" class="inline-form" onsubmit="return confirm('Yakin ingin menghapus toko {{ $toko->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete"><i class="fas fa-trash"></i></button>
                            </form>
                            
                            {{-- Tombol untuk menampilkan detail Produk --}}
                            <button type="button" class="btn btn-view" title="Lihat Produk"><i class="fas fa-chevron-down"></i></button>
                        </td>
                    </tr>

                    {{-- Detail Produk --}}
                    <tr id="produk-{{ $toko->id }}" class="produk-row" style="border-top: none !important;">
                        <td colspan="5" style="padding: 0 10px 10px 10px; border-bottom: 5px solid #f0f0f0;"> 
                            <div class="produk-wrapper" style="background-color: #f7f7f7; padding: 10px 0;">
                                <div style="padding: 10px 15px;">
                                    @if ($toko->products && $toko->products->count() > 0)
                                        <h4 class="mb-3 text-dark" style="font-size: 1.1rem; margin-bottom: 10px;">
                                            Daftar Produk di Toko {{ $toko->name }} ({{ $toko->products->count() }})
                                        </h4>
                                        
                                        <table class="table table-bordered table-sm produk-table" style="background-color: white;"> 
                                            <thead class="bg-primary text-white">
                                                <tr>
                                                    <th style="width: 50px; text-align: center;">ID</th> 
                                                    <th style="width: 40%; text-align: left;">Nama Produk</th> 
                                                    <th style="width: 20%; text-align: left;">Kategori</th> 
                                                    <th style="width: 15%; text-align: right;">Harga</th> 
                                                    <th style="width: 120px; text-align: center;">Aksi</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($toko->products as $product)
                                                    <tr>
                                                        <td style="text-align: center;">{{ $product->id }}</td>
                                                        <td class="text-left-data-produk">{{ $product->name }}</td>
                                                        <td class="text-left-data-produk">{{ $product->category }}</td>
                                                        <td class="text-right-data-produk">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                                        <td class="actions actions-sm">
                                                            <a href="{{ route($rolePrefix . '.produk.show', $product) }}" class="btn btn-view btn-sm" title="Lihat"><i class="fas fa-eye"></i></a>
                                                            <a href="{{ route($rolePrefix . '.produk.edit', $product) }}" class="btn btn-edit btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <p class="text-center text-gray-500 p-3">
                                            Tidak ada produk yang terdaftar untuk Toko {{ $toko->name }}.
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data Toko. Silakan tambahkan Toko baru.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
.table-wrapper .table tr.toko-row {
    cursor: pointer;
}
.table-wrapper .table tr.produk-row td {
    border-top: none !important;
}
.produk-wrapper {
    overflow: hidden;
    max-height: 0;
    transition: max-height 0.3s ease-out;
}
.toko-row .btn-view i {
    transition: transform 0.3s ease-out;
}
.toko-row .btn-view i.rotate {
    transform: rotate(180deg);
}
.produk-wrapper .table-sm {
    margin-bottom: 0;
}
.produk-row td[colspan="5"] {
    padding-bottom: 10px !important; 
}
.table th.text-left-header {
    text-align: left;
}
.table td.text-left-data {
    text-align: left;
}
.produk-table td.text-left-data-produk {
    text-align: left;
}
.produk-table td.text-right-data-produk {
    text-align: right;
}
</style>

<script>
function toggleProduk(id, row) {
    const produkRow = document.getElementById(id);
    if (!produkRow) return;

    const wrapper = produkRow.querySelector(".produk-wrapper");
    const icon = row.querySelector(".btn-view i");
    const isActive = produkRow.classList.contains("active");

    document.querySelectorAll(".produk-row.active").forEach(r => {
        if (r.id !== id) {
            r.classList.remove("active");
            r.querySelector(".produk-wrapper").style.maxHeight = null;
            const tokoId = r.id.replace('produk-', '');
            const correspondingTokoRow = document.querySelector('.toko-row[onclick*="produk-' + tokoId + '"]');
            if(correspondingTokoRow) {
                const rotatedIcon = correspondingTokoRow.querySelector(".btn-view i.rotate");
                if(rotatedIcon) rotatedIcon.classList.remove("rotate");
            }
        }
    });

    if (isActive) {
        produkRow.classList.remove("active");
        wrapper.style.maxHeight = null;
        icon.classList.remove("rotate");
    } else {
        produkRow.classList.add("active");
        setTimeout(() => {
            wrapper.style.maxHeight = wrapper.scrollHeight + "px";
        }, 10);
        icon.classList.add("rotate");
    }
}
</script>

@endsection
