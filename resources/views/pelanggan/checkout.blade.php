<!DOCTYPE html>
<html>
    <head>
        <title>Checkout</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>

    <body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow p-8 w-full max-w-lg">
            <div class="flex items-center gap-3 mb-6">
                <a href="{{ route('pelanggan.beranda') }}" class="w-9 h-9 flex items-center justify-center rounded-lg border hover:bg-gray-50">←</a>
                <h1 class="text-2xl font-bold">Checkout</h1>
            </div>
            <div id="ringkasan" class="mb-6 space-y-2"></div>

            <div class="border-t pt-4 mb-4 flex justify-between font-bold text-lg">
                <span>Total</span>
                <span id="total-bayar">Rp 0</span>
            </div>

            <form id="checkout-form" method="POST" action="{{ route('pelanggan.checkout.proses') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Nama Anda</label>
                    <input type="text" name="nama_pelanggan" required class="w-full border rounded p-2">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">Metode Pembayaran</label>
                    <div class="grid grid-cols-2 gap-2">
                        <label class="border rounded p-3 text-center cursor-pointer has-[:checked]:bg-amber-100 has-[:checked]:border-amber-600">
                            <input type="radio" name="metode_pembayaran" value="tunai" class="hidden" required> Tunai
                        </label>
                        <label class="border rounded p-3 text-center cursor-pointer has-[:checked]:bg-amber-100 has-[:checked]:border-amber-600">
                            <input type="radio" name="metode_pembayaran" value="qris" class="hidden"> QRIS
                        </label>
                    </div>
                </div>

                <div id="hidden-items"></div>

                <button type="submit" class="w-full bg-amber-600 text-white rounded-lg py-3 font-semibold hover:bg-amber-700">
                    Bayar Sekarang
                </button>
            </form>
        </div>

        <script>
            function getCart() {
                return JSON.parse(localStorage.getItem('cart') || '[]');
            }

            let cart = getCart();
            if (cart.length === 0) {
                window.location.href = "{{ route('pelanggan.menu') }}";
            }

            let total = 0;
            let ringkasan = document.getElementById('ringkasan');
            ringkasan.innerHTML = cart.map(item => {
                total += item.harga * item.jumlah;
                return `<div class="flex justify-between text-sm text-gray-600">
                            <span>${item.nama} x${item.jumlah}</span>
                            <span>Rp ${(item.harga * item.jumlah).toLocaleString('id-ID')}</span>
                        </div>`;
            }).join('');

            document.getElementById('total-bayar').innerText = 'Rp ' + total.toLocaleString('id-ID');

            // Kirim data cart sebagai hidden input array
            let hiddenContainer = document.getElementById('hidden-items');
            cart.forEach((item, i) => {
                hiddenContainer.innerHTML += `
                    <input type="hidden" name="items[${i}][menu_id]" value="${item.menu_id}">
                    <input type="hidden" name="items[${i}][harga]" value="${item.harga}">
                    <input type="hidden" name="items[${i}][jumlah]" value="${item.jumlah}">
                `;
            });

            document.getElementById('checkout-form').addEventListener('submit', function () {
                localStorage.removeItem('cart');
            });
        </script>
    </body>
</html>