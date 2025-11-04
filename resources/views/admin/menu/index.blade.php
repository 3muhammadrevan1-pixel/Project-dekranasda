@extends('admin.layouts.app')

@section('title', 'Daftar Menu Utama')

@section('content')

{{-- Catatan: Semua styling (termasuk .badge, .btn-add, .table, dan layout)
sekarang diasumsikan berasal dari file CSS global Anda,
sesuai permintaan. Blok <style> dihilangkan. --}}

<div class="content">
{{-- Header dan Tombol Aksi (Menggunakan class header-actions dan btn-add dari CSS Global) --}}
<div class="header-actions">
<h2>Daftar Menu Utama</h2>
<a href="{{ route('admin.menu.create') }}" class="btn btn-add">
<i class="fas fa-plus"></i> Tambah Menu Baru
</a>
</div>

{{-- Notifikasi Sukses --}}
@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- Menggunakan class .table dari CSS Global --}}
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
                <th style="width:100px; text-align:center;">Aksi</th> {{-- Lebar kolom Aksi disesuaikan --}}
            </tr>
        </thead>
        <tbody>
            {{-- Loop data menu dari controller --}}
            @forelse ($menus as $menu)
                <tr>
                    <td>{{ $menu->id }}</td>
                    <td>{{ $menu->nama }}</td>
                    <td>{{ $menu->parent ? $menu->parent->nama : '— (Utama)' }}</td>
                    
                    {{-- Logika Warna untuk TIPE:
                        - Dinamis (Biru) -> badge-primary
                        - Statis (Neutral/Abu-abu) -> badge-secondary 
                    --}}
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
                    
                    {{-- Logika Warna untuk STATUS:
                        - Aktif (Hijau) -> badge-success
                        - Tidak Aktif (Merah) -> badge-danger
                    --}}
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
                    {{-- Menggunakan class .actions, .btn-edit, .btn-delete dari CSS Global --}}
                    <td class="actions">
                        {{-- Tombol Lihat Detail/View dihilangkan --}}
                        
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


</div>

@endsection