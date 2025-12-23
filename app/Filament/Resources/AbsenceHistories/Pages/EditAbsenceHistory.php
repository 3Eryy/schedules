<?php

namespace App\Filament\Resources\AbsenceHistories\Pages;

use App\Filament\Resources\AbsenceHistories\AbsenceHistoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAbsenceHistory extends EditRecord
{
    protected static string $resource = AbsenceHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
