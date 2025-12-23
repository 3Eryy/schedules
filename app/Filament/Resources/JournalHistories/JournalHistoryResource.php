<?php

namespace App\Filament\Resources\JournalHistories;

use App\Filament\Resources\JournalHistories\Pages\CreateJournalHistory;
use App\Filament\Resources\JournalHistories\Pages\EditJournalHistory;
use App\Filament\Resources\JournalHistories\Pages\ListJournalHistories;
use App\Filament\Resources\JournalHistories\Schemas\JournalHistoryForm;
use App\Filament\Resources\JournalHistories\Tables\JournalHistoriesTable;
use App\Models\Journal;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class JournalHistoryResource extends Resource
{
    protected static ?string $model = Journal::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static UnitEnum|string|null $navigationGroup = 'Histories';

    protected static ?string $recordTitleAttribute = 'Journal History';

    public static function form(Schema $schema): Schema
    {
        return JournalHistoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JournalHistoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListJournalHistories::route('/'),
            'create' => CreateJournalHistory::route('/create'),
            'edit' => EditJournalHistory::route('/{record}/edit'),
        ];
    }
}
