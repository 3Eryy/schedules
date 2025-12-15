<?php

namespace App\Filament\Resources\Students\Tables;

use App\Models\Kelas;
use Dom\Text;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;

class StudentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')
                    ->label('Foto')
                    ->defaultImageUrl(url('/images/default-avatar.png'))
                    ->size(40),
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('nis')->sortable()->searchable(),
                TextColumn::make('kelas.full_class')->sortable()->searchable()
            ])
            ->filters([
                SelectFilter::make('kelas_id')
                    ->label('Nama Kelas')
                    ->options(
                        Kelas::with('majors')     // supaya majors bisa dipakai di accessor
                            ->get()
                            ->pluck('full_class', 'id')       // gunakan accessor
                    )
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
