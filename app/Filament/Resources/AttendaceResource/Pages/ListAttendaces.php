<?php

namespace App\Filament\Resources\AttendaceResource\Pages;

use App\Filament\Resources\AttendaceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAttendaces extends ListRecords
{
    protected static string $resource = AttendaceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
