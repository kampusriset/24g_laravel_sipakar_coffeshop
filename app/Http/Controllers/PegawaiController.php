<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\KategoriMenu;
use App\Models\Pelanggan;
use App\Models\Pembayaran;
use App\Models\StokBahan;
use App\Models\Transaksi;
use App\Services\StokService;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function dashboard()
    {
        $hariIni = now()->toDateString();

        $transaksiAktif = Transaksi::with(['pelanggan', 'detailTransaksi.menu', 'pembayaran'])
            ->whereIn('status', ['menunggu', 'diproses', 'siap_diambil'])
            ->orderBy('created_at', 'asc')
            ->get();

        $transaksiHariIni = Transaksi::whereDate('created_at', $hariIni)->get();
        $totalTransaksiHariIni = $transaksiHariIni->count();
        $totalPenjualanHariIni = $transaksiHariIni->sum('total_harga');

        $totalMenuTerjualHariIni = DetailTransaksi::whereHas('transaksi', function ($q) use ($hariIni) {
            $q->whereDate('created_at', $hariIni);
        })->sum('jumlah');

        $selesaiHariIni = $transaksiHariIni->where('status', 'selesai')->count();

        $transaksiTerbaru = Transaksi::with('pelanggan')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $stokRendah = StokBahan::where('jumlah', '<=', 5)
            ->orderBy('jumlah')
            ->get();

        $riwayat = Transaksi::with(['pelanggan', 'pembayaran'])
            ->where('status', 'selesai')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard', compact(
            'transaksiAktif',
            'totalTransaksiHariIni',
            'totalPenjualanHariIni',
            'totalMenuTerjualHariIni',
            'selesaiHariIni',
            'transaksiTerbaru',
            'stokRendah',
            'riwayat'
        ));
    }

    public function updateStatus(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'status' => 'required|in:menunggu,diproses,siap_diambil,selesai,dibatalkan',
        ]);

        $transaksi->update(['status' => $request->status]);

        if ($request->status === 'selesai' && $transaksi->pembayaran) {
            $transaksi->pembayaran->update(['status' => 'lunas']);
        }

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function pesananBaru()
    {
        $kategori = KategoriMenu::where('status', true)->with(['menu' => function ($q) {
            $q->where('status', true);
        }])->get();

        return view('pegawai.pesanan-baru', compact('kategori'));
    }

    public function simpanPesananBaru(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'metode_pembayaran' => 'required|in:tunai,qris',
            'items' => 'required|array|min:1',
        ]);

        $pelanggan = Pelanggan::create([
            'nama' => $request->nama_pelanggan,
        ]);

        $totalHarga = 0;
        foreach ($request->items as $item) {
            $totalHarga += $item['harga'] * $item['jumlah'];
        }

        $transaksi = Transaksi::create([
            'pelanggan_id' => $pelanggan->id,
            'user_id' => auth()->id(),
            'total_harga' => $totalHarga,
            'status' => 'diproses',
        ]);

        foreach ($request->items as $item) {
            DetailTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'menu_id' => $item['menu_id'],
                'jumlah' => $item['jumlah'],
                'harga' => $item['harga'],
                'subtotal' => $item['harga'] * $item['jumlah'],
            ]);
        }

        (new StokService())->kurangiStok($transaksi);

        Pembayaran::create([
            'transaksi_id' => $transaksi->id,
            'metode' => $request->metode_pembayaran,
            'status' => 'lunas',
            'total_bayar' => $totalHarga,
        ]);

        return redirect()->route('dashboard')->with('success', 'Pesanan baru berhasil ditambahkan.');
    }
}
