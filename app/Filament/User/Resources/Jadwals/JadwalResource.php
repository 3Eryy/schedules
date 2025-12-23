<?php

namespace App\Filament\User\Resources\Jadwals;

use BackedEnum;
use UnitEnum;
use App\Models\Schedule;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use App\Filament\Forms\JournalForm;
use App\Filament\User\Resources\Jadwals\Pages\EditJadwal;
use App\Filament\User\Resources\Jadwals\Pages\ListJadwals;
use App\Filament\User\Resources\Jadwals\Pages\CreateJadwal;
use App\Filament\User\Resources\Jadwals\Tables\JadwalsTable;

class JadwalResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-book-open';

    protected static UnitEnum|string|null $navigationGroup = 'Show';

    protected static ?string $recordTitleAttribute = 'Jadwal';

    public static function form(Schema $schema): Schema
    {
        return JournalForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JadwalsTable::configure($table);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListJadwals::route('/'),
            // 'create' => CreateJadwal::route('/create'),
            // 'edit' => EditJadwal::route('/{record}/edit'),
        ];
    }
}
