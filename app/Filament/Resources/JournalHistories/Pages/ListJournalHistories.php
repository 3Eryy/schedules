<?php

namespace App\Filament\Resources\JournalHistories\Pages;

use App\Filament\Resources\JournalHistories\JournalHistoryResource;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekapJurnalPerGuruExport;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Actions\Action;


class ListJournalHistories extends ListRecords
{
    protected static string $resource = JournalHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('exportRekapJurnal')
                ->label('Export Rekap Jurnal')
                ->icon('heroicon-o-arrow-down-tray')
                ->form([
                    Select::make('user_id')
                        ->label('Guru')
                        ->options(
                            \App\Models\User::where('role', 'user')
                                ->pluck('name', 'id')
                        )
                        ->searchable()
                        ->required(),

                    DatePicker::make('bulan')
                        ->label('Bulan')
                        ->native(false)
                        ->displayFormat('F Y') // Januari 2025
                        ->format('Y-m')        // 2025-01 (buat backend)
                        ->closeOnDateSelection()
                        ->required(),
                ])
                ->action(function (array $data) {
                    return Excel::download(
                        new RekapJurnalPerGuruExport(
                            $data['user_id'],
                            $data['bulan']
                        ),
                        'rekap-jurnal.xlsx'
                    );
                }),
        ];
    }
}
