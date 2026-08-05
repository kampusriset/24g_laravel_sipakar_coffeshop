<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class LaporanTransaksi extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentChartBar;
    protected static ?string $navigationLabel = 'Laporan Transaksi';
    protected static ?string $title = 'Laporan Transaksi';
    protected static string|UnitEnum|null $navigationGroup = 'Laporan';
    protected string $view = 'filament.pages.laporan-transaksi';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('dari')
                    ->label('Dari Tanggal')
                    ->native(false),
                DatePicker::make('sampai')
                    ->label('Sampai Tanggal')
                    ->native(false),
            ])
            ->statePath('data')
            ->columns(2);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('unduhExcel')
                ->label('Unduh Excel')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->url(fn () => route('report.transaksi.excel', array_filter($this->form->getState())))
                ->openUrlInNewTab(),
            Action::make('unduhPdf')
                ->label('Unduh PDF')
                ->icon('heroicon-o-document-arrow-down')
                ->color('danger')
                ->url(fn () => route('report.transaksi.pdf', array_filter($this->form->getState())))
                ->openUrlInNewTab(),
        ];
    }
}