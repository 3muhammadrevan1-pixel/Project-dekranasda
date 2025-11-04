@extends('admin.layouts.app')

@section('title', 'Daftar Konten Menu')

@section('content')
<div class="content">
    <div class="header-actions flex justify-between items-center mb-4">
        <h2>Daftar Konten Menu</h2>
        <a href="{{ route('admin.menu_data.create') }}" class="btn btn-add">
            <i class="fas fa-plus"></i> Tambah Konten Baru
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- FILTER MENU START --}}
    <div class="filter-box bg-white p-4 rounded-lg shadow-sm mb-4 border border-gray-200">
        <form action="{{ route('admin.menu_data.index') }}" method="GET" class="flex items-center flex-wrap gap-4">
            <label for="menu_id" class="font-semibold text-gray-700">Filter Berdasarkan Menu:</label>
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
            <button type="submit" class="btn btn-add px-4 py-2 rounded-md transition duration-150">Filter</button>
            @if (request('menu_id'))
                <a href="{{ route('admin.menu_data.index') }}" class="btn btn-add px-4 py-2 rounded-md transition duration-150">
                    Reset Filter
                </a>
            @endif
        </form>
    </div>
    {{-- FILTER MENU END --}}

    <div class="table-wrapper overflow-x-auto">
        <table class="table w-full border-collapse">
            <thead>
                <tr class="bg-gray-100 text-sm text-gray-700 text-center">
                    <th class="id-col">ID</th>
                    <th class="text-center">Menu</th>
                    <th class="text-left">Judul</th>
                    <th class="content-col text-left">Isi Konten</th>
                    <th class="text-center">Jenis</th>
                    <th class="date-col">Tanggal</th>
                    <th class="text-center">Lokasi</th>
                    <th class="link-col">Link</th>
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
                        <td class="content-cell content-col">
                            <div class="content-text">
                                {!! $data->content !!}
                            </div>
                        </td>
                        {{-- ⭐ PERBAIKAN: Menampilkan label Jenis Konten, bukan kodenya --}}
                        <td class="text-center">
                            {{ $jenisKontenOptions[$data->jenis_konten] ?? $data->jenis_konten ?? '-' }}
                        </td>
                        {{-- END PERBAIKAN --}}
                        <td class="date-col text-center">{{ $data->date ? \Carbon\Carbon::parse($data->date)->format('d/m/Y') : '-' }}</td>
                        <td class="text-center">{{ $data->location ?? '-' }}</td>
                        <td class="link-col text-center">
                            @if ($data->link)
                                <a href="{{ $data->link }}" target="_blank" class="text-blue-600 hover:underline">
                                    Lihat Link
                                </a>
                            @else
                                -
                            @endif
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
                            <a href="{{ route('admin.menu_data.edit', $data->id) }}" class="btn btn-edit" title="Edit Konten">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.menu_data.destroy', $data->id) }}" method="POST" 
                                class="inline-form" 
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
                        <td colspan="10" class="text-center p-4 text-gray-500">
                            Tidak ada data konten menu yang tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- STYLE UNTUK TABEL, GAMBAR & KONTEN --}}
<style>
    .table {
        table-layout: fixed;
        width: 100%;
        border-collapse: collapse;
    }

    .table th, .table td {
        padding: 10px;
        vertical-align: top;
        word-wrap: break-word;
        border-bottom: 1px solid #e5e7eb;
    }

    /* Atur lebar kolom */
    .id-col { width: 40px; text-align:center; }
    .date-col { width: 90px; text-align:center; }
    .link-col { width: 80px; text-align:center; }
    .media-col { width: 90px; text-align:center; }
    .content-col { width: 350px; }

    /* Judul kolom */
    .table th {
        font-weight: 600;
        padding: 10px 8px;
        text-align: center;
    }
    .table th.text-left { text-align: left; }

    /* Isi sel data */
    .table td.text-left { text-align: left; }
    .table td.text-center { text-align: center; }

    /* Set tinggi baris default */
    .table-row { height: 100px; transition: all 0.3s ease; }

    /* Hover baris hanya ubah background, tidak merubah tinggi */
    .table-row:hover { background-color: #fafafa; }

    /* Kolom gambar/media */
    .img-container {
        width: 80px;
        height: 80px;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        margin: 0 auto;
    }
    .img-container:hover {
        transform: scale(1.05);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .img-table { width: 100%; height: 100%; object-fit: cover; }

    /* Kolom isi konten */
    .content-cell { position: relative; cursor: pointer; }
    .content-text {
        display: block;
        max-height: 70px; 
        overflow: hidden;
        transition: max-height 0.5s ease, padding 0.3s ease;
        color: #374151;
        white-space: normal;
        line-height: 1.6;
        padding-right: 5px;
    }
    .content-text p { margin: 0 0 10px 0; }

    /* Hanya kolom isi konten memanjang */
    .content-cell:hover .content-text,
    .content-cell:active .content-text {
        max-height: 2000px;
        overflow: visible;
        padding-bottom: 10px;
    }

    /* Responsif */
    @media (max-width: 768px) {
        .table th, .table td { font-size: 13px; padding: 6px; }
        .content-col { width: auto; }
    }
</style>
@endsection
