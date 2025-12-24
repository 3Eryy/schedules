<?php

namespace App\Filament\Widgets;

use App\Models\Schedule;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class ScheduleStatusChart extends ChartWidget
{
    protected ?string $heading = 'Status Jadwal';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Jumlah',
                    'data' => [
                        Schedule::where('status', 'terlaksana')
                            ->whereDate('date', Carbon::today())
                            ->count(),
                        Schedule::where('status', 'terjadwal')
                            ->whereDate('date', Carbon::today())
                            ->count(),
                    ],
                    'backgroundColor' => [
                        '#2563eb', // biru
                        '#93c5fd', // biru muda
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
        return 'doughnut';
    }
}
