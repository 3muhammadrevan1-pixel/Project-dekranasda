<?php

namespace App\Http\Controllers; // PERBAIKAN: Namespace diubah ke root Controllers

use App\Models\TbMenu; // Pastikan import Model TbMenu
use Illuminate\Database\Eloquent\Collection;

class NavbarController extends Controller
{
    /**
     * Ambil data menu utama dan sub-menu yang aktif untuk Navbar.
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getActiveMenu(): Collection
    {
        // Mengambil semua menu utama (parent_id = 0)
        // yang berstatus 'aktif' dan diurutkan.
        // Eager load 'children' (sub-menu) yang juga 'aktif' dan terurut.
        $menus = TbMenu::aktif() // Scope aktif() dari model TbMenu
            ->where('parent_id', 0)
            ->urut() // Scope urut() dari model TbMenu
            ->with(['children' => function ($query) {
                // Eager load children, pastikan children juga aktif dan terurut.
                $query->aktif()->urut();
            }])
            ->get();

        return $menus;
    }
}