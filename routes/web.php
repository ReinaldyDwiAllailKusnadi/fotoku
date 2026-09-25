<?php

use App\Http\Controllers\FotoController;
use Illuminate\Support\Facades\Route;

/*
 * Fotoku hanya punya dua halaman: beranda (semua album) dan detail foto.
 * KENAPA TIDAK /album/terpisah: empat album muat di satu gulungan beranda;
 * halaman per album justru menambah klik tanpa menambah informasi.
 */
Route::get('/', [FotoController::class, 'beranda'])->name('beranda');
Route::get('/foto/{album}/{berkas}', [FotoController::class, 'detail'])
    ->where('berkas', '[A-Za-z0-9._-]+')
    ->name('foto.detail');
