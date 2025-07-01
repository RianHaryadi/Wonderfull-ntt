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
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Support\Str;

class TourPackageResource extends Resource
{
    protected static ?string $model = TourPackage::class;
    protected static ?string $navigationGroup = 'Tour Management';
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Main Information')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->label('Package Name')
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('price')
                        ->required()
                        ->numeric()
                        ->prefix('IDR')
                        ->label('Price'),

                    Forms\Components\TextInput::make('days')
                        ->required()
                        ->label('Duration')
                        ->placeholder('e.g., 3 or 3D2N'),

                    Forms\Components\TextInput::make('location')
                        ->required()
                        ->label('Location (e.g., Labuan Bajo, Flores)'),

                    Forms\Components\TextInput::make('category')
                        ->required()
                        ->label('Category (e.g., Adventure, Leisure)'),
                    
                    Forms\Components\TextInput::make('rating')
                        ->label('Rating (e.g. 4.5)')
                        ->numeric()
                        ->step(0.1)
                        ->minValue(0)
                        ->maxValue(5)
                        ->default(0),

                    Forms\Components\TextInput::make('rating_count')
                        ->label('Rating Count')
                        ->numeric()
                        ->integer()
                        ->default(0)
                        ->minValue(0),

                    Forms\Components\RichEditor::make('description')
                        ->required()
                        ->label('Description')
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Relations & Options')
                ->columns(2)
                ->schema([
                     Forms\Components\Select::make('destinations')
                        ->label('Destinations')
                        ->multiple()
                        ->relationship('destinations', 'name')
                        ->preload()
                        ->required(),
                ]),
            
            Forms\Components\Section::make('Media')
                ->collapsible()
                ->schema([
                    Forms\Components\FileUpload::make('thumbnail')
                        ->label('Thumbnail Image')
                        ->image()
                        ->imageEditor()
                        ->directory('tour-packages/thumbnails')
                        ->preserveFilenames()
                        ->maxSize(2048)
                        ->required(),
                        
                    Forms\Components\Repeater::make('photos')
                        ->label('Gallery Photos')
                        // PERUBAHAN: Baris ->relationship() dihapus dari sini karena 'photos' adalah array, bukan relasi.
                        ->schema([
                            Forms\Components\FileUpload::make('path')
                                ->label('Photo')
                                ->image()
                                ->imageEditor()
                                ->directory('tour-packages/photos')
                                ->preserveFilenames()
                                ->maxSize(2048)
                                ->required(),
                        ])
                        ->orderColumn('order')
                        ->addActionLabel('Add Photo')
                        ->reorderable()
                        ->defaultItems(0)
                        ->collapsible()
                ])
                ->columns(1),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')
                    ->label('Image')
                    ->square(),

                TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->description(fn (TourPackage $record): string => $record->location),

                TextColumn::make('price')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('days')
                    ->label('Duration')
                    ->sortable(),

                IconColumn::make('includes_hotel')
                    ->label('Hotel')
                    ->boolean(),

                TextColumn::make('rating')
                    ->label('Rating')
                    ->icon('heroicon-s-star')
                    ->sortable(),
                    
                TextColumn::make('category')
                    ->badge()
                    ->searchable(),
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

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string | array | null
    {
        $count = static::getModel()::count();
        return match (true) {
            $count === 0 => 'gray',
            $count < 5   => 'warning',
            $count < 20  => 'success',
            default      => 'primary',
        };
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