<?php

namespace App\Filament\Resources;

use App\Models\Destination;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\Toggle;
use App\Filament\Resources\DestinationResource\Pages;

class DestinationResource extends Resource
{
    protected static ?string $model = Destination::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';
    protected static ?string $modelLabel = 'Destination';
    protected static ?string $pluralModelLabel = 'Destinations List';

    public static function form(Form $form): Form
    {
        return $form
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

                FileUpload::make('image')
                    ->label('Image')
                    ->image()
                    ->directory('destinations'),

                Select::make('category')
                    ->label('Category')
                    ->options([
                        'Beach' => 'Beach',
                        'Mountain' => 'Mountain',
                        'Culture' => 'Culture',     
                        'Nature' => 'Nature',
                    ])
                    ->required(),

                Toggle::make('is_popular')
                    ->label('Popular')
                    ->default(false),
                    
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
                ->falseIcon('heroicon-o-x-circle') // fallback icon
                ->colors([
                    'warning' => fn ($state) => $state,
                    'danger' => fn ($state) => !$state,
                ]),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDestinations::route('/'),
            'create' => Pages\CreateDestination::route('/create'),
            'edit' => Pages\EditDestination::route('/{record}/edit'),
        ];
    }
}
