<?php

namespace App\Filament\Forms;

use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;

// class JournalForm
// {
//     public static function getForm(Schedule $schedule = null)
//     {
//         return [
//             TextInput::make('user_id')
//                 ->placeholder(fn () => Auth::user()->id)
//                 ->default(fn () => Auth::user()->id),
                
//             Hidden::make('kelas_id')
//                 ->default($schedule?->kelas_id),
                
//             Hidden::make('subject_id')
//                 ->default($schedule?->subject_id),
                
//             Hidden::make('schedule_id')
//                 ->default($schedule?->id),
                
//             Hidden::make('teacher_name')
//                 ->default(auth()->user()->name),
                
//             Hidden::make('class_name')
//                 ->default($schedule?->kelas->pararel ?? ''),
                
//             Hidden::make('major_name')
//                 ->default($schedule?->kelas->majors->name ?? ''),
                
//             Hidden::make('level_name')
//                 ->default($schedule?->kelas->level ?? ''),
                
//             Hidden::make('subject_name')
//                 ->default($schedule?->subject->name ?? ''),
                
//             DatePicker::make('date')
//                 ->label('Tanggal')
//                 ->default($schedule?->date)
//                 ->required()
//                 ->disabled(),
                
//             TimePicker::make('start_time')
//                 ->label('Waktu Mulai')
//                 ->default($schedule?->start_time)
//                 ->required()
//                 ->seconds(false),
                
//             TimePicker::make('end_time')
//                 ->label('Waktu Selesai')
//                 ->default($schedule?->end_time)
//                 ->required()
//                 ->seconds(false)
//                 ->after('start_time'),
                
//             Textarea::make('notes')
//                 ->label('Catatan Mengajar')
//                 ->placeholder('Contoh: Materi yang diajarkan, kegiatan pembelajaran, kendala, dll.')
//                 ->rows(4)
//                 ->columnSpanFull(),
//         ];
//     }
// }