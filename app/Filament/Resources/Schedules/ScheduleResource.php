<?php

namespace App\Filament\Resources\Schedules;

use BackedEnum;
use UnitEnum;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Subjects;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use App\Filament\Resources\Schedules\Pages\EditSchedule;
use App\Filament\Resources\Schedules\Pages\ListSchedules;
use App\Filament\Resources\Schedules\Pages\CreateSchedule;
use App\Filament\Resources\Schedules\Tables\SchedulesTable;

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';

    protected static UnitEnum|string|null $navigationGroup = 'Universal';

    protected static ?string $recordTitleAttribute = 'Schedule';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('kelas_id')
                    ->label('Nama Kelas')
                    ->options(
                        \App\Models\Kelas::with('majors')     // supaya majors bisa dipakai di accessor
                            ->get()
                            ->pluck('full_class', 'id')       // gunakan accessor
                    )
                    ->searchable()
                    ->preload()
                    ->required(),

                 Select::make('user_id')
                    ->label('Nama Guru')
                    ->options(
                        User::orderBy('name')->pluck('name', 'id')
                    )
                    ->searchable()
                    ->preload()
                    ->required(),

                // Subject
                Select::make('subject_id')
                    ->label('Mata Pelajaran')
                    ->options(
                Subjects::orderBy('name')->pluck('name', 'id')
                    )
                    ->searchable()
                    ->preload()
                    ->required(),

                DatePicker::make('date')
                    ->label('Tanggal')
                    ->required(),

                TimePicker::make('start_time')
                    ->label('Jam Mulai')
                    ->required(),

                TimePicker::make('end_time')
                    ->label('Jam Selesai')
                    ->required(),

                Select::make('status')
                    ->label('Status jadwal')
                    ->options([
                        'Terjadwal' => 'terjadwal',
                        'Terlaksana' => 'terlaksana'
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return SchedulesTable::configure($table);
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
            'index' => ListSchedules::route('/'),
            'create' => CreateSchedule::route('/create'),
            'edit' => EditSchedule::route('/{record}/edit'),
        ];
    }
}
