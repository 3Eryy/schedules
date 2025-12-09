<?php

namespace App\Filament\Resources\Users\Pages;

use App\Models\User;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\Users\UsersResource;

class ListUsers extends ListRecords
{
    protected static string $resource = UsersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return User::query()->where('role', 'user');
    }
}
