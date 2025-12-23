<?php

namespace App\Filament\User\Resources\Absences\Pages;

use App\Filament\User\Resources\Absences\AbsencesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAbsences extends EditRecord
{
    protected static string $resource = AbsencesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
