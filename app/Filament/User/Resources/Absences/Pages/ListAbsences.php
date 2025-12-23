<?php

namespace App\Filament\User\Resources\Absences\Pages;

use App\Filament\User\Resources\Absences\AbsencesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAbsences extends ListRecords
{
    protected static string $resource = AbsencesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
