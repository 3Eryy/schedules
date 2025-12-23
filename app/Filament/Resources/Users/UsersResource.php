<?php

namespace App\Filament\Resources\Users;

use BackedEnum;
use UnitEnum;
use App\Models\User;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use App\Filament\Resources\Users\Pages\EditUsers;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Pages\CreateUsers;
use App\Filament\Resources\Users\Tables\UsersTable;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class UsersResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-users';

    protected static UnitEnum|string|null $navigationGroup = 'Universal';

    protected static ?string $recordTitleAttribute = 'Users';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Informasi Guru')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama guru')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label('email')
                            ->required()
                            ->maxLength(50),

                        TextInput::make('phone_number')
                            ->label('Nomor Handphone')
                            ->required()
                            ->maxLength(50),

                        TextInput::make('address')
                            ->label('Alamat')
                            ->required()
                            ->maxLength(100),

                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->required()
                            ->maxLength(255)
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state)) // hanya simpan jika user isi
                    ])
                    ->columns(2),
                Section::make('Foto Profil')
                    ->schema([
                        FileUpload::make('photo')
                                    ->label('Foto Guru')
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
        return UsersTable::configure($table);
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
            'index' => ListUsers::route('/'),
            'create' => CreateUsers::route('/create'),
            'edit' => EditUsers::route('/{record}/edit'),
        ];
    }
}
