<?php

namespace App\Filament\Resources\AttendaceResource\Pages;

use App\Filament\Resources\AttendaceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAttendace extends EditRecord
{
    protected static string $resource = AttendaceResource::class;
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
