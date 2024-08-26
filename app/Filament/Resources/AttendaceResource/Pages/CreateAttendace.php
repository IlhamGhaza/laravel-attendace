<?php

namespace App\Filament\Resources\AttendaceResource\Pages;

use App\Filament\Resources\AttendaceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAttendace extends CreateRecord
{
    protected static string $resource = AttendaceResource::class;
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
