@extends('admin.layouts.app')

@section('title', 'Daftar Produk')

@section('content')
<div class="content">
    <div class="header-actions">
        <h2>Daftar Produk</h2>
        {{-- Tombol Tambah Produk --}}
        <a href="{{ route('admin.produk.create') }}" class="btn btn-add">
            <i class="fas fa-plus"></i> Tambah Produk
        </a>
    </div>

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Notifikasi Error --}}
    @if(session('error'))
        <div class="alert alert-error mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th> {{-- KOLOM BARU --}}
                    <th>Gambar</th>
                    <th>Nama Produk</th>
                    <th>Deskripsi</th>
                    <th>Toko</th>
                    <th>Alamat</th>
                    <th>Kategori</th>
                    <th>Type</th>
                    <th>Harga</th>
                    {{-- Kolom 'Nomor Toko' telah dihapus --}}
                    <th style="width:140px; text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- Loop dimulai di sini, menggunakan @forelse untuk handle data kosong --}}
                @forelse ($products as $product)
                    <tr>
                        {{-- ID Produk (BARU) --}}
                        <td class="text-center">{{ $product->id }}</td>

                        {{-- Gambar Produk --}}
                        <td>
                            @if ($product->img)
                                {{-- Ganti dengan path penyimpanan gambar Anda, misal 'storage/' --}}
                                <img src="{{ asset('storage/' . $product->img) }}" alt="{{ $product->name }}" class="table-img">
                            @else
                                <span class="text-gray-400">N/A</span>
                            @endif
                        </td>

                        {{-- Nama Produk --}}
                        <td>{{ $product->name }}</td>

                        {{-- Deskripsi (dibatasi 50 karakter) --}}
                        <td>{{ Str::limit($product->desc, 50) }}</td>

                        {{-- Toko --}}
                        <td>{{ $product->store->name ?? 'Toko Tidak Ditemukan' }}</td>

                        {{-- ALAMAT: DIGANTI DARI 'address' MENJADI 'alamat' --}}
                        <td>{{ $product->store->alamat ?? 'N/A' }}</td>

                        {{-- Kategori & Tipe --}}
                        <td>{{ $product->category }}</td>
                        <td>{{ $product->type }}</td>

                        {{-- Harga --}}
                        <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>

                        {{-- Aksi --}}
                        <td class="actions">
                            {{-- Button Detail, menggunakan objek $product --}}
                            <a href="{{ route('admin.produk.show', $product) }}" class="btn btn-view">
                                <i class="fas fa-eye"></i>
                            </a>

                            {{-- Button Edit, menggunakan objek $product --}}
                            <a href="{{ route('admin.produk.edit', $product) }}" class="btn btn-edit">
                                <i class="fas fa-edit"></i>
                            </a>

                            {{-- Form Hapus --}}
                            <form action="{{ route('admin.produk.destroy', $product) }}" method="POST" class="inline-form" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    {{-- Pesan jika tidak ada data, colspan disesuaikan menjadi 10 --}}
                    <tr>
                        <td colspan="10" class="text-center p-4 text-gray-500">
                            Tidak ada data produk yang tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if(isset($products) && method_exists($products, 'links'))
        <div class="mt-4">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection
