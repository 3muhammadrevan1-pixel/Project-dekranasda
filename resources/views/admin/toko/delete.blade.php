@extends('admin.layouts.app')

@section('title', 'Konfirmasi Hapus Toko')

@section('content')

{{-- Anggap $toko adalah variabel yang dilewatkan dari controller --}}
@php
    $toko = [
        'id' => 1,
        'nama' => 'Toko Batik Indah',
    ];
@endphp

<div class="content">
    <div class="crud-view confirmation-view">
        <h3><i class="fas fa-trash-alt"></i> Konfirmasi Hapus</h3>
        
        <div class="alert alert-danger">
            <p>Anda yakin ingin menghapus **{{ $toko['nama'] }}**?</p>
            <p>Tindakan ini tidak dapat dibatalkan.</p>
        </div>
        
        {{-- Formulir untuk melakukan aksi DELETE --}}
        <form method="POST" action="{{ route('toko.destroy', $toko['id']) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Ya, Hapus Sekarang</button>
        </form>
        
        {{-- Mengarahkan kembali ke daftar toko --}}
        <a href="{{ route('toko.index') }}" class="btn btn-secondary">Batal</a>
    </div>
</div>

<style>
    /* Styling Kerangka CRUD */
    .crud-view {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        max-width: 600px;
        margin: 0 auto;
    }
    .crud-view h3 {
        margin-top: 0;
        border-bottom: 2px solid #eee;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }
    .confirmation-view .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        padding: 15px;
        border-radius: 4px;
        margin-bottom: 20px;
    }
    /* Styling tombol */
    .btn { padding: 8px 12px; border-radius: 4px; cursor: pointer; border: none; text-decoration: none; margin-right: 5px; }
    .btn-danger { background-color: #dc3545; color: white; }
    .btn-secondary { background-color: #6c757d; color: white; }
</style>

@endsection