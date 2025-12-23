<?php

namespace App\Filament\Resources\JournalHistories\Tables;

use App\Models\Kelas;
use App\Models\Journal;
use Filament\Tables\Table;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;

class JournalHistoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Nama Guru')
                    ->searchable(),

                TextColumn::make('kelas')
                    ->label('Kelas')
                    ->formatStateUsing(fn (Journal $record) =>
                        $record->kelas
                            ? $record->kelas->level . ' '
                                . $record->kelas->majors->code . ' '
                                . $record->kelas->pararel
                            : '-'
                    )
                    ->searchable(),

                TextColumn::make('subject.name')
                    ->label('Mata Pelajaran')
                    ->searchable(),

                TextColumn::make('date')
                    ->label('Hari')
                    ->date('Y-m-d')
                    ->sortable(),


                TextColumn::make('start_time')
                    ->label('Waktu Mulai')
                    ->time(),

                TextColumn::make('end_time')
                    ->label('Waktu Selesai')
                    ->time(),
            ])
            ->filters([
                SelectFilter::make('subject_id')
                    ->relationship('subject', 'name')
                    ->label('Mata Pelajaran'),

                SelectFilter::make('user_id')
                    ->label('Nama Guru')
                    ->relationship(
                        'user',
                        'name',
                        fn (Builder $query) => $query->where('role', 'user')
                    )
                    ->searchable()
                    ->preload(),

                SelectFilter::make('kelas_id')
                    ->relationship('kelas', 'id')
                    ->getOptionLabelFromRecordUsing(
                        fn (Kelas $record) => $record->full_class
                    )
                    ->label('Kelas'),
                SelectFilter::make('date')
                    ->form([
                        DatePicker::make('date')
                            ->label('Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when(
                                $data['date'],
                                fn ($query, $date) => $query->whereDate('date', $date),
                            );
                    }),
            ])
            ->recordActions([
                ViewAction::make()
                ->label('Detail')
                ->modalHeading('Detail Jurnal Mengajar')
                ->infolist(function ($infolist){
                    return $infolist->schema([
                        TextEntry::make('date')
                            ->label('Tanggal')
                            ->date('d F Y'),

                        TextEntry::make('subject.name')
                            ->label('Mata Pelajaran'),

                        TextEntry::make('kelas.full_class')
                            ->label('Kelas'),

                        TextEntry::make('start_time')
                            ->label('Jam Mulai')
                            ->time(),

                        TextEntry::make('end_time')
                            ->label('Jam Selesai')
                            ->time(),

                        TextEntry::make('notes')
                            ->label('Catatan')
                            ->columnSpanFull(),

                        ImageEntry::make('photo')
                            ->label('Foto Bukti Mengajar')
                            ->disk('public')
                            ->height(200)
                            ->width(200),
                    ]);
                }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    FilamentExportBulkAction::make('export')->defaultFormat('pdf'),
                ]),
            ]);
    }
}
