<?php

namespace App\Filament\Resources\Majors;

use BackedEnum;
use UnitEnum;
use App\Models\Majors;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\Majors\Pages\EditMajors;
use App\Filament\Resources\Majors\Pages\ListMajors;
use App\Filament\Resources\Majors\Pages\CreateMajors;
use App\Filament\Resources\Majors\Tables\MajorsTable;

class MajorsResource extends Resource
{
    protected static ?string $model = Majors::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-squares-2x2';

    protected static UnitEnum|string|null $navigationGroup = 'Universal';

    protected static ?string $recordTitleAttribute = 'Majors';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')
                    ->label('Nama Jurusan')
                    ->required()
                    ->maxLength(255),

                TextInput::make('code')
                    ->label('Kode Jurusan')
                    ->required()
                    ->maxLength(50),

                TextInput::make('max_pararel')
                    ->label('Jumlah Pararel')
                    ->required()
                    ->maxLength(50),
            ]);
    }

    public static function table(Table $table): Table
    {
        return MajorsTable::configure($table);
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
            'index' => ListMajors::route('/'),
            'create' => CreateMajors::route('/create'),
            'edit' => EditMajors::route('/{record}/edit'),
        ];
    }
}
