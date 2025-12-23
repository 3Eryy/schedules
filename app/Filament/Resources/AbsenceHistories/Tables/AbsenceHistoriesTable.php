<?php

namespace App\Filament\Resources\AbsenceHistories\Tables;

use Filament\Tables\Table;
use Filament\Actions\ViewAction;
use Filament\Tables\Filters\Filter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Filament\Infolists\Components\TextEntry;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;


class AbsenceHistoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('schedule.kelas.full_class')->label('Kelas')->sortable(),
                TextColumn::make('schedule.subject.name')->label('Mapel')->sortable(),
                TextColumn::make('date')
                    ->label('Hari')
                    ->date('Y-m-d')
                    ->sortable(),

                TextColumn::make('hadir_count')
                    ->sortable()
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
                    ->sortable()
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
                    ->sortable()
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
                    ->sortable()
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
            ->filters([
                Filter::make('date')
                    ->form([
                        DatePicker::make('from')->label('Dari Tanggal'),
                        DatePicker::make('until')->label('Sampai Tanggal'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['from'],
                                fn($q) => $q->whereDate('date', '>=', $data['from'])
                            )
                            ->when(
                                $data['until'],
                                fn($q) => $q->whereDate('date', '<=', $data['until'])
                            );
                    }),

                SelectFilter::make('subject')
                    ->label('Mata Pelajaran')
                    ->relationship(
                        'schedule.subject',
                        'name'
                    ),
                SelectFilter::make('guru')
                    ->label('Guru')
                    ->relationship(
                        'schedule.user',
                        'name'
                    )
            ])
            ->recordActions([
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
                                        TextEntry::make('schedule.user.name')
                                            ->label('Nama Guru'),
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
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    FilamentExportBulkAction::make('export')->defaultFormat('pdf'),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
