<?php

namespace App\Filament\User\Resources\Jadwals\Pages;

use App\Filament\User\Resources\Jadwals\JadwalResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListJadwals extends ListRecords
{
    protected static string $resource = JadwalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
