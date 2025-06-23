<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TourPackageVariantResource\Pages;
use App\Models\TourPackageVariant;
use App\Models\Hotel;
use App\Models\TourPackage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TourPackageVariantResource extends Resource
{
    protected static ?string $model = TourPackageVariant::class;

    protected static ?string $navigationGroup = 'Tour Management';

    // protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('tour_package_id')
                ->relationship('tourPackage', 'name')
                ->label('Tour Package')
                ->required()
                ->reactive(),

            Forms\Components\TextInput::make('label')
                ->label('Variant Label')
                ->required(),

            Forms\Components\Toggle::make('includes_hotel')
                ->label('Includes Hotel?')
                ->reactive(),

            Forms\Components\Select::make('hotel_id')
                ->label('Select Hotel')
                ->nullable()
                ->visible(fn (callable $get) => (bool) $get('includes_hotel'))
                ->options(function (callable $get) {
                    $tourPackageId = $get('tour_package_id');
                    if (!$tourPackageId) {
                        return [];
                    }

                    $tourPackage = TourPackage::find($tourPackageId);
                    if (!$tourPackage || !$tourPackage->location) {
                        return [];
                    }

                    // Split lokasi berdasarkan koma, &, dan kata 'dan' (case insensitive)
                    $rawKeywords = preg_split('/,|&|dan/i', $tourPackage->location);
                    $keywords = array_filter(array_map('trim', $rawKeywords));

                    return Hotel::where(function ($query) use ($keywords) {
                        foreach ($keywords as $keyword) {
                            $query->orWhere('location', 'like', "%{$keyword}%");
                        }
                    })->pluck('name', 'id')->toArray();
                }),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('tourPackage.name')
                ->label('Tour Package')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('label')
                ->label('Variant Label')
                ->sortable()
                ->searchable(),

            Tables\Columns\IconColumn::make('includes_hotel')
                ->label('Includes Hotel')
                ->boolean(),

            Tables\Columns\TextColumn::make('hotel.name')
                ->label('Hotel')
                ->sortable()
                ->searchable(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTourPackageVariants::route('/'),
            'create' => Pages\CreateTourPackageVariant::route('/create'),
            'edit' => Pages\EditTourPackageVariant::route('/{record}/edit'),
        ];
    }
}
