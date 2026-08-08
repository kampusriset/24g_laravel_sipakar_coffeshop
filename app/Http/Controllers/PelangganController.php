<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\KategoriMenu;
use App\Models\Menu;
use App\Models\Pelanggan;
use App\Models\Pembayaran;
use App\Models\Transaksi;
use App\Services\StokService;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    // Halaman utama (beranda)
    public function beranda()
    {
        $kategori = KategoriMenu::where('status', true)->get();
        $menuPopuler = Menu::where('status', true)->latest()->take(4)->get();

        return view('pelanggan.beranda', compact('kategori', 'menuPopuler'));
    }

    // Halaman daftar menu manual (dengan filter kategori & pencarian)
    public function menu(Request $request)
    {
        $kategoriList = KategoriMenu::where('status', true)->get();
        $query = Menu::where('status', true);

        if ($request->filled('kategori_id')) {
            $query->where('kategori_menu_id', $request->kategori_id);
        }

        if ($request->filled('cari')) {
            $query->where('nama', 'like', '%' . $request->cari . '%');
        }

        $menu = $query->with('kategoriMenu')->get();

        return view('pelanggan.menu', compact('kategoriList', 'menu'));
    }

    // Halaman keranjang
    public function keranjang()
    {
        return view('pelanggan.keranjang');
    }

    // Halaman input nama sebelum checkout
    public function checkoutForm()
    {
        return view('pelanggan.checkout');
    }

    // Proses simpan transaksi dari pelanggan (via tablet)
    public function prosesCheckout(Request $request)
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
            'user_id' => null,
            'total_harga' => $totalHarga,
            'status' => 'menunggu',
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
            'status' => 'pending',
            'total_bayar' => $totalHarga,
        ]);

        return redirect()->route('pelanggan.selesai', $transaksi->id);
    }

    // Halaman konfirmasi pesanan berhasil
    public function selesai(Transaksi $transaksi)
    {
        $transaksi->load('detailTransaksi.menu', 'pelanggan', 'pembayaran');

        return view('pelanggan.selesai', compact('transaksi'));
    }

    public function struk(Transaksi $transaksi)
    {
        $transaksi->load('detailTransaksi.menu', 'pelanggan', 'pembayaran');

        return view('pelanggan.struk', compact('transaksi'));
    }

}
