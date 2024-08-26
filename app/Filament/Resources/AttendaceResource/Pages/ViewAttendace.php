<?php

namespace App\Filament\Resources\AttendaceResource\Pages;

use App\Filament\Resources\AttendaceResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAttendace extends ViewRecord
{
    protected static string $resource = AttendaceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
