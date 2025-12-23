<?php

namespace App\Filament\Resources\AbsenceHistories;

use UnitEnum;
use BackedEnum;
use App\Models\Absence;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Columns\TextColumn;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Resources\AbsenceHistories\Pages\EditAbsenceHistory;
use App\Filament\Resources\AbsenceHistories\Pages\CreateAbsenceHistory;
use App\Filament\Resources\AbsenceHistories\Pages\ListAbsenceHistories;
use App\Filament\Resources\AbsenceHistories\Schemas\AbsenceHistoryForm;
use App\Filament\Resources\AbsenceHistories\Tables\AbsenceHistoriesTable;

class AbsenceHistoryResource extends Resource
{
    protected static ?string $model = Absence::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-presentation-chart-line';

    protected static UnitEnum|string|null $navigationGroup = 'Histories';

    protected static ?string $recordTitleAttribute = 'absence_history';

    public static function getEloquentQuery(): Builder
    {
        $subquery = Absence::query()
            ->select([
                DB::raw('MIN(id) as min_id'),
                'schedule_id',
                'date',
            ])
            ->groupBy('schedule_id', 'date');

        return Absence::query()
            ->select([
                'absences.id',
                'absences.schedule_id',
                'absences.date',
                DB::raw("SUM(status = 'hadir') as hadir_count"),
                DB::raw("SUM(status = 'izin') as izin_count"),
                DB::raw("SUM(status = 'sakit') as sakit_count"),
                DB::raw("SUM(status = 'alpha') as alpha_count"),
            ])
            ->joinSub($subquery, 'grouped_absences', function ($join) {
                $join->on('absences.id', '=', 'grouped_absences.min_id');
            })
            ->groupBy('absences.id', 'absences.schedule_id', 'absences.date')
            ->orderBy('absences.date', 'desc')
            ->orderBy('absences.id', 'asc');
    }

    public static function form(Schema $schema): Schema
    {
        return AbsenceHistoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AbsenceHistoriesTable::configure($table);
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
            'index' => ListAbsenceHistories::route('/'),
            'create' => CreateAbsenceHistory::route('/create'),
            'edit' => EditAbsenceHistory::route('/{record}/edit'),
        ];
    }
}
