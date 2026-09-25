{{--
    Layout publik Fotoku.
    KENAPA TANPA NAVIGASI RUMIT: situs ini cuma dua halaman — kumpulan
    album dan detail foto. Header berisi nama + deskripsi satu baris;
    lebih dari itu mengganggu foto.
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Portofolio fotografi — pemandangan Indonesia.">
    <title>@yield('judul', 'Fotoku — portofolio fotografi')</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen flex flex-col">
    <header class="border-b border-malam-800">
        <div class="max-w-6xl mx-auto px-5 py-6 flex items-baseline justify-between gap-4">
            <a href="{{ route('beranda') }}" class="text-lg font-semibold text-stone-100 tracking-tight">
                Foto<span class="text-emas-500">ku</span>
            </a>
            <p class="text-sm text-stone-500">Pemandangan Indonesia — gunung, pantai, kota, air</p>
        </div>
    </header>

    <main class="flex-1">
        @yield('isi')
    </main>

    <footer class="border-t border-malam-800 mt-16">
        <div class="max-w-6xl mx-auto px-5 py-6 text-sm text-stone-500 flex flex-wrap gap-x-6 gap-y-2 justify-between">
            <span>&copy; {{ date('Y') }} Fotoku — portofolio latihan.</span>
            <span>Foto: Wikimedia Commons, kredit per foto.</span>
        </div>
    </footer>
</body>
</html>
