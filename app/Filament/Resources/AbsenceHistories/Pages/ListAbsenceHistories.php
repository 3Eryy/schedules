<?php

namespace App\Filament\Resources\AbsenceHistories\Pages;

use App\Filament\Resources\AbsenceHistories\AbsenceHistoryResource;
use Filament\Resources\Pages\ListRecords;

class ListAbsenceHistories extends ListRecords
{
    protected static string $resource = AbsenceHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
