<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TbMenuData; // Menggunakan Model data pusat

class EventController extends Controller
{
    /**
     * Menampilkan daftar semua event (Index).
     * Menggunakan scope ofJenis('event') untuk memfilter data.
     */
    public function index()
    {
        // Ambil semua data dengan jenis_konten = 'event' dan paginasi
        $eventList = TbMenuData::ofJenis('event')->latest()->paginate(12);

        // Mengirimkan variabel $eventList ke view
        return view('events.index', compact('eventList'));
    }

    /**
     * Menampilkan detail spesifik dari satu event (Show).
     */
    public function show(string $id)
    {
        // Cari data berdasarkan ID, pastikan jenis_konten = 'event'.
        // Jika tidak ditemukan, otomatis melempar error 404.
        $event = TbMenuData::ofJenis('event')->findOrFail($id);

        // Mengirimkan variabel $event ke view
        return view('events.show', compact('event'));
    }
    
    // Fungsi-fungsi CRUD (create, store, edit, update, destroy) dihapus
    // karena sudah ditangani oleh AdminMenuDataController.
}
