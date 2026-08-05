<?php

namespace App\Filament\Resources\StokBahans\Pages;

use App\Filament\Resources\StokBahans\StokBahanResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStokBahan extends EditRecord
{
    protected static string $resource = StokBahanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
