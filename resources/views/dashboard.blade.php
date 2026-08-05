<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard Pegawai</title>
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

                <div class="my-6 border-t border-gray-200"></div>

            

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

            {{-- Top bar --}}
            <div class="bg-white border-b px-8 py-4 flex justify-between items-center">
                <h1 class="font-semibold text-lg">Dashboard Pegawai</h1>
                <div class="flex items-center gap-3">
                    <span class="text-2xl">🔔</span>
                    <div class="text-right">
                        <p class="text-sm font-semibold">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-400">{{ ucfirst(Auth::user()->role) }}</p>
                    </div>
                </div>
            </div>

            <div class="p-8">

               {{-- HERO HEADER --}}
                <div class="bg-white rounded-[32px] border border-gray-200 shadow-sm p-10 mb-8">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-xs uppercase tracking-[0.35em] text-orange-500 font-bold">
                                DASHBOARD
                            </p>

                            <h1 class="mt-3 text-5xl font-bold text-gray-900">
                                Dashboard Pegawai
                            </h1>

                            <p class="mt-5 max-w-2xl text-lg text-gray-500 leading-8">
                                Selamat datang kembali,

                                <span class="font-semibold text-gray-900">
                                    {{ Auth::user()->name }}
                                </span>.

                                Kelola pesanan pelanggan, pantau transaksi,
                                stok bahan, dan aktivitas coffee shop secara real-time.
                            </p>

                        </div>

                        <a href="{{ route('pesanan.baru') }}"
                        class="rounded-full border border-orange-500 px-7 py-3 font-medium text-orange-500 transition hover:bg-orange-500 hover:text-white">

                            + Input Pesanan Baru

                        </a>

                    </div>

                </div>
                @if(session('success'))
                    <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Stat Cards --}}
                <div class="grid grid-cols-4 gap-5 mb-8">
                    <div class="bg-white rounded-xl shadow-sm p-5">
                        <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center mb-3 text-lg">🛍️</div>
                        <p class="text-2xl font-bold">{{ $totalTransaksiHariIni }}</p>
                        <p class="text-sm text-gray-500">Transaksi Hari Ini</p>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm p-5">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mb-3 text-lg">💰</div>
                        <p class="text-2xl font-bold">Rp {{ number_format($totalPenjualanHariIni, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-500">Penjualan Hari Ini</p>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm p-5">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mb-3 text-lg">☕</div>
                        <p class="text-2xl font-bold">{{ $totalMenuTerjualHariIni }}</p>
                        <p class="text-sm text-gray-500">Porsi Terjual Hari Ini</p>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm p-5">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mb-3 text-lg">✅</div>
                        <p class="text-2xl font-bold">{{ $selesaiHariIni }}</p>
                        <p class="text-sm text-gray-500">Pesanan Selesai Hari Ini</p>
                    </div>
                </div>

                {{-- Pesanan Aktif --}}
                <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8">
                    <div class="px-6 py-4 border-b flex justify-between items-center">
                        <h3 class="font-semibold">Pesanan Aktif</h3>
                        <a href="{{ route('pesanan.baru') }}"
                            class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold px-5 py-3 rounded-xl transition duration-200 shadow-sm hover:shadow-md">
                                + Input Pesanan Baru
                        </a>
                    </div>

                    <div class="divide-y">
                        @forelse($transaksiAktif as $t)

                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">

                                <div class="bg-white border rounded-2xl shadow-sm hover:shadow-lg transition p-5">

                                    {{-- Header --}}
                                    <div class="flex items-center justify-between mb-4">

                                        <span class="text-sm font-bold text-gray-400">
                                            #{{ str_pad($t->id,4,'0',STR_PAD_LEFT) }}
                                        </span>

                                        @if($t->status=='menunggu')
                                            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">
                                                 Menunggu
                                            </span>
                                        @elseif($t->status=='diproses')
                                            <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">
                                                 Diproses
                                            </span>
                                        @elseif($t->status=='siap_diambil')
                                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                                 Siap Diambil
                                            </span>
                                        @endif

                                    </div>

                                    {{-- Nama --}}
                                    <h3 class="text-2xl font-bold text-gray-900">
                                        {{ $t->pelanggan->nama }}
                                    </h3>

                                    {{-- Waktu --}}
                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ $t->created_at->format('d M Y • H:i') }}
                                    </p>

                                    <p class="text-sm text-gray-500">
                                         {{ strtoupper($t->pembayaran->metode ?? '-') }}
                                    </p>

                                    {{-- Menu --}}
                                    <div class="mt-4 space-y-2">

                                        @foreach($t->detailTransaksi as $d)

                                            <div class="flex justify-between bg-orange-50 rounded-lg px-3 py-2">

                                                <span>
                                                     {{ $d->menu->nama }}
                                                </span>

                                                <span class="font-semibold">
                                                    ×{{ $d->jumlah }}
                                                </span>

                                            </div>

                                        @endforeach

                                    </div>

                                    {{-- Harga --}}
                                    <div class="mt-5">

                                        <p class="text-2xl font-bold text-gray-900">
                                            Rp {{ number_format($t->total_harga,0,',','.') }}
                                        </p>

                                    </div>

                                    {{-- Tombol --}}
                                    <div class="mt-5">

                                        @if($t->status=='menunggu')

                                            <form action="{{ route('pesanan.status',$t->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="diproses">

                                                <button class="w-full bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-xl font-semibold transition">
                                                     Proses
                                                </button>

                                            </form>

                                        @elseif($t->status=='diproses')

                                            <form action="{{ route('pesanan.status',$t->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="siap_diambil">

                                                <button class="w-full bg-emerald-500 hover:bg-emerald-600 text-white py-3 rounded-xl font-semibold transition">
                                                     Siap Diambil
                                                </button>

                                            </form>

                                        @elseif($t->status=='siap_diambil')

                                            <form action="{{ route('pesanan.status',$t->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="selesai">

                                                <button class="w-full bg-slate-700 hover:bg-slate-800 text-white py-3 rounded-xl font-semibold transition">
                                                     Selesai
                                                </button>

                                            </form>

                                        @endif

                                    </div>

                                </div>

                            </div>
                        </div>

                        @empty

                        <div class="p-12 text-center text-gray-400">

                            <div class="text-5xl mb-3">
                                
                            </div>

                            <p>
                                Belum ada pesanan aktif.
                            </p>

                        </div>

                        @endforelse
                    </div>
                </div>

                {{-- Transaksi Terbaru & Stok Rendah --}}
                <div class="grid grid-cols-2 gap-6">
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b">
                            <h3 class="font-semibold">Transaksi Terbaru</h3>
                        </div>
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-gray-400 text-xs">
                                    <th class="text-left px-6 py-2">Pelanggan</th>
                                    <th class="text-left px-6 py-2">Total</th>
                                    <th class="text-left px-6 py-2">Waktu</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @forelse($transaksiTerbaru as $t)
                                    <tr>
                                        <td class="px-6 py-3">{{ $t->pelanggan->nama ?? '-' }}</td>
                                        <td class="px-6 py-3">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                                        <td class="px-6 py-3 text-gray-400">{{ $t->created_at->format('H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center text-gray-400 py-6">Belum ada transaksi.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b">
                            <h3 class="font-semibold">Stok Bahan Rendah</h3>
                        </div>
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-gray-400 text-xs">
                                    <th class="text-left px-6 py-2">Bahan</th>
                                    <th class="text-left px-6 py-2">Sisa</th>
                                    <th class="text-left px-6 py-2">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @forelse($stokRendah as $s)
                                    <tr>
                                        <td class="px-6 py-3">{{ $s->nama }}</td>
                                        <td class="px-6 py-3">{{ $s->jumlah }} {{ $s->satuan }}</td>
                                        <td class="px-6 py-3">
                                            <span class="text-xs font-semibold px-2 py-1 rounded-full bg-red-100 text-red-600">Rendah</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center text-gray-400 py-6">Stok aman semua.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>