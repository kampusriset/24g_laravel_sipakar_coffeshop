<?php

namespace App\Filament\Resources\KategoriMenus\Pages;

use App\Filament\Resources\KategoriMenus\KategoriMenuResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKategoriMenus extends ListRecords
{
    protected static string $resource = KategoriMenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
