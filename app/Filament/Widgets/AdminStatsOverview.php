<?php

namespace App\Filament\Widgets;

use App\Models\Student;
use App\Models\Kelas;
use App\Models\Majors;
use App\Models\Schedule;
use App\Models\Absence;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class AdminStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Guru', User::where('role', 'user')->count())
                ->icon('heroicon-o-user')
                ->color('primary'),

            Stat::make('Total Siswa', Student::count())
                ->icon('heroicon-o-user-group')
                ->color('primary'),

            Stat::make('Total Kelas', Kelas::count())
                ->icon('heroicon-o-building-office-2')
                ->color('primary'),

            Stat::make('Jurusan', Majors::count())
                ->icon('heroicon-o-academic-cap')
                ->color('primary'),

            Stat::make(
                'Jadwal Hari Ini',
                Schedule::whereDate('date', Carbon::today())->count()
            )
                ->icon('heroicon-o-calendar-days')
                ->color('primary'),

            Stat::make(
                'Presensi Hari Ini',
                Absence::whereDate('date', Carbon::today())->count()
            )
                ->icon('heroicon-o-clipboard-document-check')
                ->color('primary'),
        ];
    }
}
