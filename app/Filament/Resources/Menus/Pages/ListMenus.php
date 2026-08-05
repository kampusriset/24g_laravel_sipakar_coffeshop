<?php

namespace App\Filament\Resources\Menus\Pages;

use App\Filament\Resources\Menus\MenuResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMenus extends ListRecords
{
    protected static string $resource = MenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),

            Action::make('unduhExcel')
                ->label('Unduh Excel')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->url(route('report.menu.excel'))
                ->openUrlInNewTab(),

            Action::make('unduhPdf')
                ->label('Unduh PDF')
                ->icon('heroicon-o-document-arrow-down')
                ->color('danger')
                ->url(route('report.menu.pdf'))
                ->openUrlInNewTab(),
        ];
    }
}