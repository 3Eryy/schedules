<?php

namespace App\Filament\User\Widgets;

use App\Models\Absence;
use App\Models\Schedule;
use App\Models\Journal;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class UserActivityChart extends ChartWidget
{
    protected ?string $heading = 'Aktivitas Saya (7 Hari Terakhir)';

    protected function getData(): array
    {
        $labels = [];
        $absenceData = [];
        $scheduleData = [];
        $journalData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels[] = $date->format('d M');

            // Absensi (via schedule -> user_id)
            $absenceData[] = Absence::whereDate('date', $date)
                ->whereHas('schedule', function ($q) {
                    $q->where('user_id', auth()->id());
                })
                ->count();

            // Jadwal milik user
            $scheduleData[] = Schedule::whereDate('date', $date)
                ->where('user_id', auth()->id())
                ->count();

            // Jurnal via schedule
            $journalData[] = Journal::whereDate('date', $date)
                ->whereHas('schedule', function ($q) {
                    $q->where('user_id', auth()->id());
                })
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Absensi',
                    'data' => $absenceData,
                ],
                [
                    'label' => 'Jadwal',
                    'data' => $scheduleData,
                ],
                [
                    'label' => 'Jurnal',
                    'data' => $journalData,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
