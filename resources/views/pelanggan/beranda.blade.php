<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="UTF-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Nusaroma</title>

        <script src="https://cdn.tailwindcss.com"></script>

        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

        <link rel="preconnect" href="https://fonts.googleapis.com">

        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap"
            rel="stylesheet">

        <style>

            body{

                font-family:'Manrope',sans-serif;

            }

        </style>

    </head>

    <body class="bg-white">

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        @include('pelanggan.partials.sidebar')



        {{-- Main Content --}}
        <main class="flex-1 ml-64">

            <div class="max-w-[1700px] mx-auto px-10 py-10">

                <div class="grid xl:grid-cols-[1fr_360px] gap-10">

                    <div>

                        {{-- HEADER --}}
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8 mb-12">

                            <div>

                                <span class="text-xs uppercase tracking-[0.35em] text-orange-500 font-bold">

                                    NUSAROMA

                                </span>

                                <h1 class="mt-5 text-4xl xl:text-5xl font-extrabold leading-tight text-gray-900">

                                    Good Coffee
                                    <br>
                                    Starts Here.

                                </h1>

                                <p class="mt-4 max-w-md text-gray-500 leading-7">

                                    Nikmati pengalaman menikmati kopi dengan
                                    rekomendasi pintar dari AI Barista.

                                </p>

                            </div>



                            <form action="{{ route('pelanggan.menu') }}" method="GET">

                                <div class="relative">

                                    <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-gray-400"></i>

                                    <input

                                        type="text"

                                        name="cari"

                                        placeholder="Cari menu favorit..."

                                        class="w-96 rounded-full border border-gray-200 py-4 pl-14 pr-5 outline-none transition focus:border-orange-500 focus:ring-4 focus:ring-orange-100">

                                </div>

                            </form>

                        </div>





                        //Ai Barista
                        <section class="overflow-hidden rounded-[36px] border border-gray-200 bg-white mb-14">

                            <div class="grid lg:grid-cols-[1.2fr_0.8fr] items-center">

                                {{-- LEFT --}}
                                <div class="p-14">

                                    <span
                                        class="inline-flex items-center gap-2 rounded-full border border-orange-200 bg-orange-50 px-5 py-2 text-sm font-semibold text-orange-600">

                                        <i class="fa-solid fa-wand-magic-sparkles"></i>
                                        AI BARISTA

                                    </span>

                                    <h2 class="mt-8 text-5xl xl:text-6xl font-extrabold leading-tight text-gray-900">

                                        Coffee brewed with
                                        <br>

                                        <span class="text-orange-500">
                                            Artificial Intelligence
                                        </span>

                                    </h2>

                                    <p class="mt-8 max-w-xl text-lg leading-9 text-gray-500">

                                        Temukan minuman terbaik berdasarkan mood,
                                        aktivitas, dan selera kamu.
                                        AI Barista akan memberikan rekomendasi
                                        hanya dalam beberapa pertanyaan.

                                    </p>

                                    <div class="mt-10 flex flex-wrap gap-4">

                                        <a
                                            href="{{ route('ai-barista.index') }}"
                                            class="rounded-full bg-orange-500 px-8 py-4 font-semibold text-white transition hover:bg-orange-600">

                                            Mulai Sekarang

                                        </a>

                                        <a
                                            href="{{ route('pelanggan.menu') }}"
                                            class="rounded-full border border-gray-300 px-8 py-4 font-semibold transition hover:border-orange-500 hover:text-orange-500">

                                            Lihat Menu

                                        </a>

                                    </div>

                                </div>

                                {{-- RIGHT --}}
                                <div class="relative h-full overflow-hidden bg-orange-50">

                                    {{-- efek glow --}}
                                    <div class="absolute inset-0 bg-gradient-to-br from-orange-100 via-orange-50 to-white"></div>

                                    <img
                                        src="{{ asset('images/coffee.jpg') }}"
                                        alt="Hero Coffee"
                                        class="relative h-full w-full object-cover">

                                </div>

                            </div>

                        </section>

                                    {{-- CATEGORY --}}
                        <section class="mb-20">

                            <div class="flex items-center justify-between mb-8">

                                <div>

                                    <p class="text-sm uppercase tracking-[0.3em] text-orange-500 font-bold">
                                        MENU
                                    </p>

                                    <h3 class="mt-2 text-3xl font-extrabold text-gray-900">
                                        Explore Our Menu
                                    </h3>

                                </div>

                                <a href="{{ route('pelanggan.menu') }}"
                                    class="font-semibold text-orange-500 hover:text-orange-600 transition">

                                    Lihat Semua →

                                </a>

                            </div>

                            <div class="flex flex-wrap gap-3">

                                <a href="{{ route('pelanggan.menu') }}"
                                    class="rounded-full bg-orange-500 text-white px-6 py-3 font-semibold">

                                    Semua

                                </a>

                                @foreach($kategori as $kat)

                                    <a href="{{ route('pelanggan.menu',['kategori_id'=>$kat->id]) }}"
                                        class="rounded-full border border-gray-300 bg-white px-6 py-3 font-medium text-gray-700 transition hover:border-orange-500 hover:text-orange-500">

                                        {{ $kat->nama }}

                                    </a>

                                @endforeach

                            </div>

                        </section>





                        {{-- POPULAR MENU --}}
                        <section>

                            <div class="flex items-center justify-between mb-8">

                                <div>

                                    <p class="text-sm uppercase tracking-[0.3em] text-orange-500 font-bold">
                                        POPULAR
                                    </p>

                                    <h3 class="mt-2 text-3xl font-extrabold text-gray-900">
                                        Customer Favorites
                                    </h3>

                                </div>

                            </div>



                            <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-8">

                                @foreach($menuPopuler as $m)

                                    <div
                                        class="group rounded-[28px] border border-gray-200 overflow-hidden bg-white transition duration-300 hover:-translate-y-2 hover:shadow-xl">

                                        {{-- IMAGE --}}
                                        <div class="overflow-hidden bg-gray-100">

                                            @if($m->gambar)

                                                <img
                                                    src="{{ asset('storage/'.$m->gambar) }}"
                                                    alt="{{ $m->nama }}"
                                                    class="h-72 w-full object-cover transition duration-500 group-hover:scale-105">

                                            @else

                                                <div class="flex h-72 items-center justify-center">

                                                    <i class="fa-solid fa-mug-hot text-7xl text-orange-300"></i>

                                                </div>

                                            @endif

                                        </div>





                                        {{-- CONTENT --}}
                                        <div class="p-6">

                                            <div class="flex justify-between items-start">

                                                <div>

                                                    <h4 class="text-xl font-bold text-gray-900">

                                                        {{ $m->nama }}

                                                    </h4>

                                                    <p class="mt-2 text-sm text-gray-500">
                                                        {{ $m->kategoriMenu->nama }}
                                                    </p>

                                                </div>

                                                <button

                                                    onclick="tambahKeranjang({{ $m->id }}, '{{ $m->nama }}', {{ $m->harga }}, '{{ $m->gambar ? asset('storage/'.$m->gambar) : '' }}')"

                                                    class="w-12 h-12 rounded-full bg-orange-500 text-white transition hover:bg-orange-600 hover:scale-110">

                                                    <i class="fa-solid fa-plus"></i>

                                                </button>

                                            </div>





                                            <div class="mt-8 flex items-center justify-between">

                                                <span class="text-2xl font-extrabold text-gray-900">

                                                    Rp {{ number_format($m->harga,0,',','.') }}

                                                </span>

                                                <span
                                                    class="rounded-full bg-orange-50 px-4 py-2 text-sm font-semibold text-orange-500">

                                                    Bestseller

                                                </span>

                                            </div>

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        </section>

                    </div>

                    <aside class="hidden xl:block">

                        <div class="sticky top-8">

                            @include('pelanggan.partials.cart-panel')

                        </div>

                    </aside>

                </div>

            </div>

        </main>

    </div>

    </body>
</html>