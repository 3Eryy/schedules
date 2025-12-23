<?php

namespace App\Filament\Resources\JournalHistories\Pages;

use App\Filament\Resources\JournalHistories\JournalHistoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListJournalHistories extends ListRecords
{
    protected static string $resource = JournalHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
