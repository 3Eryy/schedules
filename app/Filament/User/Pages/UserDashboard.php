<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use BackedEnum;

class UserDashboard extends Page
{
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?int $navigationSort = 1;

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\User\Widgets\UserStatsOverview::class,
            \App\Filament\User\Widgets\UserActivityChart::class,
        ];
    }
}

