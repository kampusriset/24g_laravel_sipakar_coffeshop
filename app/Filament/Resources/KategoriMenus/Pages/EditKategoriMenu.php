<?php

namespace App\Filament\Resources\KategoriMenus\Pages;

use App\Filament\Resources\KategoriMenus\KategoriMenuResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKategoriMenu extends EditRecord
{
    protected static string $resource = KategoriMenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
