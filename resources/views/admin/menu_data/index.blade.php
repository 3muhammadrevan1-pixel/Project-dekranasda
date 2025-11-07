@extends('admin.layouts.app')

@section('title', 'Daftar Konten Menu')

@section('content')
<div class="content">
    <!-- ===== HEADER ===== -->
    <div class="header-actions flex justify-between items-center mb-4">
        <h2>Daftar Konten Menu</h2>
        <a href="{{ route('admin.menu_data.create') }}" class="btn btn-add">
            <i class="fas fa-plus"></i> Tambah Konten Baru
        </a>
    </div>

    <!-- ===== ALERT SUCCESS ===== -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- ===== FILTER MENU START ===== -->
    <div class="filter-box bg-white p-4 rounded-lg shadow-sm mb-4 border border-gray-200">
        <form action="{{ route('admin.menu_data.index') }}" method="GET" class="flex items-center flex-wrap gap-4">
            <label for="menu_id" class="font-semibold text-gray-700">
                Filter Berdasarkan Menu:
            </label>
            <select id="menu_id" name="menu_id" class="form-control p-2 border rounded-md">
                <option value="">-- Tampilkan Semua Menu --</option>
                @foreach ($menus as $menu)
                    <option 
                        value="{{ $menu->id }}" 
                        {{ request('menu_id') == $menu->id ? 'selected' : '' }}>
                        {{ $menu->nama }} (ID: {{ $menu->id }})
                    </option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-add px-4 py-2 rounded-md transition duration-150">
                Filter
            </button>

            @if (request('menu_id'))
                <a href="{{ route('admin.menu_data.index') }}" class="btn btn-add px-4 py-2 rounded-md transition duration-150">
                    Reset Filter
                </a>
            @endif
        </form>
    </div>
    <!-- ===== FILTER MENU END ===== -->

    <!-- ===== TABLE ===== -->
    <div class="table-wrapper overflow-x-auto">
        <table class="table w-full border-collapse">
            <thead>
                <tr class="bg-gray-100 text-sm text-gray-700 text-center">
                    <th class="id-col">ID</th>
                    <th class="text-center">Menu</th>
                    <th class="text-left">Judul</th>
                    <th class="text-center">Jenis</th>
                    <th class="media-col">Gambar</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($menu_data as $data)
                    <tr class="table-row border-b hover:bg-gray-50 align-top">
                        <td class="id-col text-center">{{ $data->id }}</td>
                        <td class="text-center">{{ $data->menu->nama ?? '-' }}</td>
                        <td class="text-left">{{ $data->title }}</td>
                        <td class="text-center">
                            {{ $jenisKontenOptions[$data->jenis_konten] ?? $data->jenis_konten ?? '-' }}
                        </td>
                        <td class="media-col text-center">
                            @if ($data->img)
                                <div class="img-container">
                                    <img src="{{ asset('storage/'.$data->img) }}" 
                                         alt="Gambar Konten"
                                         class="img-table">
                                </div>
                            @else
                                <span class="text-gray-400">Tidak ada</span>
                            @endif
                        </td>
                        <td class="actions text-center">
                            <a href="{{ route('admin.menu_data.edit', $data->id) }}" 
                               class="btn btn-edit" 
                               title="Edit Konten">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.menu_data.destroy', $data->id) }}" 
                                  method="POST" 
                                  class="inline-form d-inline" 
                                  onsubmit="return confirm('Yakin ingin menghapus konten ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete" title="Hapus Konten">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center p-4 text-gray-500">
                            Tidak ada data konten menu yang tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($menu_data instanceof \Illuminate\Pagination\LengthAwarePaginator && $menu_data->total() > 0)
        <div class="pagination-container" style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem; flex-wrap: wrap;">
            {{-- Informasi Halaman --}}
            <div class="pagination-info" style="font-size: 0.9rem; color: #6b7280; padding: 0.5rem 0;">
                Menampilkan 
                <span style="font-weight: 600;">{{ $menu_data->firstItem() }}</span>
                sampai
                <span style="font-weight: 600;">{{ $menu_data->lastItem() }}</span>
                dari total 
                <span style="font-weight: 600;">{{ $menu_data->total() }}</span> konten.
            </div>

            {{-- Tautan Pagination menggunakan view kustom di page/pagenation.blade.php --}}
            <div class="pagination-links-wrapper">
                {{ $menu_data->onEachSide(1)->links('page.pagenation') }}
            </div>
        </div>
    @endif
</div>

<!-- ===== STYLE ===== -->
<style>
    /* === Table Layout === */
    .table {
        table-layout: fixed;
        width: 100%;
        border-collapse: collapse;
    }

    .table th,
    .table td {
        padding: 10px;
        vertical-align: middle;
        word-wrap: break-word;
        border-bottom: 1px solid #e5e7eb;
    }

    /* === Column Width === */
    .id-col { width: 40px; text-align: center; }
    .media-col { width: 90px; text-align: center; }

    /* === Header === */
    .table th {
        font-weight: 600;
        padding: 10px 8px;
        text-align: center;
    }

    .table th.text-left { text-align: left; }

    /* === Cell Alignment === */
    .table td.text-left { text-align: left; }
    .table td.text-center { text-align: center; }

    /* === Row === */
    .table-row {
        height: 70px;
        transition: all 0.3s ease;
    }

    .table-row:hover {
        background-color: #fafafa;
    }

    /* === Image / Media === */
    .img-container {
        width: 60px;
        height: 60px;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        overflow: hidden;
        margin: 0 auto;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .img-container:hover {
        transform: scale(1.05);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .img-table {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* === Responsive === */
    @media (max-width: 768px) {
        .table th,
        .table td {
            font-size: 13px;
            padding: 6px;
        }
    }
</style>
@endsection
