<?php

namespace App\Filament\Widgets;

use App\Models\Menu;
use App\Models\Transaksi;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $hariIni = now()->toDateString();
        $transaksiHariIni = Transaksi::whereDate('created_at', $hariIni)->get();

        return [
            Stat::make('Total Pendapatan Hari Ini', 'Rp ' . number_format($transaksiHariIni->sum('total_harga'), 0, ',', '.'))
                ->description('Dari ' . $transaksiHariIni->count() . ' transaksi')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Total Transaksi Hari Ini', $transaksiHariIni->count())
                ->description('Transaksi masuk hari ini')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('info'),
            Stat::make('Total Menu', Menu::count())
                ->description(Menu::where('status', true)->count() . ' menu aktif')
                ->descriptionIcon('heroicon-m-cake')
                ->color('warning'),
            Stat::make('Total Pegawai', User::where('role', 'pegawai')->count())
                ->description('Pegawai terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('gray'),
        ];
    }
}