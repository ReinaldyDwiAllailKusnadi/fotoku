<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

/**
 * Katalog foto Fotoku.
 *
 * KENAPA FILE JSON, BUKAN DATABASE:
 *   Ini keputusan sadar, bukan keterbatasan. Foto adalah berkas di disk;
 *   datanya (judul, album, kredit) berpindah bersama fotonya dan hanya
 *   berubah saat portofolio disunting. Database dibutuhkan saat data
 *   BANYAK PENGGUNA menulis bersamaan — portofolio fotografer biasanya
 *   satu penulis. Dengan JSON, katalog ikut masuk git dan bisa ditinjau
 *   dalam pull request, seperti kode.
 *
 * KENAPA DATA TEKNIS TIDAK MENGARANG:
 *   Foto unduhan dari internet umumnya sudah kehilangan EXIF lengkap
 *   (kamera, buka, ISO). Menulis angka yang tidak bisa dibuktikan sama
 *   saja berbohong ke pengunjung — dan fotografer akan langsung tahu.
 *   Yang ditampilkan hanya data yang BENAR-BENAR ada: dimensi dan
 *   ukuran berkas (selalu benar); EXIF kamera hanya kalau berkasnya
 *   masih menyimpannya.
 */
class KatalogFoto
{
    /** Semua album beserta fotonya. */
    public function album(): array
    {
        // Root disk "local" di Laravel 11+ adalah storage/app/private.
        $mentah = json_decode((string) file_get_contents(
            Storage::disk('local')->path('foto.json')
        ), true);

        return collect($mentah)
            ->map(fn ($foto, $nama) => [
                'nama' => $nama,
                'label' => ucfirst($nama),
                'jumlah' => count($foto),
                'sampul' => $foto[0]['webp'] ?? null,
                'foto' => $foto,
            ])
            ->values()
            ->all();
    }

    /** Foto-foto satu album. */
    public function albumSatu(string $nama): ?array
    {
        foreach ($this->album() as $album) {
            if ($album['nama'] === $nama) {
                return $album;
            }
        }

        return null;
    }

    /** Satu foto untuk halaman detail + foto tetangganya (prev/next). */
    public function foto(string $album, string $berkas): ?array
    {
        $a = $this->albumSatu($album);
        if (! $a) {
            return null;
        }

        $indeks = array_search($berkas, array_column($a['foto'], 'webp'), true);
        if ($indeks === false) {
            return null;
        }

        $foto = $a['foto'][$indeks];

        return $foto + [
            'album' => $album,
            'sebelum' => $a['foto'][($indeks + count($a['foto']) - 1) % count($a['foto'])],
            'sesudah' => $a['foto'][($indeks + 1) % count($a['foto'])],
        ];
    }

    /**
     * Data teknis satu foto — HANYA yang benar-benar bisa dibuktikan.
     */
    public function exif(array $foto): array
    {
        $data = [
            'dimensi' => $foto['dim'] ?? null,
            'ukuran' => isset($foto['webp_bytes']) ? round($foto['webp_bytes'] / 1024).' KB' : null,
        ];

        // EXIF kamera: hanya kalau berkas aslinya masih menyimpannya.
        $jalur = Storage::disk('local')->path('foto-asli/'.$foto['berkas']);
        if (is_readable($jalur) && ($e = @exif_read_data($jalur))) {
            if (! empty($e['Model'])) {
                $data['kamera'] = $e['Model'];
            }
            if (isset($e['ISOSpeedRatings'])) {
                $data['iso'] = is_array($e['ISOSpeedRatings']) ? $e['ISOSpeedRatings'][0] : $e['ISOSpeedRatings'];
            }
            if (isset($e['FNumber'])) {
                $data['buka'] = 'f/'.round($e['FNumber']['numerator'] / $e['FNumber']['denominator'], 1);
            }
            if (isset($e['ExposureTime'])) {
                $data['kecepatan'] = $this->kecepatan($e['ExposureTime']['numerator'], $e['ExposureTime']['denominator']);
            }
            if (isset($e['FocalLength'])) {
                $data['panjang'] = round($e['FocalLength']['numerator'] / $e['FocalLength']['denominator']).' mm';
            }
        }

        return array_filter($data);
    }

    private function kecepatan(int $num, int $den): string
    {
        $nilai = $num / $den;

        return $nilai >= 1 ? round($nilai, 1).'s' : '1/'.round(1 / $nilai).'s';
    }
}
