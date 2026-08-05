<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Keranjang - A Coffee</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-orange-50 min-h-screen">
    <div class="flex min-h-screen">

        @include('pelanggan.partials.sidebar')

        <div class="flex-1 ml-64 p-8">
            <div class="max-w-2xl mx-auto">
                <h1 class="text-2xl font-bold mb-6">🛒 Keranjang Anda</h1>

                <div id="cart-list" class="space-y-3 mb-6"></div>

                <div class="bg-white rounded-xl shadow-sm p-4 flex justify-between items-center mb-6">
                    <span class="font-semibold">Total</span>
                    <span id="cart-total" class="text-xl font-bold text-amber-700">Rp 0</span>
                </div>

                <a href="{{ route('pelanggan.menu') }}" class="block text-center text-amber-700 mb-3">+ Tambah menu lain</a>
                <button onclick="lanjutCheckout()" class="w-full bg-amber-800 text-white rounded-lg py-3 font-semibold hover:bg-amber-900">
                    Lanjut ke Checkout
                </button>
            </div>
        </div>
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
                list.innerHTML = '<div class="bg-white rounded-xl p-10 text-center text-gray-400">Keranjang masih kosong.</div>';
            } else {
                list.innerHTML = cart.map((item, i) => {
                    total += item.harga * item.jumlah;
                    return `
                        <div class="bg-white rounded-xl shadow-sm p-4 flex justify-between items-center">
                            <div>
                                <p class="font-semibold">${item.nama}</p>
                                <p class="text-sm text-gray-500">Rp ${item.harga.toLocaleString('id-ID')}</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <button onclick="ubahJumlah(${i}, -1)" class="bg-gray-200 w-8 h-8 rounded">-</button>
                                <span>${item.jumlah}</span>
                                <button onclick="ubahJumlah(${i}, 1)" class="bg-gray-200 w-8 h-8 rounded">+</button>
                            </div>
                        </div>
                    `;
                }).join('');
            }

            document.getElementById('cart-total').innerText = 'Rp ' + total.toLocaleString('id-ID');
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