<?php

namespace App\Filament\Components\Forms;

use Filament\Forms\Components;
use Filament\Forms\Get;
use Filament\Forms\Set;

class HouseIndexForm
{
    // Define all the fields that contribute to the total house index
    protected static array $fields = [
        'house_status' => [
            'MILIK SENDIRI' => 4,
            'SEWA' => 2,
            'NUMPANG' => 0,
        ],
        'house_area' => [
            70 => 4,
            50 => 2,
            30 => 0,
        ],
        'roof_type' => [
            'GENTENG' => 4,
            'SENG' => 1,
            'RUMBIA' => 0,
        ],
        'house_wall' => [
            'TEMBOK' => 4,
            'SEMI TEMBOK' => 2,
            'KAYU/PAPAN' => 1,
            'BAMBU' => 0,
        ],
        'house_floor' => [
            'TEGEL' => 4,
            'PLESTER SEMEN/CAMPURAN TRASO, KERAMIK, DLL' => 2,
            'PAPAN/KAYU/BAMBU' => 1,
            'TANAH' => 0,
        ],
        'type_of_lighting' => [
            'LISTRIK' => 4,
            'PATROMAK' => 2,
            'LAMPU MINYAK' => 0,
        ],
        'latrine_type' => [
            'WC' => 4,
            'JAMBAN TERBUKA' => 2,
            'DI SUNGAI' => 0,
        ],
        'source_of_drinking_water' => [
            'SUMUR SENDIRI' => 4,
            'SUMUR BERSAMA' => 2,
            'DI SUNGAI/MATA AIR' => 0,
        ],
        // Add other fields and their respective options and values here
    ];

    private static function calculateTotalIndex(Get $get): int
    {
        $total = 0;

        foreach (self::$fields as $field => $options) {
            $state = $get($field);
            if ($state && isset($options[$state])) {
                $total += $options[$state];
            }
        }

        return $total;
    }

    public static function renderForm(): array
    {
        return [
            Components\Select::make('house_status')
                ->label('Status Rumah')
                ->placeholder('Status Rumah')
                ->required()
                ->native(false)
                ->live(debounce: 1000)
                ->afterStateUpdated(function (Get $get, Set $set) {
                    $set('total_house_index', self::calculateTotalIndex($get));
                })
                ->options([
                    'MILIK SENDIRI' => 'MILIK SENDIRI (4)',
                    'SEWA' => 'SEWA (2)',
                    'NUMPANG' => 'NUMPANG (0)',
                ]),

            Components\TextInput::make('yard_area')
                ->label('Luas Pekarangan')
                ->suffix('m²', true)
                ->placeholder('Luas Pekarangan')
                ->numeric()
                ->required(),

            Components\Select::make('house_area')
                ->label('Luas Rumah')
                ->placeholder('Luas Rumah')
                ->required()
                ->native(false)
                ->live(debounce: 1000)
                ->afterStateUpdated(function (Get $get, Set $set) {
                    $set('total_house_index', self::calculateTotalIndex($get));
                })
                ->options([
                    70 => 'BESAR > 70 M² (4)',
                    50 => 'SEDANG 30 - 69 M² (2)',
                    30 => 'KECIL < 30 M² (0)',
                ]),

            Components\Select::make('roof_type')
                ->label('Jenis Atap')
                ->placeholder('Jenis Atap')
                ->required()
                ->native(false)
                ->live(debounce: 1000)
                ->afterStateUpdated(function (Get $get, Set $set) {
                    $set('total_house_index', self::calculateTotalIndex($get));
                })
                ->options([
                    'GENTENG' => 'GENTENG (4)',
                    'SENG' => 'SENG (1)',
                    'RUMBIA' => 'RUMBIA (0)',
                ]),

            Components\Select::make('house_wall')
                ->label('Dinding Rumah')
                ->placeholder('Dinding Rumah')
                ->required()
                ->native(false)
                ->live(debounce: 1000)
                ->afterStateUpdated(function (Get $get, Set $set) {
                    $set('total_house_index', self::calculateTotalIndex($get));
                })
                ->options([
                    'TEMBOK' => 'TEMBOK (4)',
                    'SEMI TEMBOK' => 'SEMI TEMBOK (2)',
                    'KAYU/PAPAN' => 'KAYU/PAPAN (1)',
                    'BAMBU' => 'BAMBU (0)',
                ]),

            Components\Select::make('house_floor')
                ->label('Lantai Rumah')
                ->placeholder('Lantai Rumah')
                ->required()
                ->native(false)
                ->live(debounce: 1000)
                ->afterStateUpdated(function (Get $get, Set $set) {
                    $set('total_house_index', self::calculateTotalIndex($get));
                })
                ->options([
                    'TEGEL' => 'TEGEL (4)',
                    'PLESTER SEMEN/CAMPURAN TRASO, KERAMIK, DLL' => 'PLESTER SEMEN/CAMPURAN TRASO, KERAMIK, DLL (2)',
                    'PAPAN/KAYU/BAMBU' => 'PAPAN/KAYU/BAMBU (1)',
                    'TANAH' => 'TANAH (0)',
                ]),

            Components\Select::make('type_of_lighting')
                ->label('Jenis Penerangan')
                ->placeholder('Jenis Penerangan')
                ->required()
                ->native(false)
                ->live(debounce: 1000)
                ->afterStateUpdated(function (Get $get, Set $set) {
                    $set('total_house_index', self::calculateTotalIndex($get));
                })
                ->options([
                    'LISTRIK' => 'LISTRIK (4)',
                    'PATROMAK' => 'PATROMAK (2)',
                    'LAMPU MINYAK' => 'LAMPU MINYAK (0)',
                ]),

            Components\Select::make('latrine_type')
                ->label('Jenis Jamban')
                ->placeholder('Jenis Jamban')
                ->required()
                ->native(false)
                ->live(debounce: 1000)
                ->afterStateUpdated(function (Get $get, Set $set) {
                    $set('total_house_index', self::calculateTotalIndex($get));
                })
                ->options([
                    'WC' => 'WC (4)',
                    'JAMBAN TERBUKA' => 'JAMBAN TERBUKA (2)',
                    'DI SUNGAI' => 'DI SUNGAI (0)',
                ]),

            Components\Select::make('source_of_drinking_water')
                ->label('Sumber Air Minum')
                ->placeholder('Sumber Air Minum')
                ->required()
                ->native(false)
                ->live(debounce: 1000)
                ->afterStateUpdated(function (Get $get, Set $set) {
                    $set('total_house_index', self::calculateTotalIndex($get));
                })
                ->options([
                    'SUMUR SENDIRI' => 'SUMUR SENDIRI (4)',
                    'SUMUR BERSAMA' => 'SUMUR BERSAMA (2)',
                    'DI SUNGAI/MATA AIR' => 'DI SUNGAI/MATA AIR (0)',
                ]),

            Components\TextInput::make('total_house_index')
                ->label('Total Indeks Rumah')
                ->numeric()
                ->readOnly()
                ->default(0),
        ];
    }
}
