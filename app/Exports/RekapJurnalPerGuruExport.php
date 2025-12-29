<?php

namespace App\Exports;

use App\Models\Journal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithStyles,
    WithCustomStartCell
};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RekapJurnalPerGuruExport implements
    FromCollection,
    WithHeadings,
    WithStyles,
    WithCustomStartCell
{
    protected int $userId;
    protected string $bulan; // Y-m

    public function __construct(int $userId, string $bulan)
    {
        $this->userId = $userId;
        $this->bulan = $bulan;
    }

    public function collection(): Collection
    {
        $start = Carbon::createFromFormat('Y-m', $this->bulan)->startOfMonth();
        $end   = $start->copy()->endOfMonth();

        $journals = Journal::with(['kelas', 'subject'])
            ->where('user_id', $this->userId)
            ->whereBetween('date', [$start, $end])
            ->get()
            ->groupBy(fn($j) => Carbon::parse($j->date)->toDateString());

        $totalJam = 0;

        $rows = $journals->map(function ($items, $date) use (&$totalJam) {

            $jamHarian = 0;
            $notes = [];

            foreach ($items as $journal) {
                $jam = Carbon::parse($journal->start_time)
                    ->diffInHours(Carbon::parse($journal->end_time));

                $jamHarian += $jam;
                $totalJam += $jam;

                if ($journal->notes) {
                    $notes[] = $journal->notes;
                }
            }

            return [
                $date,
                $items->first()->kelas->full_class ?? '-',
                $items->first()->subject->name ?? '-',
                $jamHarian,
                implode(' | ', array_unique($notes)),
            ];
        });

        // BARIS TOTAL
        $rows->push([
            'TOTAL',
            '',
            '',
            $totalJam,
            '',
        ]);

        return $rows->values();
    }


    public function headings(): array
    {
        return [
            'Tanggal',
            'Kelas',
            'Mata Pelajaran',
            'Total Jam',
            'Catatan',
        ];
    }


    public function startCell(): string
    {
        return 'A5';
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->setCellValue('A1', 'REKAP JURNAL MENGAJAR');
        $sheet->setCellValue('A2', 'Guru: ' . User::find($this->userId)->name);
        $sheet->setCellValue('A3', 'Bulan: ' . Carbon::parse($this->bulan)->translatedFormat('F Y'));

        $sheet->mergeCells('A1:D1');
        $sheet->mergeCells('A2:D2');
        $sheet->mergeCells('A3:D3');

        return [
            5 => ['font' => ['bold' => true]],
        ];
    }
}
