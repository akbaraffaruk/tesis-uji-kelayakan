<?php

namespace App\Filament\Resources\MemberCharacteristicResource\Pages;

use App\Filament\Resources\MemberCharacteristicResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMemberCharacteristic extends EditRecord
{
    protected static string $resource = MemberCharacteristicResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
