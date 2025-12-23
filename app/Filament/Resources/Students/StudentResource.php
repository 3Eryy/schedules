<?php

namespace App\Filament\Resources\Students;

use BackedEnum;
use UnitEnum;
use App\Models\Student;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use App\Filament\Resources\Students\Pages\EditStudent;
use App\Filament\Resources\Students\Pages\ListStudents;
use App\Filament\Resources\Students\Pages\CreateStudent;
use App\Filament\Resources\Students\Tables\StudentsTable;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-identification';

    protected static UnitEnum|string|null $navigationGroup = 'Universal';

    protected static ?string $recordTitleAttribute = 'Student';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Informasi Siswa')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama siswa')
                            ->required(),

                        TextInput::make('nis')
                            ->label('NIS')
                            ->required()
                            ->maxLength(50),

                        Select::make('kelas_id')
                            ->label('Nama Kelas')
                            ->options(
                                \App\Models\Kelas::with('majors')
                                    ->get()
                                    ->pluck('full_class', 'id')
                            )
                            ->searchable()
                            ->preload()
                            ->required(),
                    ])
                    ->columns(2),

                Section::make('Foto Profil')
                    ->schema([
                        FileUpload::make('photo')
                            ->label('Foto Siswa')
                            ->image()
                            ->directory('students/photos') // Folder penyimpanan
                            ->visibility('public') // atau 'private'
                            ->maxSize(2048) // 2MB
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg'])
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1') // Rasio 1:1
                            ->imageResizeTargetWidth('300')
                            ->imageResizeTargetHeight('300')
                            ->panelAspectRatio('1:1') // Preview ratio
                            ->panelLayout('integrated')
                            ->uploadingMessage('Mengunggah foto...')
                            ->uploadProgressIndicatorPosition('left')
                            ->helperText('Maksimal 2MB. Format: JPG, PNG')
                            ->getUploadedFileNameForStorageUsing(
                                fn(TemporaryUploadedFile $file): string =>
                                (string) str($file->getClientOriginalName())
                                    ->prepend('student-')
                                    ->append('-' . time())
                            ),
                    ])
                    ->collapsible()
                    ->collapsed(fn($operation) => $operation === 'edit'), // Collapsed saat edit
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
