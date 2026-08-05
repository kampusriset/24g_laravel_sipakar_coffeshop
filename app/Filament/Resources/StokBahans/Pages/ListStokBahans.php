<?php

namespace App\Filament\Resources\StokBahans\Pages;

use App\Filament\Resources\StokBahans\StokBahanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStokBahans extends ListRecords
{
    protected static string $resource = StokBahanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
