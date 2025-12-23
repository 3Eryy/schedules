<?php

namespace App\Filament\Resources\JournalHistories\Pages;

use App\Filament\Resources\JournalHistories\JournalHistoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditJournalHistory extends EditRecord
{
    protected static string $resource = JournalHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
