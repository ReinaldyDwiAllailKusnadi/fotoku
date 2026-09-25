@extends('layouts.publik')
@section('judul', 'Fotoku — portofolio fotografi')

@section('isi')
<div class="max-w-6xl mx-auto px-5 py-10 space-y-12">

    {{-- Pengantar satu paragraf. KENAPA SINGKAT: pengunjung datang
         untuk melihat foto, bukan membaca. --}}
    <section class="max-w-2xl">
        <h1 class="text-3xl font-semibold text-stone-100 tracking-tight">Koleksi pemandangan Indonesia.</h1>
        <p class="mt-3 text-stone-400 leading-relaxed">
            Empat album — gunung, pantai, kota, dan air. Klik foto mana pun untuk
            melihatnya besar beserta data teknis dan kredit pemotretnya.
        </p>
    </section>

    @foreach ($album as $a)
        <section aria-label="Album {{ $a['label'] }}">
            <div class="flex items-baseline justify-between mb-4">
                <h2 class="label-album">{{ $a['label'] }}</h2>
                <span class="text-sm text-stone-500">{{ $a['jumlah'] }} foto</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                @foreach ($a['foto'] as $f)
                    <a href="{{ route('foto.detail', ['album' => $a['nama'], 'berkas' => $f['webp']]) }}"
                       class="kartu-foto">
                        <img src="/img/{{ $f['webp'] }}"
                             alt="{{ $f['judul'] }}"
                             width="{{ $f['lebar'] }}" height="{{ $f['tinggi'] }}"
                             loading="lazy">
                        <span class="keterangan-foto">
                            <span class="text-stone-200 truncate">{{ $f['judul'] }}</span>
                            <span class="text-stone-500 shrink-0">{{ $f['lisensi'] }}</span>
                        </span>
                    </a>
                @endforeach
            </div>
        </section>
    @endforeach

</div>
@endsection
