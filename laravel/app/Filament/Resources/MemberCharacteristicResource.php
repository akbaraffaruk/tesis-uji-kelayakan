<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MemberCharacteristicResource\Pages;
use App\Filament\Resources\MemberCharacteristicResource\RelationManagers;
use App\Models\MemberCharacteristic;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components;
use Filament\Resources\Resource;
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
                Components\Section::make()
                    ->schema([
                        Components\Tabs::make('Karakter')
                            ->tabs([
                                Components\Tabs\Tab::make('Data Diri')
                                    ->schema([
                                        Components\Fieldset::make('Identitas')
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
                                                    ->required(),
                                                Components\Textarea::make('address')
                                                    ->label('Alamat')
                                                    ->required()
                                                    ->placeholder('Alamat Lengkap')
                                                    ->rows(3)
                                                    ->columnSpanFull(),
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
                                        Components\TextInput::make('nama')
                                    ])
                                    ->columns(2)
                                    ->visibleOn('edit'),
                            ])
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
