<?php

namespace App\Filament\User\Resources\Absences\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;
use App\Models\Schedule;

class AbsencesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            // =====================
            // PILIH JADWAL
            // =====================
            Forms\Components\Select::make('schedule_id')
                ->label('Pilih Jadwal')
                ->required()
                ->searchable()
                ->options(
                    Schedule::query()
                        ->where('status', 'terjadwal')
                        ->where('user_id', auth()->id())
                        ->with(['kelas.student', 'subject'])
                        ->get()
                        ->mapWithKeys(fn ($schedule) => [
                            $schedule->id =>
                                $schedule->subject->name
                                .' - '
                                .$schedule->kelas->full_class
                                .' ('.$schedule->start_time.'-'.$schedule->end_time.')',
                        ])
                )
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set) {
                    if (! $state) {
                        $set('students', []);
                        return;
                    }

                    $schedule = Schedule::with('kelas.student')->find($state);

                    if (! $schedule) {
                        $set('students', []);
                        return;
                    }

                    $set(
                        'students',
                        $schedule->kelas->student->map(fn ($student) => [
                            'student_id' => $student->id,
                            'student_name' => $student->name,
                            'status' => 'hadir',
                        ])->toArray()
                    );
                }),

            Forms\Components\Hidden::make('date')
                ->default(now()->toDateString()),

            // =====================
            // REPEATER SISWA
            // =====================
            Forms\Components\Repeater::make('students')
                ->label('Daftar Absensi Siswa')
                ->visible(fn ($get) => filled($get('schedule_id')))
                ->schema([
                    Forms\Components\Hidden::make('student_id'),

                    Forms\Components\TextInput::make('student_name')
                        ->label('Student name')
                        ->disabled()
                        ->dehydrated(),

                    Forms\Components\Radio::make('status')
                        ->options([
                            'hadir' => 'Hadir',
                            'izin' => 'Izin',
                            'alpha' => 'Alpha',
                            'sakit' => 'Sakit',
                        ])
                        ->default('hadir')
                        ->required()
                        ->inline(),
                ])
                ->disableItemCreation()
                ->disableItemDeletion()
                ->reorderable(false),
        ]);
    }
}
