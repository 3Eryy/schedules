<?php

namespace App\Filament\User\Resources\Journals;

use BackedEnum;
use UnitEnum;
use App\Models\Kelas;
use App\Models\Journal;
use App\Models\Schedule;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Filters\SelectFilter;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use App\Filament\User\Resources\Journals\Pages\EditJournal;
use App\Filament\User\Resources\Journals\Pages\ListJournals;
use App\Filament\User\Resources\Journals\Pages\CreateJournal;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;

class JournalResource extends Resource
{
    protected static ?string $model = Journal::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';

    protected static UnitEnum|string|null $navigationGroup = 'Form';

    protected static ?string $recordTitleAttribute = 'Journal';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Data Mengajar')
                    ->schema([

                        TextInput::make('user_id')
                            ->label(fn() => auth()->user()->name)
                            ->disabled()
                            ->default(fn() => auth()->user()->id)
                            ->dehydrated(true),

                        Select::make('schedule_id')
                            ->label('Jadwal')
                            ->options(
                                Schedule::with(['kelas.majors', 'subject'])
                                    ->where('user_id', auth()->id())
                                    ->where('status', 'terjadwal')
                                    ->get()
                                    ->mapWithKeys(fn ($schedule) => [
                                        $schedule->id =>
                                            $schedule->kelas->full_class
                                            . ' | '
                                            . $schedule->subject->name
                                            . ' ('
                                            . $schedule->start_time
                                            . ' - '
                                            . $schedule->end_time
                                            . ')'
                                    ])
                            )
                            ->searchable()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {

                                if (! $state) {
                                    $set('kelas_id', null);
                                    $set('subject_id', null);
                                    $set('date', null);
                                    $set('start_time', null);
                                    $set('end_time', null);
                                    return;
                                }

                                $schedule = Schedule::with(['kelas', 'subject'])->find($state);

                                if (! $schedule) return;

                                $set('kelas_id', $schedule->kelas_id);
                                $set('subject_id', $schedule->subject_id);
                                $set('date', $schedule->date);
                                $set('start_time', $schedule->start_time);
                                $set('end_time', $schedule->end_time);

                                // display only
                                $set('class_name', $schedule->kelas->full_class);
                                $set('subject_name', $schedule->subject->name);
                                $set('date_display', $schedule->date);
                                $set('start_time_display', $schedule->start_time);
                                $set('end_time_display', $schedule->end_time);
                            }),

                        Hidden::make('kelas_id')->required(),
                        Hidden::make('subject_id')->required(),
                        Hidden::make('date')->required(),
                        Hidden::make('start_time')->required(),
                        Hidden::make('end_time')->required(),

                        Grid::make(2)->schema([
                            TextInput::make('class_name')
                                ->label('Kelas')
                                ->disabled()
                                ->dehydrated(false),

                            TextInput::make('subject_name')
                                ->label('Mata Pelajaran')
                                ->disabled()
                                ->dehydrated(false),

                            DatePicker::make('date_display')
                                ->label('Tanggal')
                                ->disabled()
                                ->dehydrated(false),

                            TimePicker::make('start_time_display')
                                ->label('Jam Mulai')
                                ->disabled()
                                ->dehydrated(false),

                            TimePicker::make('end_time_display')
                                ->label('Jam Selesai')
                                ->disabled()
                                ->dehydrated(false),
                        ]),

                        Textarea::make('notes')
                            ->label('Catatan Mengajar')
                            ->required()
                            ->columnSpanFull(),

                    ])
                    ->columns(1),
                Section::make('Bukti Mengajar')
                    ->schema([
                        FileUpload::make('photo')
                            ->disk('public')
                            ->label('Foto Guru')
                            ->image()
                            ->directory('journals/photos') // Folder penyimpanan
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
                                'journal-' . Str::uuid() . '.' . $file->getClientOriginalExtension()
                            )
                    ])
                    ->collapsible()
                    ->collapsed(fn($operation) => $operation === 'edit'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                Journal::with(['kelas.majors', 'subject'])
                    ->where('user_id', auth()->id())
            )
            ->columns([
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

                SelectFilter::make('kelas_id')
                    ->relationship('kelas', 'id')
                    ->getOptionLabelFromRecordUsing(
                        fn (Kelas $record) => $record->full_class
                    )
                    ->label('Kelas'),
            ])
            ->actions([
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
            ->bulkActions([
                FilamentExportBulkAction::make('export')->defaultFormat('pdf'),
            ]);
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
            'index' => ListJournals::route('/'),
            'create' => CreateJournal::route('/create'),
            'edit' => EditJournal::route('/{record}/edit'),
        ];
    }
}
