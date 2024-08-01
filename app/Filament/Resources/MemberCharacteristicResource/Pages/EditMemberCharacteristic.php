<?php

namespace App\Filament\Resources\MemberCharacteristicResource\Pages;

use App\Filament\Resources\MemberCharacteristicResource;
use App\Services\PredictionService;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Http;

class EditMemberCharacteristic extends EditRecord
{
    protected static string $resource = MemberCharacteristicResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
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

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
