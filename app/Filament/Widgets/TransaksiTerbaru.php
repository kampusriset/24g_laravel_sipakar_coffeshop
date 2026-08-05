<?php

namespace App\Filament\Widgets;

use App\Models\Transaksi;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TransaksiTerbaru extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Transaksi Terbaru')
            ->query(
                Transaksi::query()->with('pelanggan')->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('pelanggan.nama')->label('Pelanggan'),
                Tables\Columns\TextColumn::make('total_harga')->label('Total')->money('IDR'),
                Tables\Columns\TextColumn::make('status')->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'menunggu' => 'warning',
                        'diproses' => 'info',
                        'siap_diambil' => 'success',
                        'selesai' => 'gray',
                        default => 'danger',
                    }),
                Tables\Columns\TextColumn::make('created_at')->label('Waktu')->dateTime('d M, H:i'),
            ]);
    }
}