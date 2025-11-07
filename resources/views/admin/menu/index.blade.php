@extends('admin.layouts.app')

@section('title', 'Daftar Menu Utama')

@section('content')

<div class="content">
{{-- Header dan Tombol Aksi --}}
<div class="header-actions">
<h2>Daftar Menu Utama</h2>
<a href="{{ route('admin.menu.create') }}" class="btn btn-add">
<i class="fas fa-plus"></i> Tambah Menu Baru
</a>
</div>

{{-- 3. PERBAIKAN STRUKTUR NOTIFIKASI AGAR IKON MUNCUL --}}
@if (session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle alert-icon"></i> 
        <span>{{ session('success') }}</span>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        <i class="fas fa-times-circle alert-icon"></i>
        <span>{{ session('error') }}</span>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle alert-icon"></i>
        <div>
            <span class="d-block mb-1">Terjadi kesalahan validasi:</span>
            {{-- Mengganti <ul> dengan style inline agar terintegrasi dengan baik --}}
            <ul class="mb-0" style="list-style: disc; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

{{-- Menggunakan class .table --}}
<div class="table-wrapper">
    <table class="table">
        <thead>
            <tr>
                <th style="width:50px;">ID</th>
                <th>Nama Menu</th>
                <th>Menu Induk</th>
                <th class="text-center">Tipe</th>
                <th class="text-center">Status</th>
                <th style="width:100px; text-align:center;">Urutan</th>
                <th style="width:100px; text-align:center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            {{-- Loop data menu dari controller --}}
            @forelse ($menus as $menu)
                <tr>
                    <td>{{ $menu->id }}</td>
                    <td>{{ $menu->nama }}</td>
                    <td>{{ $menu->parent ? $menu->parent->nama : '— (Utama)' }}</td>
                    
                    <td class="text-center">
                        @php
                            $tipeValue = strtolower($menu->tipe ?? 'kosong');
                            $tipeClass = match ($tipeValue) {
                                'dinamis' => 'badge-primary', // Biru
                                'statis' => 'badge-secondary', // Abu-abu
                                default => 'badge-secondary', 
                            };
                        @endphp
                        <span class="badge {{ $tipeClass }}">
                            {{ $menu->tipe ? ucfirst($menu->tipe) : '—' }}
                        </span>
                    </td>
                    
                    <td class="text-center">
                        @php
                            $statusValue = strtolower($menu->status ?? 'kosong');
                            $statusClass = match ($statusValue) {
                                'aktif' => 'badge-success', // Hijau
                                'tidak aktif' => 'badge-danger', // Merah
                                default => 'badge-secondary', 
                            };
                        @endphp
                        <span class="badge {{ $statusClass }}">
                            {{ $menu->status ? ucfirst($menu->status) : '—' }}
                        </span>
                    </td>
                    
                    <td class="text-center">{{ $menu->urutan ?? '-' }}</td>
                    
                    <td class="actions">
                        
                        <a href="{{ route('admin.menu.edit', $menu->id) }}" class="btn btn-edit" title="Edit Menu"><i class="fas fa-edit"></i></a>
                        
                        <form action="{{ route('admin.menu.destroy', $menu->id) }}" method="POST" class="inline-form" onsubmit="return confirm('Yakin ingin menghapus menu {{ $menu->nama }} ini? Penghapusan ini tidak dapat dibatalkan.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete" title="Hapus Menu"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center p-4">Tidak ada data menu yang tersedia.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
{{-- BLOK BARU: Pagination dan Informasi Ringkasan --}}
    @if ($menus instanceof \Illuminate\Pagination\LengthAwarePaginator && $menus->total() > 0)
        <div class="pagination-container" style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem; flex-wrap: wrap;">
            {{-- Informasi Halaman --}}
            <div class="pagination-info" style="font-size: 0.9rem; color: #6b7280; padding: 0.5rem 0;">
                Menampilkan 
                <span style="font-weight: 600;">{{ $menus->firstItem() }}</span>
                sampai
                <span style="font-weight: 600;">{{ $menus->lastItem() }}</span>
                dari total 
                <span style="font-weight: 600;">{{ $menus->total() }}</span> menu.
            </div>

            {{-- Tautan Pagination menggunakan view kustom di page/pagenation.blade.php --}}
            <div class="pagination-links-wrapper">
                {{ $menus->onEachSide(1)->links('page.pagenation') }}
            </div>
        </div>
    @endif

</div>

@endsection