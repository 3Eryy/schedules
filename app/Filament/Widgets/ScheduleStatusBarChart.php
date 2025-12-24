<?php

namespace App\Filament\Widgets;

use App\Models\Schedule;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class ScheduleStatusBarChart extends ChartWidget
{
    protected ?string $heading = 'Perbandingan Status Jadwal Hari Ini';

    protected function getData(): array
    {
        $today = Carbon::today();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Jadwal',
                    'data' => [
                        Schedule::where('status', 'terlaksana')
                            ->whereDate('date', $today)
                            ->count(),
                        Schedule::where('status', 'terjadwal')
                            ->whereDate('date', $today)
                            ->count(),
                    ],
                ],
            ],
            'labels' => [
                'Terlaksana',
                'Terjadwal',
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
