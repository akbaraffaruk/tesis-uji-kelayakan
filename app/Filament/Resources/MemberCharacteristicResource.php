<?php

namespace App\Filament\Resources;

use App\Filament\Components\Forms\ExpenseForm;
use App\Filament\Components\Forms\FinancingDetailForm;
use App\Filament\Components\Forms\HouseIndexForm;
use App\Filament\Components\Forms\IncomePerCapitaForm;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Support\Enums\Alignment;
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
                Components\Tabs::make('karakteristik-anggota')
                    ->tabs([
                        Components\Tabs\Tab::make('Data Pribadi')
                            ->schema([
                                Components\Fieldset::make('Identitas Diri')
                                    ->columns(2)
                                    ->columnSpanFull()
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
                                            ->autocapitalize()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn(Set $set, ?string $state) => $set('place_of_birth', strtoupper($state)))
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
                                    ->columnSpanFull()
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
                                Components\Split::make([
                                    Components\Fieldset::make('Orang Tua')
                                        ->schema([
                                            Components\TextInput::make('mother_name')
                                                ->label('Nama Ibu Kandung')
                                                ->columnSpanFull()
                                                ->required()
                                                ->placeholder('Nama Ibu Kandung'),
                                        ]),
                                    Components\Fieldset::make('Status')
                                        ->schema([
                                            Components\Select::make('marital_status')
                                                ->label('Status Menikah')
                                                ->columnSpanFull()
                                                ->native(false)
                                                ->options([
                                                    'MENIKAH' => 'MENIKAH',
                                                    'CERAI' => 'CERAI',
                                                ])
                                                ->required()
                                                ->placeholder('Status Pernikahan'),
                                        ]),
                                ])
                            ]),

                        Components\Tabs\Tab::make('Simpanan')
                            ->schema([
                                Components\TextInput::make('savings')
                                    ->label('Tabungan')
                                    ->required()
                                    ->Prefix('Rp')
                                    ->mask(RawJs::make('$money($input)'))
                                    ->dehydrateStateUsing(fn(string|int $state) => (int)str_replace(',', '', $state))
                                    ->placeholder('Tabungan')
                                    ->default(0),
                            ]),

                        Components\Tabs\Tab::make('Pengeluaran Rumah Tangga (Perbulan)')
                            ->schema([
                                ...ExpenseForm::renderForm(),
                            ])
                            ->columns(2),

                        Components\Tabs\Tab::make('Indeks Rumah')
                            ->columns(2)
                            ->schema([
                                ...HouseIndexForm::renderForm(),
                            ]),

                        Components\Tabs\Tab::make('Pendapatan Perkapita')
                            ->columns(2)
                            ->schema([
                                ...IncomePerCapitaForm::renderForm(),
                            ]),

                        Components\Tabs\Tab::make('Detail Pembiayaan')
                            ->columns(2)
                            ->schema([
                                ...FinancingDetailForm::renderForm(),
                            ])
                    ])
                    ->columnSpanFull()
                    ->id('karakteristik-anggota')
                    ->persistTab()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('identity_number')
                    ->label('NIK')
                    ->alignment(Alignment::Center)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Lengkap')
                    ->alignment(Alignment::Center)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('address')
                    ->label('Alamat')
                    ->alignment(Alignment::Center)
                    ->wrap()
                    ->lineClamp(2),
                Tables\Columns\TextColumn::make('total_expenses')
                    ->label('Total Pengeluaran Bulanan')
                    ->wrapHeader()
                    ->prefix('Rp.')
                    ->alignment(Alignment::Center)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('income_per_capita')
                    ->label('Pendapatan Perkapita')
                    ->wrapHeader()
                    ->prefix('Rp.')
                    ->alignment(Alignment::Center)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tenor')
                    ->label('Tenor')
                    ->alignment(Alignment::Center)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pokok')
                    ->label('Pokok')
                    ->alignment(Alignment::Center)
                    ->prefix('Rp.')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
//                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
//                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
