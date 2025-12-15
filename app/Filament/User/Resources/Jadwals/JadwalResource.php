<?php

namespace App\Filament\User\Resources\Jadwals;

use App\Filament\User\Resources\Jadwals\Pages\CreateJadwal;
use App\Filament\User\Resources\Jadwals\Pages\EditJadwal;
use App\Filament\User\Resources\Jadwals\Pages\ListJadwals;
use App\Filament\User\Resources\Jadwals\Schemas\JadwalForm;
use App\Filament\User\Resources\Jadwals\Tables\JadwalsTable;
use App\Models\Schedule;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class JadwalResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $recordTitleAttribute = 'Jadwal';

    public static function form(Schema $schema): Schema
    {
        return JadwalForm::configure($schema);
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
            'edit' => EditJadwal::route('/{record}/edit'),
        ];
    }
}
