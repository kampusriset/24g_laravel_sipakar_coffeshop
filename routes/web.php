<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

use App\Http\Controllers\ReportController;

Route::get('/report/menu/excel', [ReportController::class, 'menuExcel'])->name('report.menu.excel');
Route::get('/report/menu/pdf', [ReportController::class, 'menuPdf'])->name('report.menu.pdf');
Route::get('/report/transaksi/excel', [ReportController::class, 'transaksiExcel'])->name('report.transaksi.excel');
Route::get('/report/transaksi/pdf', [ReportController::class, 'transaksiPdf'])->name('report.transaksi.pdf');

use App\Http\Controllers\AiBaristaController;
Route::get('/ai-barista', [AiBaristaController::class, 'index'])->name('ai-barista.index');
Route::post('/ai-barista/proses', [AiBaristaController::class, 'proses'])->name('ai-barista.proses');