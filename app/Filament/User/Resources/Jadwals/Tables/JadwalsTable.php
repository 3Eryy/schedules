<?php

namespace App\Filament\User\Resources\Jadwals\Tables;

use App\Models\Schedule;
use Filament\Tables\Table;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;

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
                TextColumn::make('status')->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([]) // Ini akan menghapus semua header actions termasuk "New Schedule"
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}