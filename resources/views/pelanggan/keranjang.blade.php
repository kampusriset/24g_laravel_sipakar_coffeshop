<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Keranjang - A Coffee</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    </head>

    <body class="bg-gray-50 min-h-screen">
        <div class="flex min-h-screen">
            @include('pelanggan.partials.sidebar')
            <main class="flex-1 ml-64">
                <div class="max-w-5xl mx-auto px-10 py-10">
                    {{-- Header --}}
                    <div class="flex items-center justify-between mb-10">
                        <div>
                            <p class="text-xs uppercase tracking-[0.35em] text-orange-500 font-bold">
                                SHOPPING CART
                            </p>

                            <h1 class="mt-2 text-3xl font-bold text-gray-900">
                                Keranjang Anda
                            </h1>

                            <p class="mt-3 text-gray-500">
                                Periksa kembali pesanan sebelum melanjutkan ke pembayaran.
                            </p>
                        </div>

                        <a
                            href="{{ route('pelanggan.menu') }}"
                            class="flex items-center gap-2 rounded-xl border border-orange-300 px-5 py-3 text-sm font-medium text-orange-600 hover:bg-orange-50">

                            <i class="fa-solid fa-arrow-left"></i>

                            Tambah Menu
                        </a>
                    </div>

                    {{-- Daftar Keranjang --}}
                    <div id="cart-list" class="space-y-5 mb-8"></div>

                    {{-- Ringkasan --}}
                    <div class="bg-white rounded-3xl border border-gray-200 shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">
                                    Total Pembayaran
                                </p>

                                <h2
                                    id="cart-total"
                                    class="mt-1 text-3xl font-bold text-orange-500">
                                    Rp 0
                                </h2>
                            </div>

                            <button
                                onclick="lanjutCheckout()"
                                class="rounded-xl bg-orange-500 px-8 py-4 text-white font-semibold hover:bg-orange-600 transition">
                                Lanjut ke Checkout →
                            </button>
                        </div>
                    </div>
                </div>
            </main>
        </div>

    <script>
        function getCart() {
            return JSON.parse(localStorage.getItem('cart') || '[]');
        }

        function saveCart(cart) {
            localStorage.setItem('cart', JSON.stringify(cart));
            render();
        }

        function ubahJumlah(index, delta) {
            let cart = getCart();

            cart[index].jumlah += delta;

            if (cart[index].jumlah <= 0) {
                cart.splice(index, 1);
            }

            saveCart(cart);
        }

        function render() {

            let cart = getCart();
            let list = document.getElementById('cart-list');
            let total = 0;

            if (cart.length === 0) {

                list.innerHTML = `
                    <div class="bg-white border border-dashed border-gray-300 rounded-3xl py-20 px-10 text-center">

                        <div class="text-6xl mb-5">
                            ☕
                        </div>

                        <h3 class="text-2xl font-bold text-gray-900">
                            Keranjang Masih Kosong
                        </h3>

                        <p class="mt-3 text-gray-500">
                            Tambahkan menu favorit Anda terlebih dahulu.
                        </p>

                        <a
                            href="{{ route('pelanggan.menu') }}"
                            class="inline-block mt-8 bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-xl font-medium">

                            Jelajahi Menu

                        </a>

                    </div>
                `;

            } else {

                list.innerHTML = cart.map((item, i) => {

                    const subtotal = item.harga * item.jumlah;
                    total += subtotal;

                    return `

                    <div class="bg-white rounded-3xl border border-gray-200 shadow-sm p-6">

                        <div class="flex justify-between items-center">

                            <div class="flex items-center gap-5">
                                <div class="w-20 h-20 rounded-2xl overflow-hidden bg-orange-100">

                                    ${
                                        item.gambar
                                        ? `<img src="${item.gambar}" alt="${item.nama}" class="w-full h-full object-cover">`
                                        : `<div class="w-full h-full flex items-center justify-center text-3xl">☕</div>`
                                    }

                                </div>

                                <div>

                                    <p class="text-xs uppercase tracking-widest text-orange-500 font-semibold">

                                        Coffee Menu

                                    </p>

                                    <h3 class="mt-1 text-xl font-bold text-gray-900">

                                        ${item.nama}

                                    </h3>

                                    <p class="mt-2 text-sm text-gray-500">

                                        Harga

                                    </p>

                                    <p class="font-semibold text-gray-900">

                                        Rp ${item.harga.toLocaleString('id-ID')}

                                    </p>

                                </div>

                            </div>

                            <div class="text-right">

                                <div class="flex items-center justify-end gap-3 mb-4">

                                    <button
                                        onclick="ubahJumlah(${i}, -1)"
                                        class="w-10 h-10 rounded-full bg-orange-100 text-orange-600 hover:bg-orange-500 hover:text-white transition">

                                        <i class="fa-solid fa-minus"></i>

                                    </button>

                                    <span class="w-8 text-center text-lg font-bold">

                                        ${item.jumlah}

                                    </span>

                                    <button
                                        onclick="ubahJumlah(${i}, 1)"
                                        class="w-10 h-10 rounded-full bg-orange-500 text-white hover:bg-orange-600 transition">

                                        <i class="fa-solid fa-plus"></i>

                                    </button>

                                </div>

                                <p class="text-sm text-gray-500">

                                    Subtotal

                                </p>

                                <p class="text-2xl font-bold text-orange-500">

                                    Rp ${subtotal.toLocaleString('id-ID')}

                                </p>

                            </div>

                        </div>

                    </div>

                    `;

                }).join('');
            }

            document.getElementById('cart-total').innerText =
                'Rp ' + total.toLocaleString('id-ID');
        }

        function lanjutCheckout() {

            let cart = getCart();

            if (cart.length === 0) {
                alert('Keranjang masih kosong.');
                return;
            }

            window.location.href = "{{ route('pelanggan.checkout') }}";
        }

        render();
</script>
    </body>
</html>