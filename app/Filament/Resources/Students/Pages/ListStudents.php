<?php

namespace App\Filament\Resources\Students\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Pages\ListRecords;
use App\Imports\StudentsImport;
use App\Filament\Resources\Students\StudentResource;
use Filament\Actions\CreateAction;

class ListStudents extends ListRecords
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Actions\Action::make('import')
                ->label('Import Siswa')
                ->icon('heroicon-o-arrow-up-tray')
                ->form([
                    FileUpload::make('file')
                        ->label('File Excel / CSV')
                        ->disk('local') // PENTING
                        ->directory('imports') // storage/app/imports
                        ->acceptedFileTypes([
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'text/csv',
                        ])
                        ->required(),
                ])
                ->action(function (array $data) {

                    // Ambil path file yang BENAR
                    $filePath = Storage::disk('local')->path($data['file']);

                    Excel::import(
                        new StudentsImport,
                        $filePath
                    );
                })
                ->successNotificationTitle('Import siswa berhasil'),
        ];
    }
}
