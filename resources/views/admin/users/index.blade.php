@extends('admin.layouts.app')

@section('title', 'Daftar Pengguna (Admin)')

@section('content')

<div class="content">
<div class="header-actions">
<h2>Daftar Pengguna Sistem</h2>
<a href="{{ route('user.create') }}" class="btn btn-add">
<i class="fas fa-user-plus"></i> Tambah Pengguna
</a>
</div>

<div class="table-wrapper">
    <table class="table">
        <thead>
            <tr>
                <th style="width: 50px;">No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th style="width:140px; text-align:center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            {{-- Mulai Perulangan Data Dinamis --}}
            @forelse ($users as $user)
            <tr>
                {{-- $loop->iteration akan menampilkan nomor urut dalam perulangan --}}
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    {{-- Logika untuk menampilkan Role dengan Badge yang berbeda, dan hanya menggunakan Role yang ada di database --}}
                    @php
                        $badge_class = '';
                        // Nilai Role mentah dari database
                        $role_text = $user->role; 
                        
                        switch ($user->role) {
                            case 'admin': 
                                $badge_class = 'badge-success'; // Hijau untuk Admin (sesuai permintaan)
                                break;
                            case 'operator': 
                                $badge_class = 'badge-primary'; // Biru untuk Operator (sesuai permintaan)
                                break;
                            default:
                                // Untuk role lain yang tidak terdaftar, gunakan warna default
                                $badge_class = 'badge-light'; 
                        }
                    @endphp
                    {{-- Tampilkan teks role yang sudah disiapkan (nilai mentah database) --}}
                    <span class="badge {{ $badge_class }}">{{ $role_text }}</span>
                </td>
                <td>
                    {{-- Logika untuk menampilkan Status Aktif/Non-Aktif --}}
                    @if ($user->status == 'aktif')
                        <span class="badge badge-success">Aktif</span>
                    @else
                        <span class="badge badge-danger">Non-Aktif</span>
                    @endif
                </td>
                <td class="actions">
                    {{-- Tombol EDIT --}}
                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-edit"><i class="fas fa-edit"></i></a>
                    
                    {{-- Tombol DELETE (Form) --}}
                    <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="inline-form" onsubmit="return confirm('Yakin ingin menghapus pengguna {{ $user->name }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center; padding: 20px;">
                    <i class="fas fa-info-circle"></i> Belum ada data pengguna yang tersedia.
                </td>
            </tr>
            @endforelse
            {{-- Akhir Perulangan Data Dinamis --}}
        </tbody>
    </table>
</div>


</div>

@endsection