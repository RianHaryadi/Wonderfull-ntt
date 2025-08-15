<?php

namespace App\Filament\Resources;

use App\Models\Destination;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use App\Filament\Resources\DestinationResource\Pages;
    
class DestinationResource extends Resource
{
    protected static ?string $model = Destination::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';
    protected static ?string $modelLabel = 'Destination';
    protected static ?string $pluralModelLabel = 'Destinations List';
    protected static ?string $navigationGroup = 'Tour Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Section untuk Informasi Dasar
                Section::make('Basic Information')
                    ->schema([
                        TextInput::make('name')
                            ->label('Destination Name')
                            ->required(),
                        Textarea::make('description')
                            ->label('Description')
                            ->rows(4),
                        TextInput::make('location')
                            ->label('Location')
                            ->required(),
                        Select::make('category')
                            ->label('Category')
                            ->options([
                                'Beach' => 'Beach',
                                'Mountain' => 'Mountain',
                                'Culture' => 'Culture',
                                'Nature' => 'Nature',
                            ])
                            ->required(),
                        TextInput::make('price')
                            ->label('Price')
                            ->numeric()
                            ->required()
                            ->default(0)
                            ->minValue(0),
                        Toggle::make('is_popular')
                            ->label('Popular')
                            ->default(false),
                    ])
                    ->columns(2),

                // Section untuk Lokasi dan Rating
                Section::make('Location & Rating')
                    ->schema([
                        TextInput::make('rating')
                            ->label('Rating')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(5)
                            ->nullable(),
                        TextInput::make('rating_count')
                            ->label('Count')
                            ->numeric()
                            ->minValue(0)
                            ->default(0),
                        TextInput::make('latitude')
                            ->label('Latitude')
                            ->numeric()
                            ->nullable(),
                        TextInput::make('longitude')
                            ->label('Longitude')
                            ->numeric()
                            ->nullable(),
                        TextInput::make('maps_url')
                            ->label('Maps URL')
                            ->url()
                            ->nullable(),
                    ])
                    ->columns(2),
                    // Section untuk Gambar
                Section::make('Image')
                    ->schema([
                        FileUpload::make('image')
                            ->label('Image')
                            ->image()
                            ->directory('destinations'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable(),
                TextColumn::make('location')
                    ->label('Location')
                    ->searchable(),
                TextColumn::make('category')
                    ->label('Category'),
                ImageColumn::make('image')
                    ->label('Image'),
                IconColumn::make('is_popular')
                    ->label('Popular')
                    ->icon('heroicon-o-star')
                    ->falseIcon('heroicon-o-x-circle')
                    ->colors([
                        'warning' => fn ($state) => $state,
                        'danger' => fn ($state) => !$state,
                    ]),
                TextColumn::make('rating')
                    ->label('Rating')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => $state ? number_format($state, 1) : '-'),
                TextColumn::make('rating_count')
                    ->label('Rating Count')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => $state ?? '-'),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListDestinations::route('/'),
            'create' => Pages\CreateDestination::route('/create'),
            'edit' => Pages\EditDestination::route('/{record}/edit'),
        ];
    }
}