@extends('layouts.publik')
@section('judul', $foto['judul'].' — Fotoku')

@section('isi')
<div class="max-w-6xl mx-auto px-5 py-8 space-y-6">

    <nav class="text-sm">
        <a href="{{ route('beranda') }}" class="text-stone-400 hover:text-emas-400 transition-colors">
            &larr; Semua album
        </a>
        <span class="text-stone-600"> / {{ ucfirst($foto['album']) }}</span>
    </nav>

    {{-- Foto utama. KENAPA max-h-78vh: layar penuh membuat kontrol
         navigasi keluar dari pandangan; sisanya untuk metadata. --}}
    <figure class="bingkai-detail rounded-xl overflow-hidden border border-malam-800">
        <img src="/img/{{ $foto['webp'] }}" alt="{{ $foto['judul'] }}"
             width="{{ $foto['lebar'] }}" height="{{ $foto['tinggi'] }}">
    </figure>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Kolom kiri: judul + navigasi antar foto dalam album --}}
        <div class="md:col-span-2 space-y-4">
            <h1 class="text-2xl font-semibold text-stone-100 tracking-tight">{{ $foto['judul'] }}</h1>

            <div class="flex gap-3">
                <a href="{{ route('foto.detail', ['album' => $foto['album'], 'berkas' => $foto['sebelum']['webp']]) }}"
                   class="px-4 py-2 rounded-lg border border-malam-700 text-sm text-stone-300 hover:border-emas-500 hover:text-emas-400 transition-colors">
                    &larr; Sebelumnya
                </a>
                <a href="{{ route('foto.detail', ['album' => $foto['album'], 'berkas' => $foto['sesudah']['webp']]) }}"
                   class="px-4 py-2 rounded-lg border border-malam-700 text-sm text-stone-300 hover:border-emas-500 hover:text-emas-400 transition-colors">
                    Berikutnya &rarr;
                </a>
            </div>
        </div>

        {{-- Kolom kanan: data teknis + kredit --}}
        <aside class="bg-malam-900 border border-malam-800 rounded-xl p-5">
            <h2 class="label-album mb-4">Data foto</h2>

            @if (!empty($exif))
                <dl class="tabel-exif grid grid-cols-2 gap-x-4 gap-y-2 text-sm">
                    @foreach ($exif as $k => $v)
                        <dt>{{ ucfirst($k) }}</dt>
                        <dd>{{ $v }}</dd>
                    @endforeach
                </dl>
            @endif

            <div class="mt-5 pt-4 border-t border-malam-800 text-sm space-y-1">
                <p class="text-stone-500">Pemotret: <span class="text-stone-300">{{ $foto['pemotret'] }}</span></p>
                <p class="text-stone-500">Lisensi: <span class="text-stone-300">{{ $foto['lisensi'] }}</span></p>
                <p class="text-stone-500 break-all">Sumber:
                    <a href="{{ $foto['url'] }}" rel="noopener" class="text-emas-400 hover:underline">Wikimedia Commons</a>
                </p>
            </div>
        </aside>
    </div>

</div>
@endsection
