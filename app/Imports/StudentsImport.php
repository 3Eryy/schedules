<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\Kelas;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            // Cari kelas berdasarkan full_class
            $kelas = Kelas::with('majors')->get()
                ->firstWhere('full_class', $row['kelas']);

            if (! $kelas) {
                continue; // skip kalau kelas tidak ditemukan
            }

            $student = Student::create([
                'name'     => $row['name'],
                'nis'      => $row['nis'],
                'kelas_id'=> $kelas->id,
            ]);

            // Handle foto
            if (!empty($row['photo'])) {
                $photoPath = storage_path('app/imports/photos/' . $row['photo']);

                if (file_exists($photoPath)) {
                    $student
                        ->addMedia($photoPath)
                        ->toMediaCollection('photo');
                }
            }
        }
    }
}
