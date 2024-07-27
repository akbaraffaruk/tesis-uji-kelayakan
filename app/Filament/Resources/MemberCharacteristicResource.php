<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MemberCharacteristicResource\Pages;
use App\Filament\Resources\MemberCharacteristicResource\RelationManagers;
use App\Models\MemberCharacteristic;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                Components\Tabs::make('Karakter')
                    ->columnSpanFull()
                    ->id('karakteristik-anggota')
                    ->persistTab()
                    ->tabs([
                        Components\Tabs\Tab::make('Data Pribadi')
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
                                        Components\Textarea::make('address')
                                            ->label('Alamat')
                                            ->required()
                                            ->placeholder('Alamat Lengkap')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                    ]),
                                Components\Fieldset::make('Pekerjaan')
                                    ->columns(2)
                                    ->schema([
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
                                            ->label('Nama Ibu')
                                            ->placeholder('Nama Ibu'),
                                        Components\TextInput::make('father_name')
                                            ->label('Nama Ayah')
                                            ->placeholder('Nama Ayah'),
                                    ]),
                            ]),
                        Components\Tabs\Tab::make('Pengeluaran')
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
                                    ->required(),
                                Components\TextInput::make('kitchen_shop')
                                    ->numeric()
                                    ->mask(RawJs::make('$money($input)'))
                                    ->prefix('Rp')
                                    ->label('Belanja Dapur')
                                    ->placeholder('Pengeluaran Belanja Dapur/Bulan')
                                    ->required(),
                                Components\TextInput::make('electricity_bills')
                                    ->numeric()
                                    ->mask(RawJs::make('$money($input)'))
                                    ->prefix('Rp')
                                    ->label('Rekening Listrik')
                                    ->placeholder('Pengeluaran Listrik/Bulan')
                                    ->required(),
                                Components\TextInput::make('education')
                                    ->numeric()
                                    ->mask(RawJs::make('$money($input)'))
                                    ->prefix('Rp')
                                    ->label('Pendidikan')
                                    ->placeholder('Pengeluaran Dana Pendidikan/Bulan')
                                    ->required(),
                                Components\TextInput::make('other_costs')
                                    ->numeric()
                                    ->mask(RawJs::make('$money($input)'))
                                    ->prefix('Rp')
                                    ->label('Lainnya')
                                    ->placeholder('Pengeluaran Lainnya/Bulan')
                                    ->required(),
                            ])
                            ->columns(2)
                            ->visibleOn('edit'),
                    ])
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
