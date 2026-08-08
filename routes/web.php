<?php

use App\Http\Controllers\AiBaristaController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

// Halaman Pelanggan (tanpa login, akses tablet)
Route::get('/', [PelangganController::class, 'beranda'])->name('pelanggan.beranda');
Route::get('/menu', [PelangganController::class, 'menu'])->name('pelanggan.menu');
Route::get('/keranjang', [PelangganController::class, 'keranjang'])->name('pelanggan.keranjang');
Route::get('/checkout', [PelangganController::class, 'checkoutForm'])->name('pelanggan.checkout');
Route::post('/checkout/proses', [PelangganController::class, 'prosesCheckout'])->name('pelanggan.checkout.proses');
Route::get('/selesai/{transaksi}', [PelangganController::class, 'selesai'])->name('pelanggan.selesai');
Route::get('/struk/{transaksi}', [PelangganController::class, 'struk'])->name('pelanggan.struk');

// AI Barista
Route::get('/ai-barista', [AiBaristaController::class, 'index'])->name('ai-barista.index');
Route::post('/ai-barista/proses', [AiBaristaController::class, 'proses'])->name('ai-barista.proses');

// Laporan (dapat diakses admin dari panel Filament)
Route::get('/report/menu/excel', [ReportController::class, 'menuExcel'])->name('report.menu.excel');
Route::get('/report/menu/pdf', [ReportController::class, 'menuPdf'])->name('report.menu.pdf');
Route::get('/report/transaksi/excel', [ReportController::class, 'transaksiExcel'])->name('report.transaksi.excel');
Route::get('/report/transaksi/pdf', [ReportController::class, 'transaksiPdf'])->name('report.transaksi.pdf');

// Halaman Pegawai (wajib login, role pegawai)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [PegawaiController::class, 'dashboard'])->name('dashboard');
    Route::post('/pesanan/{transaksi}/status', [PegawaiController::class, 'updateStatus'])->name('pesanan.status');
    Route::get('/pesanan/baru', [PegawaiController::class, 'pesananBaru'])->name('pesanan.baru');
    Route::post('/pesanan/baru', [PegawaiController::class, 'simpanPesananBaru'])->name('pesanan.baru.simpan');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';