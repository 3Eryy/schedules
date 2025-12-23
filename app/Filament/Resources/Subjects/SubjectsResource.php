<?php

namespace App\Filament\Resources\Subjects;

use App\Filament\Resources\Subjects\Pages\CreateSubjects;
use App\Filament\Resources\Subjects\Pages\EditSubjects;
use App\Filament\Resources\Subjects\Pages\ListSubjects;
use App\Filament\Resources\Subjects\Tables\SubjectsTable;
use App\Models\Subjects;
use BackedEnum;
use UnitEnum;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class SubjectsResource extends Resource
{
    protected static ?string $model = Subjects::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-book-open';

    protected static UnitEnum|string|null $navigationGroup = 'Universal';

    protected static ?string $recordTitleAttribute = 'Subjects';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')
                    ->label('Nama Mata Pelajaran')
                    ->required()
                    ->maxLength(255),

                TextInput::make('code')
                    ->label('Kode')
                    ->required()
                    ->maxLength(50),
            ]);
    }


    public static function table(Table $table): Table
    {
        return SubjectsTable::configure($table);
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
            'index' => ListSubjects::route('/'),
            'create' => CreateSubjects::route('/create'),
            'edit' => EditSubjects::route('/{record}/edit'),
        ];
    }
}
