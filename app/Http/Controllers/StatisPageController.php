<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StatisPage;

class StatisPageController extends Controller
{
    public function sejarah()
    {
        $page = StatisPage::where('slug', 'sejarah')->first();

        if (!$page) {
            abort(404, 'Halaman tidak ditemukan');
        }

        return view('about.sejarah', compact('page'));
    }
}
