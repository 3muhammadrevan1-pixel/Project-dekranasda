<?php

namespace App\Http\Controllers\Back_End;

use App\Http\Controllers\Controller;
use App\Models\TbMenuData;
use App\Models\TbMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Str;

class MenuDataController extends Controller
{
    /**
     * Display a listing of the resource.
     * Mendukung filter berdasarkan menu_id.
     */
    public function index(Request $request)
    {
        $menus = TbMenu::all();
        $query = TbMenuData::with('menu');

        $selectedMenuId = $request->input('menu_id');
        if ($selectedMenuId) {
            $query->where('menu_id', $selectedMenuId);
        }

        $menu_data = $query
            ->orderBy('id', 'asc')
            ->paginate(10)
            ->appends($request->query());

        return view('admin.menu_data.index', compact('menu_data', 'menus', 'selectedMenuId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $menus = TbMenu::all();
        $selectedMenu = null;
        if ($request->has('menu_id')) {
            $selectedMenu = TbMenu::find($request->menu_id);
        }

        return view('admin.menu_data.create', compact('menus', 'selectedMenu'));
    }

    /**
     * Fungsi helper untuk mengelola upload file gambar.
     * Sekarang menyimpan file ke storage/app/public/uploads/menu_data/{jenis_konten}/
     */
    protected function handleImageUpload(Request $request, string $contentType, ?string $oldImagePath = null)
    {
        if ($request->hasFile('img')) {
            $file = $request->file('img');

            // 1. Tentukan folder target di dalam storage
            $targetFolder = 'uploads/menu_data/' . $contentType;

            // 2. Tentukan nama file (timestamp + slug nama asli)
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->extension();
            $filename = time() . '-' . Str::limit(Str::slug($originalName), 50, '') . '.' . $extension;

            // 3. Hapus gambar lama jika ada
            if ($oldImagePath && Storage::disk('public')->exists($oldImagePath)) {
                Storage::disk('public')->delete($oldImagePath);
            }

            // 4. Simpan file ke storage/app/public/uploads/menu_data/{jenis_konten}
            $path = $file->storeAs($targetFolder, $filename, 'public');

            // 5. Kembalikan path relatif untuk disimpan di database
            return $path;
        }

        return null;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['menu_id' => 'required|exists:tb_menu,id']);

        try {
            $parentMenu = TbMenu::findOrFail($request->menu_id);
            $contentType = $parentMenu->jenis_konten;
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withInput()->withErrors(['menu_id' => 'Menu induk tidak ditemukan.']);
        }

        $rules = [
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            // Kolom link sekarang selalu nullable, yang menentukan adalah inputan di form (bukan rule required)
            'link' => 'nullable|url|max:255', 
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2000',
            'jabatan' => 'nullable|string|max:255',
            'deskripsi_organisasi' => 'nullable|string',
        ];

        // --- Perubahan utama ada di blok ini ---
        if ($contentType === 'dinamis') {
           
            $rules['title'] = 'required|string|max:255';
            $rules['content'] = 'required|string';
            // Link akan divalidasi sebagai URL jika diisi. Jika link kosong, dianggap konten detail.
            // Tidak perlu rule khusus untuk link di sini, sudah dicover oleh general rules.

        } elseif ($contentType === 'media') {
            $rules['img'] = 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2000';
            
        } elseif ($contentType === 'organisasi') {
            $rules['title'] = 'required|string|max:255';
            $rules['jabatan'] = 'required|string|max:255';
            $rules['deskripsi_organisasi'] = 'required|string';
            
        } elseif ($contentType === 'statis') {
            $rules['title'] = 'required|string|max:255';
            $rules['content'] = 'required|string';
        }
        // --- Akhir perubahan utama ---

        $request->validate($rules);

        $data = $request->except(['img', 'jabatan', 'deskripsi_organisasi']);
        $data['menu_id'] = $parentMenu->id;
        $data['jenis_konten'] = $contentType;

        // Penanganan Data Khusus
        if ($contentType === 'organisasi') {
            $organisasiData = [[
                'jabatan' => $request->jabatan,
                'deskripsi' => $request->deskripsi_organisasi,
            ]];
            $data['content'] = json_encode($organisasiData);
            $data['date'] = null;
            $data['location'] = null;
            $data['link'] = null;
            $data['title'] = $request->title;
        } elseif ($contentType === 'media') {
            $data['title'] = $request->title ?? null;
            $data['content'] = $request->content ?? null;
            $data['date'] = null;
            $data['location'] = null;
            $data['link'] = null;
        }

        $imagePath = $this->handleImageUpload($request, $contentType);
        $data['img'] = $imagePath;

        TbMenuData::create($data);

        return redirect()->route('admin.menu_data.index')->with('success', 'Konten berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TbMenuData $menu_data)
    {
        $menu_data->load('menu');
        return view('admin.menu_data.show', compact('menu_data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TbMenuData $menu_data)
    {
        $menus = TbMenu::all();
        $contentType = $menu_data->jenis_konten;

        return view('admin.menu_data.edit', compact('menu_data', 'menus', 'contentType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TbMenuData $menu_data)
    {
        $request->validate(['menu_id' => 'required|exists:tb_menu,id']);

        try {
            $parentMenu = TbMenu::findOrFail($request->menu_id);
            $contentType = $parentMenu->jenis_konten;
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withInput()->withErrors(['menu_id' => 'Menu induk tidak ditemukan.']);
        }

        $rules = [
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'link' => 'nullable|url|max:255',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2000',
            'jabatan' => 'nullable|string|max:255',
            'deskripsi_organisasi' => 'nullable|string',
        ];

        // --- Perubahan utama ada di blok ini ---
        if ($contentType === 'dinamis') {
            // Konten dinamis (Detail atau Link) minimal wajib punya judul dan isi.
            $rules['title'] = 'required|string|max:255';
            $rules['content'] = 'required|string';
            // Link akan divalidasi sebagai URL jika diisi. Jika link kosong, dianggap konten detail.
            
        } elseif ($contentType === 'media') {
            $rules['img'] = [
                'nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2000',
                // Wajib ada gambar baru jika gambar lama tidak ada
                Rule::requiredIf(function () use ($menu_data, $request) {
                    return !$menu_data->img && !$request->hasFile('img');
                })
            ];
            
        } elseif ($contentType === 'organisasi') {
            $rules['title'] = 'required|string|max:255';
            $rules['jabatan'] = 'required|string|max:255';
            $rules['deskripsi_organisasi'] = 'required|string';
            
        } elseif ($contentType === 'statis') {
            $rules['title'] = 'required|string|max:255';
            $rules['content'] = 'required|string';
        }
        // --- Akhir perubahan utama ---

        $request->validate($rules);

        $data = $request->except(['_token', '_method', 'img', 'jabatan', 'deskripsi_organisasi']);
        $data['menu_id'] = $parentMenu->id;
        $data['jenis_konten'] = $contentType;

        // Penanganan Data Khusus
        if ($contentType === 'organisasi') {
            $organisasiData = [[
                'jabatan' => $request->jabatan,
                'deskripsi' => $request->deskripsi_organisasi,
            ]];
            $data['content'] = json_encode($organisasiData);
            $data['date'] = null;
            $data['location'] = null;
            $data['link'] = null;
            $data['title'] = $request->title;
        } elseif ($contentType === 'media') {
            $data['title'] = $request->title ?? null;
            $data['content'] = $request->content ?? null;
            $data['date'] = null;
            $data['location'] = null;
            $data['link'] = null;
        }

        $imagePath = $this->handleImageUpload($request, $contentType, $menu_data->img);

        if ($imagePath) {
            $data['img'] = $imagePath;
        } else {
            // Jika tidak ada upload baru, pertahankan yang lama, kecuali untuk organisasi/media yang mungkin tidak perlu gambar
            $data['img'] = $menu_data->img;
        }
        
        // Hapus image jika user memilih untuk menghapus atau jenis konten tidak membutuhkan gambar
        if ($request->filled('delete_img') && $menu_data->img && Storage::disk('public')->exists($menu_data->img)) {
             Storage::disk('public')->delete($menu_data->img);
             $data['img'] = null;
        }


        $menu_data->update($data);

        return redirect()->route('admin.menu_data.index')->with('success', 'Konten berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TbMenuData $menu_data)
    {
        if ($menu_data->img && Storage::disk('public')->exists($menu_data->img)) {
            Storage::disk('public')->delete($menu_data->img);
        }

        $menu_data->delete();

        return redirect()->route('admin.menu_data.index')->with('success', 'Konten berhasil dihapus.');
    }
}