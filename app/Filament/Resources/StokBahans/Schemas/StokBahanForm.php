<?php

namespace App\Filament\Resources\StokBahans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StokBahanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required(),
                TextInput::make('jumlah')
                    ->required()
                    ->numeric(),
                TextInput::make('satuan')
                    ->required(),
            ]);
    }
}
