<?php

namespace App\Filament\Forms;

use App\Models\Student;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;

class AbsensiForm
{
    public static function getForm($kelasId, Schedule $schedule = null)
    {
        $students = Student::with('kelas')->where('kelas_id', $kelasId)->get();
        
        $defaultValues = [];
        foreach ($students as $student) {
            $defaultValues[] = [
                'student_id' => $student->id,
                'student_name' => $student->name,
                'nis' => $student->nis,
                'kelas_name' => $student->kelas->full_class,
                'status' => 'hadir', // Default value hadir
            ];
        }
        
        return [
            Hidden::make('schedule_id')
                ->default($schedule?->id),
                
            Hidden::make('kelas_id')
                ->default($kelasId),
                
            Hidden::make('subject_id')
                ->default($schedule?->subject_id),
                
            Hidden::make('date')
                ->default($schedule?->date),
                
            Repeater::make('absensi')
                ->label('Absensi Siswa')
                ->schema([
                    Hidden::make('student_id'),
                    Hidden::make('student_name'),
                    Hidden::make('nis'),
                    Hidden::make('kelas_name'),
                    
                    Radio::make('status')
                        ->label(fn ($get) => "{$get('nis')} - {$get('student_name')} [{$get('kelas_name')}]")
                        ->options([
                            'hadir' => 'Hadir',
                            'izin' => 'Izin',
                            'alpha' => 'Alpha',
                            'sakit' => 'Sakit',
                        ])
                        ->default('hadir')
                        ->inline()
                        ->required(),
                ])
                ->default($defaultValues)
                ->columns(1)
                ->disableItemCreation()
                ->disableItemDeletion()
                ->disableItemMovement()
                ->grid(2),
        ];
    }
}