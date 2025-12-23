<?php

namespace App\Filament\Resources\Schedules\Tables;

use App\Models\User;
use App\Models\Subjects;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Schemas\Components\Section;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\Placeholder;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;

class SchedulesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Guru')
                    ->searchable(),

                TextColumn::make('kelas.full_class')
                    ->label('Kelas')
                    ->searchable(['kelas_id.level', 'kelas_id.pararel', 'kelas_id.majors_id']),

                TextColumn::make('subject.name')
                    ->label('Mata Pelajaran')
                    ->searchable(),

                TextColumn::make('date')->searchable(),
                TextColumn::make('start_time')->searchable(),
                TextColumn::make('end_time')->searchable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'terlaksana' => 'success',
                        'terjadwal' => 'warning',
                        default => 'gray',
                    })
                    ->state(function ($record) {
                        // Cek apakah ada data di absences atau journals untuk schedule ini
                        $hasAbsences = $record->absence()->exists();
                        $hasJournals = $record->journal()->exists();

                        return ($hasAbsences && $hasJournals) ? 'terlaksana' : 'terjadwal';
                    }),
            ])
            ->filters([
                SelectFilter::make('kelas_id')
                    ->label('Nama Kelas')
                    ->options(
                        \App\Models\Kelas::with('majors')     // supaya majors bisa dipakai di accessor
                            ->get()
                            ->pluck('full_class', 'id')       // gunakan accessor
                    ),

                SelectFilter::make('user_id')
                    ->label('Nama Guru')
                    ->options(
                        User::orderBy('name')->pluck('name', 'id')
                    ),

                // Subject
                SelectFilter::make('subject_id')
                    ->label('Mata Pelajaran')
                    ->options(
                        Subjects::orderBy('name')->pluck('name', 'id')
                    ),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('Detail')
                    ->icon('heroicon-o-eye')
                    ->modalHeading('Detail Jadwal')
                    ->modalWidth('lg')
                    ->form(fn($record) => [

                        Section::make('Informasi Jadwal')
                            ->schema([
                                Placeholder::make('kelas')
                                    ->label('Kelas')
                                    ->content($record->kelas->full_class),

                                Placeholder::make('mapel')
                                    ->label('Mata Pelajaran')
                                    ->content($record->subject->name),

                                Placeholder::make('tanggal')
                                    ->label('Tanggal')
                                    ->content($record->date),

                                Placeholder::make('waktu')
                                    ->label('Waktu')
                                    ->content($record->start_time . ' - ' . $record->end_time),
                            ])
                            ->columns(2),

                        Section::make('Status Pelaksanaan')
                            ->schema([
                                Placeholder::make('status')
                                    ->label('Status Saat Ini')
                                    ->content(function () use ($record) {
                                        $hasAbsences = $record->absence()->exists();
                                        $hasJournals = $record->journal()->exists();

                                        return ($hasAbsences && $hasJournals)
                                            ? 'Terlaksana'
                                            : 'Terjadwal';
                                    }),

                                Placeholder::make('keterangan')
                                    ->label('Keterangan')
                                    ->content(function () use ($record) {
                                        $hasAbsences = $record->absence()->exists();
                                        $hasJournals = $record->journal()->exists();

                                        if (! $hasAbsences && ! $hasJournals) {
                                            return 'Belum mengisi absensi dan jurnal.';
                                        }

                                        if (! $hasAbsences) {
                                            return 'Absensi belum diisi.';
                                        }

                                        if (! $hasJournals) {
                                            return 'Jurnal belum diisi.';
                                        }

                                        return 'Absensi dan jurnal sudah lengkap.';
                                    }),
                            ]),
                    ]),

                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    FilamentExportBulkAction::make('export')->defaultFormat('pdf'),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
