<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TourPackageResource\Pages;
use App\Models\TourPackage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class TourPackageResource extends Resource
{
    protected static ?string $model = TourPackage::class;
    protected static ?string $navigationGroup = 'Tour Management';
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->label('Package Name'),

            Forms\Components\Select::make('destinations')
                ->label('Destinations')
                ->multiple()
                ->relationship('destinations', 'name')
                ->preload()
                ->required(),

            Forms\Components\TextInput::make('price')
                ->required()
                ->numeric()
                ->prefix('IDR')
                ->label('Price'),

            Forms\Components\Textarea::make('description')
                ->required()
                ->label('Description'),

            Forms\Components\TextInput::make('location')
                ->required()
                ->label('Location'),

            Forms\Components\TextInput::make('category')
                ->required()
                ->label('Category'),

            Forms\Components\FileUpload::make('thumbnail')
                ->label('Thumbnail')
                ->image()
                ->imageEditor()
                ->directory('tour-packages/thumbnails')
                ->preserveFilenames()
                ->maxSize(2048),
                
             Forms\Components\Repeater::make('photos')
                ->label('Photos')
                ->schema([
                    Forms\Components\FileUpload::make('path')
                        ->label('Photo')
                        ->image()
                        ->imageEditor()
                        ->directory('tour-packages/photos')
                        ->preserveFilenames()
                        ->maxSize(2048) // 2MB
                        ->acceptedFileTypes(['image/*'])
                        ->required(),
                ])
                ->orderColumn('order')
                ->addActionLabel('Add Photo')
                ->reorderable()
                ->defaultItems(0)
                ->collapsible()
                ->itemLabel(function (array $state): ?string {
    $path = $state['path'] ?? null;

    if (is_array($path)) {
        $path = $path[0] ?? null;
    }

    return is_string($path) ? basename($path) : 'Photo';
})

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('price')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('location'),

                TextColumn::make('category'),

                TextColumn::make('description')
                    ->limit(30),
            ])
            ->filters([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTourPackages::route('/'),
            'create' => Pages\CreateTourPackage::route('/create'),
            'edit' => Pages\EditTourPackage::route('/{record}/edit'),
        ];
    }
}
