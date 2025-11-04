<?php

namespace App\Http\Controllers\Back_End;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Untuk hashing password
use Illuminate\Validation\Rule; // Untuk validasi unik saat update

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna. (READ - Index)
     */
    public function index()
    {
        // Mengambil semua data pengguna, diurutkan berdasarkan id terkecil ke terbesar (ASC)
        $users = User::orderBy('id', 'asc')->get(); 

        // Mengirim data $users ke view
        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan form untuk membuat pengguna baru. (CREATE - Form)
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Menyimpan data pengguna baru ke database. (CREATE - Store)
     */
    public function store(Request $request)
    {
        // 1. Validasi Data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            // Perubahan di sini: Ditambahkan |max:50
            'password' => 'required|string|min:8|max:50|confirmed', // 'confirmed' butuh field password_confirmation
            'role' => 'required|in:admin,operator',
            'status' => 'required|in:aktif,nonaktif', 
        ]);

        // 2. Simpan Data
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // WAJIB di-hash
            'role' => $request->role,
            'status' => $request->status,
        ]);

        // 3. Redirect dengan pesan sukses
        return redirect()->route('user.index')->with('success', 'Pengguna baru berhasil ditambahkan!');
    }

    public function edit(User $user)
    {
        // Karena menggunakan Route Model Binding, objek sudah otomatis diambil
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Memperbarui data pengguna di database. (UPDATE - Store)
     */
    public function update(Request $request, User $user)
    {
        // 1. Validasi Data
        $request->validate([
            'name' => 'required|string|max:255',
            // Rule::unique:users->ignore($user) memastikan email ini boleh sama dengan email user saat ini (saat tidak diubah)
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user)],
            // Perubahan di sini: Ditambahkan |max:50
            'password' => 'nullable|string|min:8|max:50|confirmed', // 'nullable' karena password boleh tidak diubah
            'role' => 'required|in:admin,operator',
            'status' => 'required|in:aktif,nonaktif', 
        ]);

        // 2. Perbarui Data
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->status = $request->status;

        // Cek apakah password diisi (jika diisi, lakukan update)
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // 3. Redirect dengan pesan sukses
        return redirect()->route('user.index')->with('success', 'Data pengguna berhasil diperbarui!');
    }

    /**
     * Menghapus pengguna dari database. (DELETE - Destroy)
     */
    public function destroy(User $user)
    {
        // Hapus data pengguna
        $user->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('user.index')->with('success', 'Pengguna berhasil dihapus!');
    }
}

