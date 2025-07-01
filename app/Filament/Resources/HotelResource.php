<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HotelResource\Pages;
use App\Models\Hotel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HotelResource extends Resource
{
    protected static ?string $model = Hotel::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationLabel = 'Hotels';
    protected static ?string $navigationGroup = 'Hotel Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Hotel Name'),

                Forms\Components\Textarea::make('address')
                    ->required()
                    ->label('Address'),

                Forms\Components\Textarea::make('description')
                    ->label('Description'),

                Forms\Components\Textarea::make('facilities')
                    ->label('Facilities'),

                Forms\Components\TextInput::make('location')
                    ->required()
                    ->label('Location'),
                    
                Forms\Components\Select::make('destinations')
                    ->label('Destinations')
                    ->multiple()
                    ->relationship('destinations', 'name')
                    ->preload(),
                    // ->required(),

                Forms\Components\TextInput::make('single_room_price')
                    ->label('Single Room Price')
                    ->prefix('Rp')
                    ->numeric()
                    ->required(),

                Forms\Components\TextInput::make('double_room_price')
                    ->label('Double Room Price')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),

                Forms\Components\TextInput::make('family_room_price')
                    ->label('Family Room Price')
                    ->numeric()
                    
                    ->required(),

                Forms\Components\TextInput::make('room_count_single')
                    ->label('Single Room Count')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(false)
                    ->reactive(false),

                Forms\Components\TextInput::make('room_count_double')
                    ->label('Double Room Count')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(false)
                    ->reactive(false),

                Forms\Components\TextInput::make('room_count_family')
                    ->label('Family Room Count')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(false)
                    ->reactive(false),

                Forms\Components\FileUpload::make('image')
                    ->label('Hotel Image')
                    ->image()
                    ->directory('hotels')
                    ->maxSize(2048)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Hotel Name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('address')
                    ->label('Address')
                    ->limit(30),

                Tables\Columns\TextColumn::make('location')
                    ->label('Location')
                    ->searchable(),

                Tables\Columns\TextColumn::make('single_room_price')
                    ->label('Single Room Price')
                    ->money('IDR'),

                Tables\Columns\TextColumn::make('double_room_price')
                    ->label('Double Room Price')
                    ->money('IDR'),

                Tables\Columns\TextColumn::make('family_room_price')
                    ->label('Family Room Price')
                    ->money('IDR'),

                Tables\Columns\TextColumn::make('room_count_single')
                    ->label('Single Rooms'),

                Tables\Columns\TextColumn::make('room_count_double')
                    ->label('Double Rooms'),

                Tables\Columns\TextColumn::make('room_count_family')
                    ->label('Family Rooms'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getNavigationBadge(): ?string
{
    return (string) static::getModel()::count();
}

public static function getNavigationBadgeColor(): string | array | null
{
    $count = static::getModel()::count();

    return match (true) {
        $count === 0        => 'gray',
        $count < 5          => 'warning',
        $count < 20         => 'success',
        default             => 'primary',
    };
}


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHotels::route('/'),
            'create' => Pages\CreateHotel::route('/create'),
            'edit' => Pages\EditHotel::route('/{record}/edit'),
        ];
    }
}
