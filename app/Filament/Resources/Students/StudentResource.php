<?php

namespace App\Filament\Resources\Students;

use BackedEnum;
use App\Models\Student;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\Students\Pages\EditStudent;
use App\Filament\Resources\Students\Pages\ListStudents;
use App\Filament\Resources\Students\Pages\CreateStudent;
use App\Filament\Resources\Students\Schemas\StudentForm;
use App\Filament\Resources\Students\Tables\StudentsTable;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-identification';

    protected static ?string $recordTitleAttribute = 'Student';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('kelas_id')
                    ->label('Nama Kelas')
                    ->options(
                        \App\Models\Kelas::with('majors')     // supaya majors bisa dipakai di accessor
                            ->get()
                            ->pluck('full_class', 'id')       // gunakan accessor
                    )
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('name')
                    ->label('Nama siswa')
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return StudentsTable::configure($table);
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
            'index' => ListStudents::route('/'),
            'create' => CreateStudent::route('/create'),
            'edit' => EditStudent::route('/{record}/edit'),
        ];
    }
}
