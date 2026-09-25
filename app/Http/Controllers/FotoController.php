<?php

namespace App\Http\Controllers;

use App\Services\KatalogFoto;

/**
 * Controller Fotoku — dua halaman, tanpa database, tanpa form.
 *
 * KENAPA DATA DIAMBIL DI CONTROLLER, BUKAN DI VIEW: view hanya boleh
 * menampilkan; mencari data adalah kerja controller. Dengan begitu view
 * bisa diganti-ganti tanpa menyentuh logika.
 */
class FotoController extends Controller
{
    public function __construct(private KatalogFoto $katalog) {}

    public function beranda()
    {
        return view('beranda', [
            'album' => $this->katalog->album(),
        ]);
    }

    public function detail(string $album, string $berkas)
    {
        // Foto tidak ada -> 404, bukan halaman kosong dengan foto rusak.
        $foto = $this->katalog->foto($album, $berkas);
        abort_unless($foto !== null, 404);

        return view('foto', [
            'foto' => $foto,
            'exif' => $this->katalog->exif($foto),
        ]);
    }
}
