<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman katalog buku dengan fitur pencarian, filter, sorting, dan paginasi.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $penerbit = $request->input('penerbit');
        $status = $request->input('status');
        $sort = $request->input('sort');

        $buku = Buku::when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%");
            });
        })
            ->when($penerbit, fn ($query) => $query->where('penerbit', $penerbit))
            ->when($status === 'tersedia', function ($query) {
                $query->where('stok', '>', 0);
            })
            ->when($status === 'habis', function ($query) {
                $query->where('stok', '<=', 0);
            })
            ->when($sort === 'judul', fn ($q) => $q->orderBy('judul', 'asc'))
            ->when($sort === 'tahun', fn ($q) => $q->orderBy('tahun_terbit', 'desc'))
            ->when($sort === 'stok', fn ($q) => $q->orderBy('stok', 'desc'))
            ->when(in_array($sort, ['judul_asc', 'judul_desc', 'tahun_desc', 'tahun_asc', 'stok_desc']), function ($query) use ($sort) {
                match ($sort) {
                    'judul_asc' => $query->orderBy('judul', 'asc'),
                    'judul_desc' => $query->orderBy('judul', 'desc'),
                    'tahun_desc' => $query->orderBy('tahun_terbit', 'desc'),
                    'tahun_asc' => $query->orderBy('tahun_terbit', 'asc'),
                    'stok_desc' => $query->orderBy('stok', 'desc'),
                };
            })
            ->when(!$sort, fn ($q) => $q->latest())
            ->paginate(5)
            ->withQueryString();

        $listPenerbit = Buku::whereNotNull('penerbit')
            ->distinct()
            ->orderBy('penerbit')
            ->pluck('penerbit');

        return view('home', compact('buku', 'search', 'penerbit', 'status', 'sort', 'listPenerbit'));
    }
    /**
     * Menampilkan halaman detail informasi sebuah buku untuk publik/mahasiswa.
     */
    public function show(Buku $buku)
    {
        return view('home_show', compact('buku'));
    }
}
