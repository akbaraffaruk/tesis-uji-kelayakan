<?php

namespace App\Filament\Resources\MemberCharacteristicResource\Pages;

use App\Filament\Resources\MemberCharacteristicResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMemberCharacteristics extends ListRecords
{
    protected static string $resource = MemberCharacteristicResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
