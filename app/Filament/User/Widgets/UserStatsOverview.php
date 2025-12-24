<?php

namespace App\Filament\User\Widgets;

use App\Models\Absence;
use App\Models\Schedule;
use App\Models\Journal;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $today = today();
        $userId = auth()->id();

        return [
            Stat::make(
                'Jadwal Hari Ini',
                Schedule::whereDate('date', $today)
                    ->where('user_id', $userId)
                    ->count()
            )
                ->icon('heroicon-o-calendar-days')
                ->color('primary'),

            Stat::make(
                'Presensi Hari Ini',
                Absence::whereDate('date', $today)
                    ->whereHas('schedule', function ($q) use ($userId) {
                        $q->where('user_id', $userId);
                    })
                    ->count()
            )
                ->icon('heroicon-o-clipboard-document-check')
                ->color('success'),

            Stat::make(
                'Jurnal Hari Ini',
                Journal::whereDate('date', $today)
                    ->whereHas('schedule', function ($q) use ($userId) {
                        $q->where('user_id', $userId);
                    })
                    ->count()
            )
                ->icon('heroicon-o-book-open')
                ->color('warning'),
        ];
    }
}
