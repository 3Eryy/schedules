<?php

namespace App\Filament\Resources\Classes;

use BackedEnum;
use UnitEnum;
use App\Models\Kelas;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\Classes\Pages\EditClass;
use App\Filament\Resources\Classes\Pages\CreateClass;
use App\Filament\Resources\Classes\Pages\ListClasses;
use App\Filament\Resources\Classes\Tables\ClassesTable;
use Filament\Forms\Components\Select;

class ClassResource extends Resource
{
    protected static ?string $model = Kelas::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-academic-cap';

    protected static UnitEnum|string|null $navigationGroup = 'Universal';

    protected static ?string $recordTitleAttribute = 'Class';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('majors_id')
                    ->relationship('majors', 'name')
                    ->label('Nama Jurusan')
                    ->required(),

                Select::make('level')
                    ->label('level')
                    ->options(
                        [
                            'X' => 'X', 
                            'XI' => 'XI', 
                            'XII' => 'XII'
                        ]
                    )
                    ->required(),

                TextInput::make('pararel')
                    ->label('Pararel kelas')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return ClassesTable::configure($table);
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
            'index' => ListClasses::route('/'),
            'create' => CreateClass::route('/create'),
            'edit' => EditClass::route('/{record}/edit'),
        ];
    }
}
