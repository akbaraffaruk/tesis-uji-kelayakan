<?php

namespace App\Services;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Http;

class PredictionService
{
    private string $url;
    private array $data;

    public function __construct(array $data)
    {
        $this->url = config('services.flask.url');

        $this->data = $this->mutateData($data);
    }

    /**
     * @param array $data
     * @return array
     */
    private function mutateData(array $data): array
    {
        $birthdate = Carbon::parse($data['date_of_birth']);
        $age = $birthdate->age;

        return [
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
            'lantai_rumah' => $data['house_floor'],
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
            'angsuran' => $data['installment'],
            'umur' => $age,
            'total_pengeluaran' => $data['total_expenses'],
            'buyer_suami' => $data['gender'] === 'L' && $data['buyer'] === 'SENDIRI' ? 1 : 0,
            'buyer_istri' => $data['gender'] === 'P' && $data['buyer'] === 'SENDIRI' ? 1 : 0,
        ];

    }

    /**
     * @throws Exception
     */
    public function predict()
    {
        if (empty($this->data))
            throw new \Exception('Data is empty');

        $response = Http::post("$this->url/predict", $this->data);

        if ($response->ok()) {
            $resJson = $response->json();
            return $resJson['prediction'];
        }

        throw new \Exception('Failed to get prediction');
    }
}
