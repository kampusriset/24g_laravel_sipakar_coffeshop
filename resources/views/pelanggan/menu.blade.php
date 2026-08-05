<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Nusaroma | Menu</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.tailwindcss.com"></script>

<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

</head>

<body class="bg-white min-h-screen">

<div class="flex min-h-screen">

    @include('pelanggan.partials.sidebar')

    <main class="flex-1 ml-64">

        <div class="max-w-[1900px] mx-auto px-10 py-10">

            <div class="grid xl:grid-cols-[minmax(0,1fr)_340px] gap-12">

                {{-- LEFT CONTENT --}}
                <section>

                    {{-- Header --}}
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8 mb-12">

                        <div>

                            <p class="text-xs uppercase tracking-[0.35em] text-orange-500 font-bold">

                                MENU

                            </p>

                            <h1 class="mt-3 text-3xl font-semibold text-gray-900 leading-tight">

                                Explore Our Menu

                            </h1>

                            <p class="mt-5 max-w-xl text-lg text-gray-500 leading-8">

                                Discover freshly brewed coffee,
                                signature drinks,
                                and delicious snacks crafted
                                for every moment.

                            </p>

                        </div>



                        {{-- Search --}}
                        <form
                            action="{{ route('pelanggan.menu') }}"
                            method="GET">

                            @if(request('kategori_id'))

                                <input
                                    type="hidden"
                                    name="kategori_id"
                                    value="{{ request('kategori_id') }}">

                            @endif

                            <div class="relative">

                                <input
                                    type="text"
                                    name="cari"
                                    value="{{ request('cari') }}"
                                    placeholder="Cari menu favorit..."
                                    class="w-[380px] rounded-full border border-gray-200 py-4 pl-14 pr-5 text-gray-700 shadow-sm outline-none transition focus:border-orange-500">

                                <svg
                                    class="absolute left-5 top-4 h-6 w-6 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0a7 7 0 0114 0z"/>

                                </svg>

                            </div>

                        </form>

                    </div>



                    {{-- Filter --}}
                    <div class="mb-14">

                        <div class="flex flex-wrap gap-4">

                            <a
                                href="{{ route('pelanggan.menu') }}"
                                class="rounded-full px-7 py-3 font-semibold transition
                                {{ !request('kategori_id')
                                    ? 'bg-orange-500 text-white'
                                    : 'border border-gray-300 text-gray-700 hover:border-orange-500 hover:text-orange-500' }}">

                                Semua

                            </a>

                            @foreach($kategoriList as $kat)

                                <a
                                    href="{{ route('pelanggan.menu',['kategori_id'=>$kat->id]) }}"
                                    class="rounded-full px-7 py-3 font-semibold transition
                                    {{ request('kategori_id')==$kat->id
                                        ? 'bg-orange-500 text-white'
                                        : 'border border-gray-300 text-gray-700 hover:border-orange-500 hover:text-orange-500' }}">

                                    {{ $kat->nama }}

                                </a>

                            @endforeach

                        </div>

                    </div>



                    {{-- Popular --}}
                    <div class="flex items-center justify-between mb-8">

                        <div>

                            <p class="text-xs uppercase tracking-[0.35em] text-orange-500 font-bold">

                                POPULAR

                            </p>

                            <h2 class="mt-2 text-4xl font-bold text-gray-900">

                                Customer Favorites

                            </h2>

                        </div>

                        <a
                            href="{{ route('pelanggan.beranda') }}"
                            class="font-medium text-orange-500 hover:underline">

                            Kembali →

                        </a>

                    </div>



                    {{-- PRODUCT GRID MULAI DI SINI --}}
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">

                        

   @forelse($menu as $m)

    <div class="group overflow-hidden rounded-[26px] border border-gray-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl">

        {{-- IMAGE --}}
        @if($m->gambar)

            <img
                src="{{ asset('storage/'.$m->gambar) }}"
                class="h-52 w-full object-cover transition duration-500 group-hover:scale-105">

        @else

            <div class="flex h-52 items-center justify-center bg-gray-100 text-6xl">

                ☕

            </div>

        @endif


        {{-- CONTENT --}}
        <div class="p-5">

            <p class="text-xs uppercase tracking-[0.2em] text-orange-500">

                {{ $m->kategoriMenu->nama }}

            </p>

            <h3 class="mt-2 text-xl font-bold text-gray-900">

                {{ $m->nama }}

            </h3>

            <p class="mt-2 text-sm text-gray-500">

                @if(strtolower($m->kategoriMenu->nama) == 'coffee')

                    Freshly Brewed Coffee

                @elseif(strtolower($m->kategoriMenu->nama) == 'non coffee')

                    Refreshing Signature Drink

                @else

                    Perfect Side Dish

                @endif

            </p>


            <div class="mt-6 flex items-center justify-between">

                <span class="text-2xl font-bold text-gray-900">

                    Rp {{ number_format($m->harga,0,',','.') }}

                </span>

                <button

                    onclick="tambahKeranjang({{ $m->id }}, '{{ $m->nama }}', {{ $m->harga }})"

                    class="flex h-12 w-12 items-center justify-center rounded-full bg-orange-500 text-2xl text-white transition hover:rotate-90 hover:bg-orange-600">

                    +

                </button>

            </div>

        </div>

    </div>

    @empty

    <div class="col-span-full py-20 text-center">

        <div class="text-6xl">

            ☕

        </div>

        <h3 class="mt-5 text-2xl font-bold">

            Menu tidak ditemukan

        </h3>

    </div>

    @endforelse

                    </div>

                </section>



                {{-- CART --}}
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