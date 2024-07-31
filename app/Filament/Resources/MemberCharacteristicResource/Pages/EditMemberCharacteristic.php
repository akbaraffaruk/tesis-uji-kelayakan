<?php

namespace App\Filament\Resources\MemberCharacteristicResource\Pages;

use App\Filament\Resources\MemberCharacteristicResource;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMemberCharacteristic extends EditRecord
{
    protected static string $resource = MemberCharacteristicResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $birthdate = Carbon::parse($data['date_of_birth']);
        $age = $birthdate->age;

        $reqBody = [
            'pekerjaan' => $data['work'],
            'sumber_pendapatan' => $data['source_of_income'],
            'konsumsi_beras' => $data['rice_consumption'],
            'harga_beras' => $data['rice_price'],
            'belanja_dapur' => $data['kitchen_shop'],
            'rekening_listrik' => $data['electricity_bills'],
            'pendidikan' => $data['education'],
            'lainnya' => $data['other_costs'],
            'simpanan_tabungan' => $data['savings'],
            'status_rumah' => $data['house_status'],
            'luas_pekarangan' => $data['yard_area'],
            'luas_rumah' => $data['house_area'],
            'jenis_atap' => $data['roof_type'],
            'dinding_rumah' => $data['house_wall'],
            'jenis_penerangan' => $data['type_of_lighting'],
            'jenis_jamban' => $data['latrine_type'],
            'sumber_air_minum' => $data['source_of_drinking_water'],
            'total_nilai_indeks_rumah' => $data['total_house_index'],
            'total_pendapatan_rumah_tangga' => $data['total_household_income'],
            'jumlah_anggota_rumah_tangga' => $data['total_household_members'],
            'pendapatan_perkapita' => $data['income_per_capita'],
            'tenor' => $data['tenor'],
            'pokok' => $data['pokok'],
            'margin' => $data['margin'],
            'status_pernikahan' => $data['marital_status'],
            'form' => $data['work'],
            'installment' => $data['installment'],
            'age' => $age,
            'total_pengeluaran' => $data['total_expenses'],
            'buyer_suami' => $data['gender'] === 'L' && $data['buyer'] === 'SENDIRI' ? 1 : 0,
            'buyer_istri' => $data['gender'] === 'P' && $data['buyer'] === 'SENDIRI' ? 1 : 0,
        ];

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
