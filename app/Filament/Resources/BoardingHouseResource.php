<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BoardingHouseResource\Pages;
use App\Filament\Resources\BoardingHouseResource\RelationManagers;
use App\Models\BoardingHouse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Str;

class BoardingHouseResource extends Resource
{
    protected static ?string $model = BoardingHouse::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';

    protected static ?string $navigationGroup = 'Manajemen Kos'; 

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Tabs')
            ->tabs([
                Forms\Components\Tabs\Tab::make('Informasi Umum')
                    ->schema([
                        Forms\Components\FileUpload::make('thumbnail')
                    ->image()
                    ->directory('boarding_house')
                    ->required(),
                        Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->debounce(500)
                    ->reactive()
                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, $state) {
                        $set('slug', \Str::slug($state));
                    }),
                Forms\Components\TextInput::make('slug')
                    ->required(),
                Forms\Components\Select::make('city_id')
                    ->relationship('city', 'name')
                    ->required(),
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->required(),
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->prefix('IDR')
                    ->required(),
                Forms\Components\TextInput::make('address')
                    ->required(),
                    ]),
                Forms\Components\Tabs\Tab::make('Bonus Nginap Sini')
                    ->schema([
                    Forms\Components\Repeater::make('bonuses')
                    ->relationship('bonuses')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->directory('bonuses')
                            ->required(),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('description')
                            ->required(),
                    ])
                ]),
                Forms\Components\Tabs\Tab::make('Kamar')
                    ->schema([
                        Forms\Components\Repeater::make('rooms')
                        ->relationship('rooms')
                        ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('room_type')
                            ->required(),
                        Forms\Components\TextInput::make('square_feet')
                            ->required(),
                        Forms\Components\TextInput::make('capacity')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('price_per_month')
                            ->required()
                            ->numeric()
                            ->prefix('IDR'),
                        Forms\Components\Toggle::make('is_available')
                            ->required(),
                        Forms\Components\Repeater::make('images')
                        ->relationship('images')
                        ->schema([
                            Forms\Components\FileUpload::make('image')
                            ->image()
                            ->directory('rooms')
                            ->required(),
                        ])
                    ])
                        ]),
            ])->columnSpan(2)
]); 
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('city.name'),
                Tables\Columns\TextColumn::make('category.name'),
                Tables\Columns\ImageColumn::make('thumbnail'),
                Tables\Columns\TextColumn::make('price')->money('idr', true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListBoardingHouses::route('/'),
            'create' => Pages\CreateBoardingHouse::route('/create'),
            'edit' => Pages\EditBoardingHouse::route('/{record}/edit'),
        ];
    }
}
