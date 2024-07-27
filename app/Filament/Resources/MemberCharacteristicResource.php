<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Support\RawJs;
use Filament\Forms\Components;
use Filament\Resources\Resource;
use App\Models\MemberCharacteristic;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MemberCharacteristicResource\Pages;
use App\Filament\Resources\MemberCharacteristicResource\RelationManagers;

class MemberCharacteristicResource extends Resource
{
    protected static ?string $model = MemberCharacteristic::class;

    protected static ?string $navigationIcon = 'heroicon-c-rectangle-group';

    protected static ?string $navigationLabel = 'Karateristik Anggota';

    protected static ?string $navigationGroup = 'Anggota';

    protected static ?string $breadcrumb = 'Karateristik Anggota';

    protected static ?string $modelLabel = 'Karateristik Anggota';

    protected static ?string $pluralModelLabel = 'Karateristik Anggota';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Components\Wizard::make([
                    Components\Wizard\Step::make('Data Pribadi')
                        ->schema([
                            Components\Fieldset::make('Identitas Diri')
                                ->columns(2)
                                ->schema([
                                    Components\TextInput::make('name')
                                        ->label('Nama Lengkap')
                                        ->placeholder('Nama Lengkap')
                                        ->required()
                                        ->autofocus(),
                                    Components\TextInput::make('identity_number')
                                        ->label('NIK')
                                        ->placeholder('Nomor Induk Kependudukan. 16 Digit')
                                        ->required()
                                        ->mask('9999999999999999'),
                                    Components\TextInput::make('place_of_birth')
                                        ->label('Tempat Lahir')
                                        ->placeholder('Tempat Lahir')
                                        ->required(),
                                    Components\DatePicker::make('date_of_birth')
                                        ->label('Tanggal Lahir')
                                        ->placeholder('Tanggal Lahir')
                                        ->required()
                                        ->live()
                                        ->suffix(function (?string $state = null) {
                                            // Show age
                                            if ($state) {
                                                $birthdate = Carbon::parse($state);
                                                $age = $birthdate->age;
                                                return "Umur: {$age} Tahun";
                                            }

                                            return '';
                                        }),

                                    Components\Grid::make(3)
                                        ->schema([
                                            Components\Textarea::make('address')
                                                ->label('Alamat')
                                                ->required()
                                                ->placeholder('Alamat Lengkap')
                                                ->rows(3)
                                                ->columnSpan(2),
                                            Components\Radio::make('gender')
                                                ->label('Jenis Kelamin')
                                                ->required()
                                                ->options([
                                                    'L' => 'Laki-Laki',
                                                    'P' => 'Perempuan',
                                                ]),
                                        ])
                                ]),
                            Components\Fieldset::make('Pekerjaan')
                                ->columns(2)
                                ->schema([
                                    Components\Select::make('source_of_income')
                                        ->label('Sumber Penghasilan')
                                        ->searchable()
                                        ->native(false)
                                        ->required()
                                        ->placeholder('Sumber Penghasilan')
                                        ->columnSpanFull()
                                        ->options([
                                            'SUAMI' => 'SUAMI',
                                            'GAJI' => 'GAJI',
                                            'PENSIUNAN' => 'PENSIUNAN',
                                            'ANAK' => 'ANAK',
                                            'USAHA' => 'USAHA',
                                        ]),
                                    Components\Select::make('work')
                                        ->label('Pekerjaan')
                                        ->options([
                                            'PEDAGANG' => 'PEDAGANG',
                                            'PEGAWAI NEGERI' => 'PEGAWAI NEGERI',
                                            'IBU RUMAH TANGGA' => 'IBU RUMAH TANGGA',
                                            'BURUH' => 'BURUH',
                                            'KARYAWAN' => 'KARYAWAN',
                                            'PETANI' => 'PETANI',
                                            'SUPIR' => 'SUPIR',
                                            'WIRASWASTA' => 'WIRASWASTA',
                                            'PENSIUNAN' => 'PENSIUNAN',
                                            'JASA' => 'JASA',
                                            'HOME INDUSTRI' => 'HOME INDUSTRI',
                                            'PELAJAR' => 'PELAJAR',
                                            'LAINNYA' => 'LAINNYA',
                                        ])
                                        ->searchable()
                                        ->native(false)
                                        ->required()
                                        ->placeholder('Pekerjaan'),
                                    Components\TextInput::make('work_description')
                                        ->label('Deskripsi Pekerjaan')
                                        ->required()
                                        ->placeholder('Eg. DAGANG IKAN BAKAR'),
                                ]),
                            Components\Fieldset::make('Orang Tua')
                                ->columns(2)
                                ->schema([
                                    Components\TextInput::make('mother_name')
                                        ->label('Nama Ibu Kandung')
                                        ->placeholder('Nama Ibu Kandung'),
                                    Components\TextInput::make('father_name')
                                        ->label('Nama Ayah Kandung')
                                        ->placeholder('Nama Ayah Kandung'),
                                ]),
                        ]),

                    Components\Wizard\Step::make('Simpanan')
                        ->schema([
                            Components\TextInput::make('savings')
                                ->label('Tabungan')
                                ->required()
                                ->Prefix('Rp')
                                ->mask(RawJs::make('$money($input)'))
                                ->placeholder('Tabungan')
                                ->default(0),
                        ]),

                    Components\Wizard\Step::make('Pengeluaran Rumah Tangga (Perbulan)')
                        ->schema([
                            Components\Grid::make(3)
                                ->schema([
                                    Components\TextInput::make('rice_consumption')
                                        ->numeric()
                                        ->suffix('Liter')
                                        ->label('Konsumsi Beras')
                                        ->placeholder('Konsumsi Beras per Bulan')
                                        ->required(),
                                    Components\TextInput::make('rice_price')
                                        ->numeric()
                                        ->mask(RawJs::make('$money($input)'))
                                        ->prefix('Rp')
                                        ->label('Harga Beras')
                                        ->placeholder('Harga Beras per Bulan')
                                        ->live(debounce: 1000)
                                        ->columnSpan(2)
                                        ->suffix(function (string|int|null $state = 0, Get $get, Set $set): string {
                                            $totalRicePrice = 0;
                                            $ricePrice = (int) str_replace(',', '', $state) ?? 0;
                                            $riceConsumption = (int) $get('rice_consumption') ?? 0;

                                            if (is_numeric($riceConsumption) && is_numeric($ricePrice))
                                                $totalRicePrice = $ricePrice * $riceConsumption;

                                            $set('total_rice_price', $totalRicePrice);

                                            // set total_expenses
                                            $totalExpenses = (int) str_replace(',', '', $get('total_expenses')) ?? 0;
                                            $totalExpenses += $totalRicePrice;

                                            $set('total_expenses', $totalExpenses);

                                            return "Total: Rp" . number_format($totalRicePrice, 0, ',', '.');
                                        }, true)
                                        ->required(),
                                    Components\Hidden::make('total_rice_price'),
                                ]),

                            Components\TextInput::make('kitchen_shop')
                                ->numeric()
                                ->mask(RawJs::make('$money($input)'))
                                ->prefix('Rp')
                                ->label('Belanja Dapur')
                                ->placeholder('Pengeluaran Belanja Dapur/Bulan')
                                ->live(debounce: 1000)
                                ->afterStateUpdated(function (string|int|null $state = 0, Get $get, Set $set) {
                                    $kitchenShop = (int) str_replace(',', '', $state);
                                    $totalExpenses = (int) str_replace(',', '', $get('total_expenses')) ?? 0;

                                    $totalExpenses += $kitchenShop;

                                    $set('total_expenses', $totalExpenses);
                                })
                                ->required(),
                            Components\TextInput::make('electricity_bills')
                                ->numeric()
                                ->mask(RawJs::make('$money($input)'))
                                ->prefix('Rp')
                                ->label('Rekening Listrik')
                                ->placeholder('Pengeluaran Listrik/Bulan')
                                ->live(debounce: 1000)
                                ->afterStateUpdated(function (string|int|null $state = 0, Get $get, Set $set) {
                                    $electricityBills = (int) str_replace(',', '', $state);
                                    $totalExpenses = (int) str_replace(',', '', $get('total_expenses')) ?? 0;

                                    $totalExpenses += $electricityBills;

                                    $set('total_expenses', $totalExpenses);
                                })
                                ->required(),
                            Components\TextInput::make('education')
                                ->numeric()
                                ->mask(RawJs::make('$money($input)'))
                                ->prefix('Rp')
                                ->label('Pendidikan')
                                ->placeholder('Pengeluaran Dana Pendidikan/Bulan')
                                ->live(debounce: 1000)
                                ->afterStateUpdated(function (string|int|null $state = 0, Get $get, Set $set) {
                                    $education = (int) str_replace(',', '', $state);
                                    $totalExpenses = (int) str_replace(',', '', $get('total_expenses')) ?? 0;

                                    $totalExpenses += $education;

                                    $set('total_expenses', $totalExpenses);
                                })
                                ->required(),
                            Components\TextInput::make('other_costs')
                                ->numeric()
                                ->mask(RawJs::make('$money($input)'))
                                ->prefix('Rp')
                                ->label('Lainnya')
                                ->placeholder('Pengeluaran Lainnya/Bulan')
                                ->live(debounce: 1000)
                                ->afterStateUpdated(function (string|int|null $state = 0, Get $get, Set $set) {
                                    $otherCosts = (int) str_replace(',', '', $state);
                                    $totalExpenses = (int) str_replace(',', '', $get('total_expenses')) ?? 0;

                                    $totalExpenses += $otherCosts;

                                    $set('total_expenses', $totalExpenses);
                                })
                                ->required(),

                            Components\TextInput::make('total_expenses')
                                ->numeric()
                                ->mask(RawJs::make('$money($input)'))
                                ->prefix('Rp')
                                ->label('Total Pengeluaran')
                                ->placeholder('Total Pengeluaran/Bulan')
                                ->readOnly()
                                ->default(0)
                                ->live(debounce: 1000)
                                ->columnSpanFull(),
                        ])
                        ->columns(2),

                    Components\Wizard\Step::make('Indeks Rumah')
                        ->columns(2)
                        ->schema([
                            Components\Select::make('house_status')
                                ->label('Status Rumah')
                                ->placeholder('Status Rumah')
                                ->required()
                                ->native(false)
                                ->live(debounce: 1000)
                                ->afterStateUpdated(function (string|null $state, Get $get, Set $set) {
                                    $totalHouseIndex = (int)$get('total_house_index') ?? 0;
                                    $houseStatus = $state ?? 0;

                                    if ($houseStatus === 'MILIK SENDIRI')
                                        $totalHouseIndex += 4;
                                    elseif ($houseStatus === 'SEWA')
                                        $totalHouseIndex += 2;

                                    $set('total_house_index', $totalHouseIndex);
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
                                ->afterStateUpdated(function (string|int|null $state = 0, Get $get, Set $set) {
                                    $totalHouseIndex = (int)$get('total_house_index') ?? 0;
                                    $houseArea = (int) $state ?? 0;

                                    if ($houseArea === 70)
                                        $totalHouseIndex += 4;
                                    elseif ($houseArea === 50)
                                        $totalHouseIndex += 2;

                                    $set('total_house_index', $totalHouseIndex);
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
                                ->afterStateUpdated(function (string|null $state, Get $get, Set $set) {
                                    $totalHouseIndex = (int)$get('total_house_index') ?? 0;
                                    $roofType = $state ?? 0;

                                    if ($roofType === 'GENTENG')
                                        $totalHouseIndex += 4;
                                    elseif ($roofType === 'SENG')
                                        $totalHouseIndex += 1;

                                    $set('total_house_index', $totalHouseIndex);
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
                                ->afterStateUpdated(function (string|null $state, Get $get, Set $set) {
                                    $totalHouseIndex = (int)$get('total_house_index') ?? 0;
                                    $houseWall = $state ?? 0;

                                    if ($houseWall === 'TEMBOK')
                                        $totalHouseIndex += 4;
                                    elseif ($houseWall === 'SEMI TEMBOK')
                                        $totalHouseIndex += 2;
                                    elseif ($houseWall === 'KAYU/PAPAN')
                                        $totalHouseIndex += 1;

                                    $set('total_house_index', $totalHouseIndex);
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
                                ->afterStateUpdated(function (string|null $state, Get $get, Set $set) {
                                    $totalHouseIndex = (int)$get('total_house_index') ?? 0;
                                    $houseFloor = $state ?? 0;

                                    if ($houseFloor === 'TEGEL')
                                        $totalHouseIndex += 4;
                                    elseif ($houseFloor === 'PLESTER SEMEN/CAMPURAN TRASO, KERAMIK, DLL')
                                        $totalHouseIndex += 2;
                                    elseif ($houseFloor === 'PAPAN/KAYU/BAMBU')
                                        $totalHouseIndex += 1;

                                    $set('total_house_index', $totalHouseIndex);
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
                                ->afterStateUpdated(function (string|null $state, Get $get, Set $set) {
                                    $totalHouseIndex = (int)$get('total_house_index') ?? 0;
                                    $typeOfLighting = $state ?? 0;

                                    if ($typeOfLighting === 'LISTRIK')
                                        $totalHouseIndex += 4;
                                    elseif ($typeOfLighting === 'PATROMAK')
                                        $totalHouseIndex += 2;

                                    $set('total_house_index', $totalHouseIndex);
                                })
                                ->options([
                                    'LISTRIK' => 'LISTRIK (4)',
                                    'PATROMAK' => 'SEMI TEMBOK (2)',
                                    'LAMPU MINYAK' => 'LAMPU MINYAK (0)',
                                ]),
                            Components\Select::make('latrine_type')
                                ->label('Jenis Jamban')
                                ->placeholder('Jenis Jamban')
                                ->required()
                                ->native(false)
                                ->live(debounce: 1000)
                                ->afterStateUpdated(function (string|null $state, Get $get, Set $set) {
                                    $totalHouseIndex = (int)$get('total_house_index') ?? 0;
                                    $latrineType = $state ?? 0;

                                    if ($latrineType === 'WC')
                                        $totalHouseIndex += 4;
                                    elseif ($latrineType === 'JAMBAN TERBUKA')
                                        $totalHouseIndex += 2;

                                    $set('total_house_index', $totalHouseIndex);
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
                                ->afterStateUpdated(function (string|null $state, Get $get, Set $set) {
                                    $totalHouseIndex = (int)$get('total_house_index') ?? 0;
                                    $sourceOfDrinkingWater = $state ?? 0;

                                    if ($sourceOfDrinkingWater === 'SUMUR SENDIRI')
                                        $totalHouseIndex += 4;
                                    elseif ($sourceOfDrinkingWater === 'SUMUR BERSAMA')
                                        $totalHouseIndex += 2;

                                    $set('total_house_index', $totalHouseIndex);
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
                        ])
                ])
                    ->skippable()
                    ->columnSpanFull()
                    ->id('karakteristik-anggota')
                    ->persistStepInQueryString()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMemberCharacteristics::route('/'),
            'create' => Pages\CreateMemberCharacteristic::route('/create'),
            'edit' => Pages\EditMemberCharacteristic::route('/{record}/edit'),
        ];
    }
}
