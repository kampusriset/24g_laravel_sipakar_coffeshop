<?php

namespace App\Filament\Resources\Menus;

use App\Filament\Resources\Menus\Pages;
use App\Models\Menu;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use UnitEnum;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $recordTitleAttribute = 'nama';
    protected static string|UnitEnum|null $navigationGroup = 'Manajemen Menu';
    protected static ?string $modelLabel = 'Menu';
    protected static ?string $pluralModelLabel = 'Menu';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Select::make('kategori_menu_id')
                    ->relationship('kategoriMenu', 'nama')
                    ->label('Kategori')
                    ->required()
                    ->searchable(),
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('deskripsi')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('harga')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                Forms\Components\FileUpload::make('gambar')
                    ->image()
                    ->directory('menu')
                    ->imageEditor(),
                Forms\Components\Toggle::make('status')
                    ->label('Tersedia')
                    ->default(true),
                Repeater::make('bahanUsage')
                    ->relationship()
                    ->label('Resep / Bahan yang Dipakai')
                    ->schema([
                        Forms\Components\Select::make('stok_bahan_id')
                            ->relationship('stokBahan', 'nama')
                            ->label('Bahan')
                            ->required()
                            ->searchable(),
                        Forms\Components\TextInput::make('jumlah_pakai')
                            ->label('Jumlah Dipakai per 1 Porsi')
                            ->numeric()
                            ->step(0.01)
                            ->required(),
                    ])
                    ->columns(2)
                    ->columnSpanFull()
                    ->addActionLabel('+ Tambah Bahan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('gambar'),
                Tables\Columns\TextColumn::make('nama')->searchable(),
                Tables\Columns\TextColumn::make('kategoriMenu.nama')->label('Kategori'),
                Tables\Columns\TextColumn::make('harga')->money('IDR'),
                Tables\Columns\IconColumn::make('status')->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori_menu_id')
                    ->relationship('kategoriMenu', 'nama')
                    ->label('Kategori'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}