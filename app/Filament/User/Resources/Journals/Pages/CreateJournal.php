<?php

namespace App\Filament\User\Resources\Journals\Pages;

use App\Filament\User\Resources\Journals\JournalResource;
use Filament\Resources\Pages\CreateRecord;

class CreateJournal extends CreateRecord
{
    protected static string $resource = JournalResource::class;
}
