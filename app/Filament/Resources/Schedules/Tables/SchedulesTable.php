<?php

namespace App\Filament\Resources\Schedules\Tables;

use App\Models\User;
use App\Models\Subjects;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use Filament\Actions\DeleteAction;

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
                TextColumn::make('status')->searchable(),
            ])
            ->headerActions([
                FilamentExportHeaderAction::make('export')->defaultFormat('pdf'),
            ])
            // ->bulkActions([
            //     FilamentExportBulkAction::make('export'),
            // ])
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
                EditAction::make(),
                DeleteAction::make()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
