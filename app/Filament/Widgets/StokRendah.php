<?php

namespace App\Filament\Widgets;

use App\Models\StokBahan;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class StokRendah extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Stok Bahan Rendah')
            ->query(
                StokBahan::query()->where('jumlah', '<=', 5)->orderBy('jumlah')
            )
            ->columns([
                Tables\Columns\TextColumn::make('nama')->label('Bahan'),
                Tables\Columns\TextColumn::make('jumlah')->label('Sisa Stok'),
                Tables\Columns\TextColumn::make('satuan'),
                Tables\Columns\TextColumn::make('jumlah')
                    ->label('Status')
                    ->badge()
                    ->color('danger')
                    ->formatStateUsing(fn () => 'Rendah'),
            ]);
    }
}