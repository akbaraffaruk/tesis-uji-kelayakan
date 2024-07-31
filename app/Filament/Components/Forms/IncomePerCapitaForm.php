<?php

namespace App\Filament\Components\Forms;

use Filament\Forms\Components;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Support\RawJs;

class IncomePerCapitaForm
{

    private static function setCalculateTotalIncomePerCapita(Get $get, Set $set): void
    {
        $total = 0;

        $totalHouseholdIncome = (int)str_replace(',', '', $get('total_household_income') ?? 0);
        $totalHouseholdMembers = (int)str_replace(',', '', $get('total_household_members') ?? 0);

        if ($totalHouseholdMembers > 0)
            $total = $totalHouseholdIncome / $totalHouseholdMembers;
        else
            $total = $totalHouseholdIncome;

        $totalFormat = number_format($total, 0);

        $set('income_per_capita', $totalFormat);
    }

    public static function renderForm(): array
    {
        return [
            Components\TextInput::make('total_household_income')
                ->label('Total Pendapatan Keluarga')
                ->required()
                ->live(debounce: 1000)
                ->prefix('Rp')
                ->mask(RawJs::make('$money($input)'))
                ->afterStateUpdated(fn(Get $get, Set $set) => self::setCalculateTotalIncomePerCapita($get, $set))
                ->dehydrateStateUsing(fn(string|int $state) => (int)str_replace(',', '', $state))
                ->placeholder('Total Pendapatan Keluarga'),
            Components\TextInput::make('total_household_members')
                ->label('Jumlah Anggota Keluarga')
                ->minValue(1)
                ->required()
                ->live(debounce: 1000)
                ->suffix('Orang')
                ->numeric()
                ->afterStateUpdated(fn(Get $get, Set $set) => self::setCalculateTotalIncomePerCapita($get, $set))
                ->placeholder('Jumlah Anggota Keluarga'),
            Components\TextInput::make('income_per_capita')
                ->label('Pendapatan Per Kapita')
                ->hint('Total Pendapatan Keluarga / Jumlah Anggota Keluarga')
                ->readOnly()
                ->required()
                ->prefix('Rp')
                ->columnSpanFull()
                ->mask(RawJs::make('$money($input)'))
                ->dehydrateStateUsing(fn(string|int $state) => (int)str_replace(',', '', $state))
                ->placeholder('Pendapatan Per Kapita'),
        ];
    }
}
