<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Input Pesanan Baru</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body class="bg-orange-50 min-h-screen">
    <div class="flex min-h-screen">

        {{-- SIDEBAR --}}
        <aside class="fixed left-0 top-0 h-screen w-64 bg-white border-r border-gray-200 flex flex-col">

            {{-- Logo --}}
            <div class="h-24 flex items-center px-8 border-b border-gray-200">

                <img
                    src="{{ asset('image/logo-nusaroma.png') }}"
                    class="w-11 h-11 object-contain">

                <div class="ml-3">
                    <h1 class="text-lg font-bold tracking-wide text-gray-900">
                        Nusaroma
                    </h1>
                </div>

            </div>

            {{-- Menu --}}
            <nav class="flex-1 px-5 py-8 space-y-2">

                <a href="{{ route('dashboard') }}"
                class="group flex items-center gap-4 rounded-xl px-4 py-3 transition-all duration-300
                {{ request()->routeIs('dashboard')
                    ? 'bg-gray-100 text-orange-500'
                    : 'text-gray-500 hover:bg-gray-50 hover:text-orange-500' }}">

                    <span class="text-lg"><i class="fa-solid fa-house"></i></span>

                    <span class="font-medium">
                        Dashboard
                    </span>

                </a>

                <a href="{{ route('pesanan.baru') }}"
                class="group flex items-center gap-4 rounded-xl px-4 py-3 transition-all duration-300
                {{ request()->routeIs('pesanan.baru')
                    ? 'bg-gray-100 text-orange-500'
                    : 'text-gray-500 hover:bg-gray-50 hover:text-orange-500' }}">

                    <span class="text-lg"><i class="fa-solid fa-receipt"></i></span>

                    <span class="font-medium">
                        Input Pesanan
                    </span>

                </a>
            </nav>

            {{-- Bottom --}}
            <div class="p-5 border-t border-gray-200">

                <div class="rounded-2xl border border-orange-200 bg-orange-50 p-4">

                    <p class="text-xs text-gray-500">
                        Login sebagai
                    </p>

                    <p class="mt-1 font-semibold text-gray-900">
                        {{ Auth::user()->name }}
                    </p>

                    <p class="text-sm text-gray-500">
                        {{ ucfirst(Auth::user()->role) }}
                    </p>

                    <form action="{{ route('logout') }}" method="POST" class="mt-4">
                        @csrf

                        <button
                            type="submit"
                            class="w-full rounded-xl bg-orange-500 py-3 font-medium text-white transition hover:bg-orange-600">

                            Logout

                        </button>

                    </form>

                </div>

            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <div class="flex-1 ml-64">
            {{-- HEADER --}}
            <div class="bg-white border-b">

                <div class="bg-white border border-gray-200 rounded-2xl px-8 py-6 shadow-sm">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-[11px] uppercase tracking-[0.35em] text-orange-500 font-bold">
                                INPUT PESANAN
                            </p>

                            <h1 class="mt-1 text-3xl font-bold text-gray-900">
                                Input Pesanan Baru
                            </h1>

                            <p class="mt-2 text-sm text-gray-500">
                                Pilih menu pelanggan lalu simpan transaksi.
                            </p>

                        </div>

                        <a
                            href="{{ route('dashboard') }}"
                            class="border border-orange-500 text-orange-500 px-5 py-2 rounded-xl text-sm font-medium hover:bg-orange-500 hover:text-white transition">

                            ← Dashboard

                        </a>

                    </div>

                </div>

                <form action="{{ route('pesanan.baru.simpan') }}" method="POST" id="form-pesanan">
                @csrf

                <div class="max-w-[1600px] mx-auto px-10 pb-10">

                    <div class="grid lg:grid-cols-3 gap-8">

                        {{-- MENU --}}
                        <div class="lg:col-span-2">

                            @foreach($kategori as $kat)

                                <div class="mb-10">

                                    <h2 class="text-2xl font-bold text-gray-900 mb-6">
                                        {{ $kat->nama }}
                                    </h2>

                                    <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">

                                        @foreach($kat->menu as $m)

                                            {{-- CARD MENU --}}
                                            <div class="group overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">

                            {{-- Gambar --}}
                            <div class="h-52 overflow-hidden bg-gray-100">

                                @if($m->gambar)
                                    <img
                                        src="{{ asset('storage/'.$m->gambar) }}"
                                        class="w-full h-full object-cover transition duration-300 group-hover:scale-105">
                                @else
                                    <div class="flex items-center justify-center h-full text-gray-400">
                                        No Image
                                    </div>
                                @endif

                            </div>

                            {{-- Konten --}}
                            <div class="p-5">

                                <p class="text-xs uppercase tracking-[0.3em] text-orange-500 font-semibold">
                                    {{ $kat->nama }}
                                </p>

                                <h3 class="mt-2 text-xl font-bold text-gray-900">
                                    {{ $m->nama }}
                                </h3>

                                <p class="mt-2 text-sm text-gray-500 line-clamp-2">
                                    {{ $m->deskripsi }}
                                </p>

                                <div class="mt-6 flex items-end justify-between">

                                    <div>

                                        <p class="text-sm text-gray-400">
                                            Harga
                                        </p>

                                        <p class="text-2xl font-bold text-orange-600">
                                            Rp {{ number_format($m->harga,0,',','.') }}
                                        </p>

                                    </div>

                                    <button
                                        type="button"
                                        onclick="tambahItem({{ $m->id }}, '{{ $m->nama }}', {{ $m->harga }})"
                                        class="flex h-12 w-12 items-center justify-center rounded-full bg-orange-500 text-white hover:bg-orange-600 transition">

                                        <i class="fa-solid fa-plus text-lg"></i>

                                    </button>

                                </div>

                            </div>

                        </div>

                                        @endforeach

                                    </div>

                                </div>

                            @endforeach

                        </div>

                        {{-- PANEL PESANAN --}}
                        <div class="sticky top-8">

                            <div class="rounded-3xl border border-gray-200 bg-white p-8 shadow-sm">

                                <h2 class="text-2xl font-bold text-gray-900">
                                    Pesanan
                                </h2>

                                <div
                                    id="daftar-item"
                                    class="mt-6 min-h-[250px] space-y-4">

                                    <p class="text-center text-gray-400 py-8">
                                        Belum ada item dipilih.
                                    </p>

                                </div>

                                <div class="mt-6 border-t pt-6">

                                    <div class="flex justify-between items-center">

                                        <span class="text-gray-500">
                                            Total
                                        </span>

                                        <span
                                            id="total-text"
                                            class="text-3xl font-bold text-orange-500">

                                            Rp 0

                                        </span>

                                    </div>

                                </div>

                                <div class="mt-8">

                                    <label class="block mb-2 font-medium">

                                        Nama Pelanggan

                                    </label>

                                    <input
                                        type="text"
                                        name="nama_pelanggan"
                                        class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:outline-none focus:border-orange-500"
                                        required>

                                </div>

                                <div class="mt-6">

                                    <label class="block mb-3 font-medium">

                                        Metode Pembayaran

                                    </label>

                                    <div class="grid grid-cols-2 gap-3">

                                        <label class="payment-label cursor-pointer">

                                            <input
                                                type="radio"
                                                name="metode_pembayaran"
                                                value="tunai"
                                                class="hidden payment-radio"
                                                checked>

                                            <div class="payment-card rounded-xl border border-orange-500 bg-orange-500 py-3 text-center font-medium text-white transition">
                                                Tunai
                                            </div>

                                        </label>

                                        <label class="payment-label cursor-pointer">

                                            <input
                                                type="radio"
                                                name="metode_pembayaran"
                                                value="qris"
                                                class="hidden payment-radio">

                                            <div class="payment-card rounded-xl border border-gray-300 py-3 text-center font-medium transition">
                                                QRIS
                                            </div>

                                        </label>

                                    </div>

                                </div>

                                <div id="hidden-items"></div>

                                <button
                                    type="submit"
                                    class="mt-8 w-full rounded-2xl bg-orange-500 py-4 text-lg font-semibold text-white hover:bg-orange-600 transition">

                                    Simpan Pesanan

                                </button>

                            </div>

                        </div>

                    </div>

                </div>

                </form>

            </div>
        </div>
    </div>

    <script>
        let cart = [];

        function tambahItem(menuId, nama, harga) {
            let existing = cart.find(item => item.menu_id === menuId);
            if (existing) {
                existing.jumlah += 1;
            } else {
                cart.push({ menu_id: menuId, nama: nama, harga: harga, jumlah: 1 });
            }
            render();
        }

        function ubahJumlah(index, delta) {
            cart[index].jumlah += delta;
            if (cart[index].jumlah <= 0) {
                cart.splice(index, 1);
            }
            render();
        }

        function render() {
            let list = document.getElementById('daftar-item');
            let total = 0;

            if (cart.length === 0) {
                list.innerHTML = '<p class="text-gray-500 text-center py-6 text-sm">Belum ada item dipilih.</p>';
            } else {
                list.innerHTML = cart.map((item, i) => {
                    total += item.harga * item.jumlah;
                    return `
                        <div class="flex justify-between items-center border-b pb-3">
                            <div>
                                <p class="font-semibold text-sm">${item.nama}</p>
                                <p class="text-xs text-gray-500">Rp ${item.harga.toLocaleString('id-ID')}</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <button type="button" onclick="ubahJumlah(${i}, -1)" class="bg-gray-200 w-7 h-7 rounded">-</button>
                                <span class="text-sm">${item.jumlah}</span>
                                <button type="button" onclick="ubahJumlah(${i}, 1)" class="bg-gray-200 w-7 h-7 rounded">+</button>
                            </div>
                        </div>
                    `;
                }).join('');
            }

            document.getElementById('total-text').innerText = 'Rp ' + total.toLocaleString('id-ID');

            let hiddenContainer = document.getElementById('hidden-items');
            hiddenContainer.innerHTML = '';
            cart.forEach((item, i) => {
                hiddenContainer.innerHTML += `
                    <input type="hidden" name="items[${i}][menu_id]" value="${item.menu_id}">
                    <input type="hidden" name="items[${i}][harga]" value="${item.harga}">
                    <input type="hidden" name="items[${i}][jumlah]" value="${item.jumlah}">
                `;
            });
        }

        document.getElementById('form-pesanan').addEventListener('submit', function (e) {
            if (cart.length === 0) {
                e.preventDefault();
                alert('Pilih minimal 1 menu terlebih dahulu.');
            }
        });

        document.querySelectorAll('.payment-radio').forEach(radio => {

            radio.addEventListener('change', function () {

                document.querySelectorAll('.payment-card').forEach(card => {

                    card.classList.remove(
                        'bg-orange-500',
                        'text-white',
                        'border-orange-500'
                    );

                    card.classList.add(
                        'border-gray-300'
                    );

                });

                const card = this.nextElementSibling;

                card.classList.remove('border-gray-300');

                card.classList.add(
                    'bg-orange-500',
                    'text-white',
                    'border-orange-500'
                );

            });

        });        
    </script>
</body>
</html>