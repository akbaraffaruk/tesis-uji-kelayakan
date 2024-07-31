<?php

namespace App\Filament\Components\Forms;

use Filament\Forms\Components;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Support\RawJs;

class FinancingDetailForm
{
    private static int $marginPercentage = 30; // 30%

    private static function setCalculateMarginAndInstallment(Get $get, Set $set): void
    {
        $installment = 0;

        $tenor = (int)str_replace(',', '', $get('tenor') ?? 0);
        $pokok = (int)str_replace(',', '', $get('pokok') ?? 0);

        if ($tenor > 0 && $pokok > 0)
            $installment = $pokok / $tenor;

        $margin = $pokok * self::$marginPercentage / 100;

        $marginFormat = number_format($margin, 0);
        $installmentFormat = number_format($installment, 0);

        $set('margin', $marginFormat);
        $set('installment', $installmentFormat);
    }

    public static function renderForm(): array
    {
        return [
            Components\Select::make('buyer')
                ->label('Digunakan Oleh?')
                ->required()
                ->placeholder('Pembiyaaan Digunakan Oleh?')
                ->native(false)
                ->columnSpanFull()
                ->options([
                    'SENDIRI' => 'SENDIRI',
                    'PASANGAN' => 'PASANGAN',
                ]),
            Components\TextInput::make('tenor')
                ->label('Tenor')
                ->required()
                ->numeric()
                ->columnSpanFull()
                ->datalist([
                    25, 50
                ])
                ->live(debounce: 1000)
                ->afterStateUpdated(fn(Get $get, Set $set) => self::setCalculateMarginAndInstallment($get, $set))
                ->placeholder('Tenor'),
            Components\TextInput::make('pokok')
                ->label('Pokok')
                ->required()
                ->Prefix('Rp')
                ->mask(RawJs::make('$money($input)'))
                ->dehydrateStateUsing(fn(string|int $state) => (int)str_replace(',', '', $state))
                ->live(debounce: 1000)
                ->afterStateUpdated(fn(Get $get, Set $set) => self::setCalculateMarginAndInstallment($get, $set))
                ->placeholder('Pokok'),
            Components\TextInput::make('margin')
                ->label('Margin (30%)')
                ->required()
                ->Prefix('Rp')
                ->readOnly()
                ->mask(RawJs::make('$money($input)'))
                ->dehydrateStateUsing(fn(string|int $state) => (int)str_replace(',', '', $state))
                ->placeholder('Margin'),
            Components\TextInput::make('installment')
                ->label('Angsuran')
                ->required()
                ->Prefix('Rp')
                ->readOnly()
                ->columnSpanFull()
                ->mask(RawJs::make('$money($input)'))
                ->dehydrateStateUsing(fn(string|int $state) => (int)str_replace(',', '', $state))
                ->placeholder('Angsuran'),
        ];
    }
}
