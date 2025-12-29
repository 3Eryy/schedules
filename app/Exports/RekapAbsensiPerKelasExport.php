<?php

namespace App\Exports;

use App\Models\Absence;
use App\Models\Student;
use App\Models\Kelas;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithStyles,
    WithCustomStartCell
};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RekapAbsensiPerKelasExport implements 
    FromCollection, 
    WithHeadings, 
    WithStyles,
    WithCustomStartCell
{
    protected int $kelasId;
    protected string $bulan; // format: Y-m

    public function __construct(int $kelasId, string $bulan)
    {
        $this->kelasId = $kelasId;
        $this->bulan = $bulan;
    }

    public function collection(): Collection
    {
        $start = Carbon::createFromFormat('Y-m', $this->bulan)->startOfMonth();
        $end   = $start->copy()->endOfMonth();
        $daysInMonth = $start->daysInMonth;

        $students = Student::with('kelas')->where('kelas_id', $this->kelasId)->get();

        return $students->map(function ($student) use ($start, $end, $daysInMonth) {

            // Ambil semua absensi siswa dalam 1 bulan (1 QUERY)
            $absences = Absence::with('schedule')
                ->where('student_id', $student->id)
                ->whereBetween('date', [$start, $end])
                ->get()
                ->groupBy(fn ($a) => Carbon::parse($a->date)->toDateString());

            $row = [
                $student->name,
                $student->kelas->full_class,
                $student->nis,
            ];

            $totalS = 0;
            $totalI = 0;
            $totalA = 0;

            for ($day = 1; $day <= $daysInMonth; $day++) {
                $date = $start->copy()->day($day)->toDateString();

                $dailyAbsences = $absences->get($date, collect());

                $dailyHours = 0;

                foreach ($dailyAbsences as $absence) {

                    // Abaikan hadir
                    if ($absence->status === 'hadir') {
                        continue;
                    }

                    $hours = Carbon::parse($absence->schedule->start_time)
                        ->diffInHours(Carbon::parse($absence->schedule->end_time));

                    $dailyHours += $hours;

                    match ($absence->status) {
                        'sakit' => $totalS += $hours,
                        'izin'  => $totalI += $hours,
                        'alpha' => $totalA += $hours,
                    };
                }

                // Isi cell harian
                $row[] = $dailyHours > 0 ? $dailyHours : '-';
            }

            // Kolom total
            $row[] = $totalS;
            $row[] = $totalI;
            $row[] = $totalA;

            return $row;
        });
    }


    public function headings(): array
    {
        $start = Carbon::createFromFormat('Y-m', $this->bulan);
        $days = [];

        for ($i = 1; $i <= $start->daysInMonth; $i++) {
            $days[] = $i;
        }

        return array_merge(
            ['Nama Siswa', 'Kelas', 'NIS'],
            $days,
            ['S', 'I', 'A']
        );
    }

    public function startCell(): string
    {
        return 'A4';
    }

    public function styles(Worksheet $sheet)
    {
        $kelas = Kelas::find($this->kelasId);

        $sheet->setCellValue('A1', 'REKAP ABSENSI');
        $sheet->setCellValue('A2', 'Kelas: ' . $kelas->full_class);
        $sheet->setCellValue('A3', 'Bulan: ' . Carbon::parse($this->bulan)->translatedFormat('F Y'));

        $sheet->mergeCells('A1:D1');
        $sheet->mergeCells('A2:D2');
        $sheet->mergeCells('A3:D3');

        return [
            4 => ['font' => ['bold' => true]],
        ];
    }
}
