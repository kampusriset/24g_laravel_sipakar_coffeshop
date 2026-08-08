<!DOCTYPE html>
<html>
    <head>
        <title>Pesanan Berhasil</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    
    <body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow p-8 w-full max-w-md text-center">
            <div class="text-5xl mb-4">✅</div>
            <h1 class="text-2xl font-bold mb-2">Pesanan Diterima!</h1>
            <p class="text-gray-500 mb-6">Terima kasih, {{ $transaksi->pelanggan->nama }}. Pesananmu sedang diproses.</p>

            <div class="text-left border rounded-lg p-4 mb-6 space-y-2">
                @foreach($transaksi->detailTransaksi as $d)
                    <div class="flex justify-between text-sm">
                        <span>{{ $d->menu->nama }} x{{ $d->jumlah }}</span>
                        <span>Rp {{ number_format($d->subtotal, 0, ',', '.') }}</span>
                    </div>
                @endforeach
                <div class="border-t pt-2 flex justify-between font-bold">
                    <span>Total</span>
                    <span>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                </div>
                <p class="text-sm text-gray-500 pt-2">Metode: {{ ucfirst($transaksi->pembayaran->metode) }}</p>
            </div>

            <a href="{{ route('pelanggan.struk', $transaksi->id) }}" target="_blank"
                class="block bg-white border-2 border-amber-600 text-amber-600 rounded-lg py-3 font-semibold hover:bg-amber-50 mb-3">
                🖨️ Cetak Struk
            </a>

            <a href="{{ route('pelanggan.beranda') }}" class="block bg-amber-600 text-white rounded-lg py-3 font-semibold hover:bg-amber-700">
                Kembali ke Beranda
            </a>
        </div>
    </body>
</html>