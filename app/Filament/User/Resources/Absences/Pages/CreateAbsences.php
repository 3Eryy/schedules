<?php

namespace App\Filament\User\Resources\Absences\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\User\Resources\Absences\AbsencesResource;
use App\Models\Absence;

class CreateAbsences extends CreateRecord
{
    protected static string $resource = AbsencesResource::class;

    protected function handleRecordCreation(array $data): Absence
    {
        foreach ($data['students'] as $student) {
            Absence::create([
                'schedule_id' => $data['schedule_id'],
                'student_id' => $student['student_id'],
                'student_name' => $student['student_name'],
                'status' => $student['status'],
                'date' => $data['date'],
            ]);
        }

        // return dummy (Filament wajib return Model)
        return Absence::latest()->first();
    }
}
