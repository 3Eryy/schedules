<?php

namespace App\Filament\User\Resources\Absences;

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
use App\Filament\User\Resources\Absences\Pages\EditAbsences;
use App\Filament\User\Resources\Absences\Pages\ListAbsences;
use App\Filament\User\Resources\Absences\Pages\CreateAbsences;
use App\Filament\User\Resources\Absences\Schemas\AbsencesForm;

class AbsencesResource extends Resource
{
    protected static ?string $model = Absence::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-presentation-chart-line';

    protected static UnitEnum|string|null $navigationGroup = 'Form';

    protected static ?string $recordTitleAttribute = 'Absences';

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
            ->whereHas(
                'schedule',
                fn($q) => $q->where('user_id', auth()->id())
            )
            ->groupBy('absences.id', 'absences.schedule_id', 'absences.date')
            ->orderBy('absences.date', 'desc')
            ->orderBy('absences.id', 'asc');
    }

    public static function form(Schema $schema): Schema
    {
        return AbsencesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('schedule.kelas.full_class')->label('Kelas'),
                TextColumn::make('schedule.subject.name')->label('Mapel'),
                TextColumn::make('date')
                    ->label('Hari')
                    ->date('Y-m-d')
                    ->sortable(),

                TextColumn::make('hadir_count')
                    ->label('Hadir')
                    ->state(
                        fn($record) =>
                        $record->schedule
                            ->absence()
                            ->where('date', $record->date)
                            ->where('status', 'hadir')
                            ->count()
                    ),

                TextColumn::make('sakit_count')
                    ->label('Sakit')
                    ->state(
                        fn($record) =>
                        $record->schedule
                            ->absence()
                            ->where('date', $record->date)
                            ->where('status', 'sakit')
                            ->count()
                    ),

                TextColumn::make('izin_count')
                    ->label('Izin')
                    ->state(
                        fn($record) =>
                        $record->schedule
                            ->absence()
                            ->where('date', $record->date)
                            ->where('status', 'izin')
                            ->count()
                    ),

                TextColumn::make('alpha_count')
                    ->label('Alpha')
                    ->state(
                        fn($record) =>
                        $record->schedule
                            ->absence()
                            ->where('date', $record->date)
                            ->where('status', 'alpha')
                            ->count()
                    ),
            ])
            ->actions([
                ViewAction::make()
                    ->label('Detail')
                    ->infolist(function ($infolist) {
                        return $infolist
                            ->schema([
                                Section::make('Detail Absensi')
                                    ->schema([
                                        TextEntry::make('hadir_list')
                                            ->label('Hadir')
                                            ->state(
                                                fn($record) =>
                                                $record->schedule
                                                    ->absence()
                                                    ->where('date', $record->date)
                                                    ->where('status', 'hadir')
                                                    ->with('student')
                                                    ->get()
                                                    ->pluck('student.name')
                                                    ->join(', ')
                                            ),

                                        TextEntry::make('sakit_list')
                                            ->label('Sakit')
                                            ->state(
                                                fn($record) =>
                                                $record->schedule
                                                    ->absence()
                                                    ->where('date', $record->date)
                                                    ->where('status', 'sakit')
                                                    ->with('student')
                                                    ->get()
                                                    ->pluck('student.name')
                                                    ->join(', ')
                                            ),

                                        TextEntry::make('izin_list')
                                            ->label('Izin')
                                            ->state(
                                                fn($record) =>
                                                $record->schedule
                                                    ->absence()
                                                    ->where('date', $record->date)
                                                    ->where('status', 'izin')
                                                    ->with('student')
                                                    ->get()
                                                    ->pluck('student.name')
                                                    ->join(', ')
                                            ),

                                        TextEntry::make('alpha_list')
                                            ->label('Alpha')
                                            ->state(
                                                fn($record) =>
                                                $record->schedule
                                                    ->absence()
                                                    ->where('date', $record->date)
                                                    ->where('status', 'alpha')
                                                    ->with('student')
                                                    ->get()
                                                    ->pluck('student.name')
                                                    ->join(', ')
                                            ),
                                    ]),

                                Section::make('Detail Jadwal')
                                    ->schema([
                                        TextEntry::make('schedule.kelas.full_class')
                                            ->label('Kelas'),
                                        TextEntry::make('schedule.subject.name')
                                            ->label('Mata Pelajaran'),
                                        TextEntry::make('schedule.date')->date('Y-m-d')
                                            ->label('Hari'),
                                        TextEntry::make('schedule.start_time')->time()
                                            ->label('Waktu'),
                                        TextEntry::make('schedule.end_time')->time()
                                            ->label('Waktu'),
                                    ]),
                            ]);
                    })
            ]);
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
            'index' => ListAbsences::route('/'),
            'create' => CreateAbsences::route('/create'),
            'edit' => EditAbsences::route('/{record}/edit'),
        ];
    }
}
