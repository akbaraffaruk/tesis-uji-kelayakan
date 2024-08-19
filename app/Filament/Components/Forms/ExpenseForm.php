<?php

namespace App\Filament\Components\Forms;

use Filament\Forms\Components;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Support\RawJs;

class ExpenseForm
{
    private static array $fields = [
        'kitchen_shop',
        'electricity_bills',
        'education',
        'other_costs',
    ];

    private static function setCalculateTotalExpenses(Get $get, Set $set): void
    {
        $total = 0;

        $ricePrice = (int)str_replace(',', '', $get('total_rice_price') ?? 0);

        if (is_numeric($ricePrice))
            $total += $ricePrice;

        foreach (self::$fields as $field) {
            $total += (int)str_replace(',', '', $get($field) ?? 0);
        }

        $totalFormat = number_format($total, 0);

        $set('total_expenses', $totalFormat);
    }

    public static function renderForm(): array
    {
        return [
            Components\Grid::make(3)
                ->schema([
                    Components\TextInput::make('rice_consumption')
                        ->numeric()
                        ->suffix('Liter')
                        ->label('Konsumsi Beras')
                        ->placeholder('Konsumsi Beras per Bulan')
                        ->required(),
                    Components\TextInput::make('rice_price')
                        //                                        ->numeric()
                        ->mask(RawJs::make('$money($input)'))
                        ->dehydrateStateUsing(fn(string|int $state) => (int)str_replace(',', '', $state))
                        ->prefix('Rp')
                        ->label('Harga Beras')
                        ->placeholder('Harga Beras per Bulan')
                        ->live(debounce: 1000)
                        ->columnSpan(2)
                        ->suffix(function (Get $get, Set $set, string|int|null $state = 0): string {
                            $totalRicePrice = 0;
                            $ricePrice = (int)str_replace(',', '', $state) ?? 0;
                            $riceConsumption = (int)$get('rice_consumption') ?? 0;

                            if (is_numeric($ricePrice))
                                $totalRicePrice = $ricePrice * $riceConsumption;

                            $set('total_rice_price', $totalRicePrice);

                            self::setCalculateTotalExpenses($get, $set);

                            return "Total: Rp" . number_format($totalRicePrice, 0, ',', '.');
                        }, true)
                        ->required(),
                    Components\Hidden::make('total_rice_price')
                        ->dehydrated(false),
                ]),

            Components\TextInput::make('kitchen_shop')
                //                                ->numeric()
                ->mask(RawJs::make('$money($input)'))
                ->dehydrateStateUsing(fn(string|int $state) => (int)str_replace(',', '', $state))
                ->prefix('Rp')
                ->label('Belanja Dapur')
                ->placeholder('Pengeluaran Belanja Dapur/Bulan')
                ->live(debounce: 1000)
                ->afterStateUpdated(fn(Get $get, Set $set) => self::setCalculateTotalExpenses($get, $set))
                ->required(),
            Components\TextInput::make('electricity_bills')
                //                                ->numeric()
                ->mask(RawJs::make('$money($input)'))
                ->dehydrateStateUsing(fn(string|int $state) => (int)str_replace(',', '', $state))
                ->prefix('Rp')
                ->label('Rekening Listrik')
                ->placeholder('Pengeluaran Listrik/Bulan')
                ->live(debounce: 1000)
                ->afterStateUpdated(fn(Get $get, Set $set) => self::setCalculateTotalExpenses($get, $set))
                ->required(),
            Components\TextInput::make('education')
                //                                ->numeric()
                ->mask(RawJs::make('$money($input)'))
                ->dehydrateStateUsing(fn(string|int $state) => (int)str_replace(',', '', $state))
                ->prefix('Rp')
                ->label('Pendidikan')
                ->placeholder('Pengeluaran Dana Pendidikan/Bulan')
                ->live(debounce: 1000)
                ->afterStateUpdated(fn(Get $get, Set $set) => self::setCalculateTotalExpenses($get, $set))
                ->required(),
            Components\TextInput::make('other_costs')
                //                                ->numeric()
                ->mask(RawJs::make('$money($input)'))
                ->dehydrateStateUsing(fn(string|int $state) => (int)str_replace(',', '', $state))
                ->prefix('Rp')
                ->label('Lainnya')
                ->placeholder('Pengeluaran Lainnya/Bulan')
                ->live(debounce: 1000)
                ->afterStateUpdated(fn(Get $get, Set $set) => self::setCalculateTotalExpenses($get, $set))
                ->required(),

            Components\TextInput::make('total_expenses')
                //                                ->numeric()
                ->mask(RawJs::make('$money($input)'))
                ->dehydrateStateUsing(fn(string|int $state) => (int)str_replace(',', '', $state))
                ->prefix('Rp')
                ->label('Total Pengeluaran Bulanan')
                ->placeholder('Total Pengeluaran/Bulan')
                ->readOnly()
                ->default(0)
                ->live(debounce: 1000)
                ->columnSpanFull(),
        ];
    }
}
