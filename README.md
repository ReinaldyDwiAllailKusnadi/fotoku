# Fotoku

Portofolio fotografi bertema gelap — proyek ke-9, dan yang pertama di
**Laravel tanpa database untuk konten** (katalog foto hidup dalam berkas
JSON; SQLite bawaan hanya dipakai sesi/cache).

**Live:** http://167.71.195.18:8087 (HTTP saja)

## Apa yang dipraktikkan di proyek ini

- **Service class** (`app/Services/KatalogFoto.php`) — controller tipis,
  logika data tidak menempel ke HTTP.
- **Tailwind CSS 4 CSS-first** — tema didefinisikan lewat `@theme` di CSS,
  bukan `tailwind.config.js` (cara Laravel 13 sekarang).
- **Tema gelap yang diukur** — kontras teks terendah 7,8:1 (WCAG AAA);
  pasangan 3,8:1 di kartu hanya untuk teks sekunder kecil non-esensial.
- **WebP q74** lebar maks 1600px — total 8 foto ± 1,8 MB.
- **Data teknis tidak mengarang** — EXIF kamera ditampilkan hanya bila
  berkasnya masih menyimpannya; dimensi + ukuran berkas selalu ditampilkan
  karena selalu benar.
- **Kredit + lisensi per foto** — sumber Wikimedia Commons, ditampilkan di
  halaman detail.

## Struktur

```
storage/app/private/foto.json      <- katalog (album, judul, kredit, lisensi)
storage/app/private/foto-asli/     <- berkas asli unduhan (untuk EXIF)
public/img/                        <- WebP yang disajikan
resources/views/beranda.blade.php  <- semua album dalam satu gulungan
resources/views/foto.blade.php     <- detail + navigasi prev/next
```

## Menjalankan

```bash
composer install
cp .env.example .env && php artisan key:generate
npm install && npm run build
php artisan serve --port=3007
```

Catatan deploy: nginx + php-fpm membaca proyek dari `/root/projects`, jadi
butuh ACL `www-data` (rX seluruh proyek, rwX di `storage/` dan
`bootstrap/cache/`) — detailnya di skill `laravel-app-delivery`.

## Akun uji

Tidak ada — situs ini sengaja tanpa login dan tanpa form.
