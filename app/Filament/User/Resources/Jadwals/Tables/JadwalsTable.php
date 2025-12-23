<?php

namespace App\Filament\User\Resources\Jadwals\Tables;

use App\Models\Schedule;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;

class JadwalsTable
{
    
    public static function configure(Table $table): Table
    {
        return $table
            ->query(Schedule::query()->where('user_id', auth()->id()))
            ->columns([
                TextColumn::make('kelas.full_class')
                    ->label('Kelas')
                    ->searchable(['kelas_id.level', 'kelas_id.pararel', 'kelas_id.majors_id']),

                TextColumn::make('subject.name')
                    ->label('Mata Pelajaran')
                    ->searchable(),

                TextColumn::make('date')->label('Hari')->searchable(),
                TextColumn::make('start_time')->label('Waktu Mulai')->searchable(),
                TextColumn::make('end_time')->label('Waktu Selesai')->searchable(),
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

                        return ($hasAbsences || $hasJournals) ? 'terlaksana' : 'terjadwal';
                    }),
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
            ])
            ->headerActions([

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
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
