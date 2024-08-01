<?php

namespace App\Filament\Resources\MemberCharacteristicResource\Pages;

use App\Filament\Resources\MemberCharacteristicResource;
use App\Services\PredictionService;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateMemberCharacteristic extends CreateRecord
{
    protected static string $resource = MemberCharacteristicResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        try {
            $data['kol_prediction'] = (new PredictionService($data))->predict();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Prediction Failed')
                ->body('Please check your data and try again.')
                ->send();
        }

        return $data;
    }
}
