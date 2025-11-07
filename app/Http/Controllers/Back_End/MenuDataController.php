<?php

namespace App\Http\Controllers\Back_End;

use App\Http\Controllers\Controller; 
use App\Models\TbMenuData;
use App\Models\TbMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule; 

class MenuDataController extends Controller
{
    /**
     * Display a listing of the resource.
     * Mendukung filter berdasarkan menu_id.
     */
    public function index(Request $request)
    {
        // Ambil semua menu untuk opsi filter di view
        $menus = TbMenu::all();
        
        // Mulai query dengan eager loading relasi 'menu'
        $query = TbMenuData::with('menu');

        // Cek apakah ada filter menu_id dari request (URL)
        $selectedMenuId = $request->input('menu_id');
        if ($selectedMenuId) {
            $query->where('menu_id', $selectedMenuId);
        }

        // Ambil data yang sudah difilter, diurutkan berdasarkan ID terlama (ASC)
       $menu_data = $query
            ->orderBy('id', 'asc')
            ->paginate(10) // Menerapkan pagination: 10 data per halaman
            ->appends($request->query()); // Mempertahankan parameter filter saat navigasi

        // Kirim ke view, termasuk daftar menu untuk filter dan ID menu yang dipilih
        return view('admin.menu_data.index', compact('menu_data', 'menus', 'selectedMenuId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil semua menu untuk pilihan dropdown
        $menus = TbMenu::all();
        
        // ⭐ Kirim opsi jenis konten ke view
        // Diasumsikan TbMenuData::JENIS_KONTEN adalah array asosiatif seperti:
        // ['artikel' => 'Artikel Berita', 'galeri' => 'Galeri Foto', 'event' => 'Jadwal Acara', 'link' => 'Tautan Eksternal']
        $jenisKontenOptions = TbMenuData::JENIS_KONTEN; 

        return view('admin.menu_data.create', compact('menus', 'jenisKontenOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Ambil kunci jenis konten yang valid dari Model
        $validJenisKonten = array_keys(TbMenuData::JENIS_KONTEN);

        // --- ATURAN VALIDASI DASAR ---
        $rules = [
            'menu_id' => 'required|exists:tb_menu,id',
            'title' => 'nullable|string|max:255', 
            'content' => 'nullable|string', 
            'date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'link' => 'nullable|url|max:255',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
            
            // ⭐ VALIDASI JENIS KONTEN: Dibuat required dan harus ada di daftar valid
            'jenis_konten' => [
                'required', 
                'string', 
                'max:50', 
                Rule::in($validJenisKonten) 
            ],
            
            // Field tambahan untuk organisasi, awalnya nullable
            'jabatan' => 'nullable|string|max:255',
            'deskripsi_organisasi' => 'nullable|string',
        ];
        
        // --- LOGIKA VALIDASI DINAMIS ---
        if ($request->jenis_konten === 'galeri') {
             // Galeri: Hanya butuh img
             $rules['img'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        } elseif ($request->jenis_konten === 'berita') {
            // Berita: title, content, date, location
            $rules['title'] = 'required|string|max:255';
            $rules['content'] = 'required|string';
        } elseif ($request->jenis_konten === 'event') {
            // Event: title, content, date, location, link
            $rules['title'] = 'required|string|max:255';
            $rules['content'] = 'required|string';
            $rules['link'] = 'required|url|max:255';
        } elseif ($request->jenis_konten === 'organisasi') {
            // Organisasi: title, jabatan, deskripsi_organisasi, img
            $rules['title'] = 'required|string|max:255';
            $rules['jabatan'] = 'required|string|max:255';
            $rules['deskripsi_organisasi'] = 'required|string';
        }

        $request->validate($rules);

        // Ambil semua data kecuali field custom (jabatan, deskripsi_organisasi) dan img
        $data = $request->except(['img', 'jabatan', 'deskripsi_organisasi']);
        
        // --- LOGIKA PENYIMPANAN DATA KHUSUS ORGANISASI ---
        if ($request->jenis_konten === 'organisasi') {
            // Gabungkan jabatan dan deskripsi ke dalam array JSON
            $organisasiData = [
                [
                    'jabatan' => $request->jabatan,
                    'deskripsi' => $request->deskripsi_organisasi,
                ]
            ];
            // Simpan sebagai JSON string ke kolom 'content'
            $data['content'] = json_encode($organisasiData);
            
            // Pastikan field lain yang tidak relevan di-set null
            $data['date'] = null;
            $data['location'] = null;
            $data['link'] = null;
            
        } elseif ($request->jenis_konten === 'galeri') {
            // Galeri: pastikan semua field teks di-null-kan
            $data['title'] = null;
            $data['content'] = null;
            $data['date'] = null;
            $data['location'] = null;
            $data['link'] = null;
        }

        // --- LOGIKA UPLOAD GAMBAR ---
        if ($request->hasFile('img')) {
            // Simpan gambar ke storage public/menu_data_images
            $path = $request->file('img')->store('menu_data_images', 'public');
            $data['img'] = $path;
        } else {
             $data['img'] = null; // Pastikan null jika tidak ada file dan jenis konten tidak butuh
        }

        TbMenuData::create($data);

        return redirect()->route('admin.menu_data.index')->with('success', 'Konten berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TbMenuData $menu_data)
    {
        // Eager load relasi menu sebelum ditampilkan
        $menu_data->load('menu'); 
        return view('admin.menu_data.show', compact('menu_data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TbMenuData $menu_data)
    {
        $menus = TbMenu::all();
        
        // ⭐ Kirim opsi jenis konten ke view
        $jenisKontenOptions = TbMenuData::JENIS_KONTEN; 

        return view('admin.menu_data.edit', compact('menu_data', 'menus', 'jenisKontenOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TbMenuData $menu_data)
    {
        // Ambil kunci jenis konten yang valid dari Model
        $validJenisKonten = array_keys(TbMenuData::JENIS_KONTEN);
        
        // --- ATURAN VALIDASI DASAR ---
        $rules = [
            'menu_id' => 'required|exists:tb_menu,id',
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string', 
            'date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'link' => 'nullable|url|max:255',
            // Gunakan nullable agar bisa mempertahankan gambar lama
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
            
            // ⭐ VALIDASI JENIS KONTEN: Dibuat required dan harus ada di daftar valid
            'jenis_konten' => [
                'required', 
                'string', 
                'max:50', 
                Rule::in($validJenisKonten)
            ],
            
            // Field tambahan untuk organisasi, awalnya nullable
            'jabatan' => 'nullable|string|max:255',
            'deskripsi_organisasi' => 'nullable|string',
        ];
        
        // --- LOGIKA VALIDASI DINAMIS (MIRROR DARI STORE) ---
        if ($request->jenis_konten === 'galeri') {
            // Galeri: Butuh img baru jika img lama tidak ada
            $rules['img'] = [
                'nullable', 
                'image', 
                'mimes:jpeg,png,jpg,gif,svg', 
                'max:2048',
                Rule::requiredIf(function() use ($menu_data, $request) {
                    return $menu_data->jenis_konten === 'galeri' && !$menu_data->img && !$request->hasFile('img');
                })
            ];
        } elseif ($request->jenis_konten === 'berita') {
            // Berita: title, content, date, location
            $rules['title'] = 'required|string|max:255';
            $rules['content'] = 'required|string';
        } elseif ($request->jenis_konten === 'event') {
            // Event: title, content, date, location, link
            $rules['title'] = 'required|string|max:255';
            $rules['content'] = 'required|string';
            $rules['link'] = 'required|url|max:255';
        } elseif ($request->jenis_konten === 'organisasi') {
            // Organisasi: title, jabatan, deskripsi_organisasi, img
            $rules['title'] = 'required|string|max:255';
            $rules['jabatan'] = 'required|string|max:255';
            $rules['deskripsi_organisasi'] = 'required|string';
        }

        $request->validate($rules);

        // Ambil semua data kecuali field custom (jabatan, deskripsi_organisasi) dan img
        $data = $request->except(['_token', '_method', 'img', 'jabatan', 'deskripsi_organisasi']);

        // --- LOGIKA PENYIMPANAN DATA KHUSUS ORGANISASI (MIRROR DARI STORE) ---
        if ($request->jenis_konten === 'organisasi') {
            // Gabungkan jabatan dan deskripsi ke dalam array JSON
            $organisasiData = [
                [
                    'jabatan' => $request->jabatan,
                    'deskripsi' => $request->deskripsi_organisasi,
                ]
            ];
            // Simpan sebagai JSON string ke kolom 'content'
            $data['content'] = json_encode($organisasiData);
            
            // Pastikan field lain yang tidak relevan di-set null
            $data['date'] = null;
            $data['location'] = null;
            $data['link'] = null;
            
        } elseif ($request->jenis_konten === 'galeri') {
            // Galeri: pastikan semua field teks di-null-kan
            $data['title'] = null;
            $data['content'] = null;
            $data['date'] = null;
            $data['location'] = null;
            $data['link'] = null;
        }

        if ($request->hasFile('img')) {
            // 1. Hapus gambar lama jika ada
            if ($menu_data->img && Storage::disk('public')->exists($menu_data->img)) {
                Storage::disk('public')->delete($menu_data->img);
            }
            // 2. Simpan gambar baru
            $path = $request->file('img')->store('menu_data_images', 'public');
            $data['img'] = $path;
        }
        // Jika tidak ada upload baru:
        else {
             // Jika jenis konten baru tidak membutuhkan gambar (non-berita/event/organisasi/galeri), hapus gambar lama
             if ($menu_data->img && !in_array($request->jenis_konten, ['berita', 'event', 'organisasi', 'galeri'])) {
                Storage::disk('public')->delete($menu_data->img);
                $data['img'] = null;
             }
             // Jika jenis konten sama atau butuh gambar (dan tidak upload baru), biarkan img lama
        }

        $menu_data->update($data);

        return redirect()->route('admin.menu_data.index')->with('success', 'Konten berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TbMenuData $menu_data)
    {
        // Hapus gambar dari storage sebelum menghapus record database
        if ($menu_data->img && Storage::disk('public')->exists($menu_data->img)) {
            Storage::disk('public')->delete($menu_data->img);
        }

        $menu_data->delete();

        return redirect()->route('admin.menu_data.index')->with('success', 'Konten berhasil dihapus.');
    }
}
