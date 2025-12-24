<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use BackedEnum;

class Dashboard extends BaseDashboard
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-home';

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\AdminStatsOverview::class,
            \App\Filament\Widgets\ScheduleStatusChart::class,
            \App\Filament\Widgets\ScheduleStatusBarChart::class,
        ];
    }
}
