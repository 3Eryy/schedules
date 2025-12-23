<?php

namespace App\Filament\User\Resources\Journals\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class JournalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('kelas_id')
                    ->required()
                    ->numeric(),
                TextInput::make('subject_id')
                    ->required()
                    ->numeric(),
                TextInput::make('schedule_id')
                    ->required()
                    ->numeric(),
                DatePicker::make('date')
                    ->required(),
                TimePicker::make('start_time')
                    ->required(),
                TimePicker::make('end_time')
                    ->required(),
                Textarea::make('notes')
                    ->columnSpanFull(),
                TextInput::make('teacher_name')
                    ->required(),
                TextInput::make('class_name')
                    ->required(),
                TextInput::make('major_name')
                    ->required(),
                TextInput::make('level_name')
                    ->required(),
                TextInput::make('subject_name')
                    ->required(),
            ]);
    }
}
