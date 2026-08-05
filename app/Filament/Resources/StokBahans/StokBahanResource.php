<?php

namespace App\Filament\Resources\StokBahans;

use App\Filament\Resources\StokBahans\Pages;
use App\Models\StokBahan;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use UnitEnum;

class StokBahanResource extends Resource
{
    protected static ?string $model = StokBahan::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $recordTitleAttribute = 'nama';
    protected static string|UnitEnum|null $navigationGroup = 'Inventori';
    protected static ?string $modelLabel = 'Stok Bahan';
    protected static ?string $pluralModelLabel = 'Stok Bahan';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('jumlah')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('satuan')
                    ->required()
                    ->maxLength(20)
                    ->placeholder('Kg, Liter, Pcs, dll'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')->searchable(),
                Tables\Columns\TextColumn::make('jumlah')->sortable(),
                Tables\Columns\TextColumn::make('satuan'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStokBahans::route('/'),
            'create' => Pages\CreateStokBahan::route('/create'),
            'edit' => Pages\EditStokBahan::route('/{record}/edit'),
        ];
    }
}