<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Hasil Rekomendasi - A Coffee</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    
    <body class="bg-orange-50 min-h-screen">
        <div class="flex min-h-screen">

            @include('pelanggan.partials.sidebar')

            <div class="flex-1 ml-64 p-8">

                <div class="max-w-3xl mx-auto">

                    <div class="text-center mb-8">
                        <p class="text-4xl mb-2">🎉</p>
                        <h1 class="text-2xl font-bold">Halo, {{ $pelanggan->nama }}!</h1>
                        <p class="text-gray-500 text-sm mt-1">Ini rekomendasi minuman terbaik untukmu hari ini.</p>
                    </div>

                    <div class="space-y-4 mb-8">
                        @forelse($rekomendasi as $item)
                            <div class="bg-white rounded-xl shadow-sm p-5 flex items-center gap-4 {{ $item['ranking'] === 1 ? 'ring-2 ring-amber-600' : '' }}">

                                @if($item['menu']->gambar)
                                    <img src="{{ asset('storage/' . $item['menu']->gambar) }}" class="w-20 h-20 object-cover rounded-lg shrink-0">
                                @else
                                    <div class="w-20 h-20 bg-amber-50 rounded-lg flex items-center justify-center text-3xl shrink-0">☕</div>
                                @endif

                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        @if($item['ranking'] === 1)
                                            <span class="text-xs font-bold bg-amber-100 text-amber-800 px-2 py-0.5 rounded-full">⭐ Paling Cocok</span>
                                        @else
                                            <span class="text-xs font-semibold text-gray-400">#{{ $item['ranking'] }}</span>
                                        @endif
                                    </div>
                                    <p class="font-semibold">{{ $item['menu']->nama }}</p>
                                    
                                    <p class="text-amber-700 font-bold text-sm">Rp {{ number_format($item['menu']->harga, 0, ',', '.') }}</p>
                                </div>

                                <div class="text-center shrink-0">
                                    <p class="text-xl font-bold text-amber-700">{{ $item['persentase'] }}%</p>

                                    <p class="text-xs text-gray-400 mb-2">kecocokan</p>

                                    <button onclick="tambahKeranjang({{ $item['menu']->id }}, '{{ $item['menu']->nama }}', {{ $item['menu']->harga }}); this.innerText='✔ Ditambahkan'; this.disabled=true; this.classList.add('bg-green-600');"
                                        class="bg-amber-800 text-white text-xs font-semibold px-3 py-2 rounded-lg hover:bg-amber-900">
                                        + Keranjang
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="bg-white rounded-xl shadow-sm p-10 text-center text-gray-400">
                                Belum ada rekomendasi yang cocok, coba jawaban lain.
                            </div>
                        @endforelse
                    </div>

                    <div class="flex gap-3 justify-center">
                        <a href="{{ route('ai-barista.index') }}" class="border border-amber-700 text-amber-700 font-semibold px-5 py-2.5 rounded-lg hover:bg-amber-50">
                            ↺ Coba Lagi
                        </a>

                        <a href="{{ route('pelanggan.keranjang') }}" class="bg-amber-800 text-white font-semibold px-5 py-2.5 rounded-lg hover:bg-amber-900">
                            Lihat Keranjang →
                        </a>
                    </div>

                </div>
            </div>
        </div>

        <script>
            function tambahKeranjang(menuId, nama, harga) {
                let cart = JSON.parse(localStorage.getItem('cart') || '[]');
                let existing = cart.find(item => item.menu_id === menuId);

                if (existing) {
                    existing.jumlah += 1;
                } else {
                    cart.push({ menu_id: menuId, nama: nama, harga: harga, jumlah: 1 });
                }

                localStorage.setItem('cart', JSON.stringify(cart));
            }
        </script>
    </body>
</html>