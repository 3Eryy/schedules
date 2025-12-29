<?php

namespace App\Filament\Resources\AbsenceHistories\Pages;

use Filament\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\Pages\ListRecords;
use App\Exports\RekapAbsensiPerKelasExport;
use App\Filament\Resources\AbsenceHistories\AbsenceHistoryResource;

class ListAbsenceHistories extends ListRecords
{
    protected static string $resource = AbsenceHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('exportRekap')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->label('Export Rekap Absensi')
                        ->form([
                            Select::make('kelas_id')
                                ->label('Nama Kelas')
                                ->options(
                                    \App\Models\Kelas::with('majors')
                                        ->get()
                                        ->mapWithKeys(fn ($kelas) => [
                                            $kelas->id => $kelas->full_class,
                                        ])
                                        ->toArray()
                                )
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
                                new RekapAbsensiPerKelasExport(
                                    $data['kelas_id'],
                                    $data['bulan']
                                ),
                                'rekap-absensi.xlsx'
                            );
                        }),
        ];
    }
}
