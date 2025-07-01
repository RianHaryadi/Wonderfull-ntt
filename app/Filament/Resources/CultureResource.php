<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CultureResource\Pages;
use App\Models\Culture;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CultureResource extends Resource
{
    protected static ?string $model = Culture::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Cultures';
    protected static ?string $modelLabel = 'Culture';
    protected static ?string $pluralModelLabel = 'Cultures';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Title')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('description_1')
                    ->label('Description (Part 1)')
                    ->rows(4)
                    ->required(),

                Forms\Components\Textarea::make('description_2')
                    ->label('Description (Part 2)')
                    ->rows(4)
                    ->nullable(),

                Forms\Components\TagsInput::make('tags')
                    ->label('Tags')
                    ->placeholder('e.g. Traditional, Ritual, Horseback')
                    ->required()
                    ->splitKeys([',']),

                Forms\Components\FileUpload::make('image')
                    ->label('Image')
                    ->image()
                    ->directory('culture'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TagsColumn::make('tags')
                    ->label('Tags')
                    ->limit(3),

                Tables\Columns\ImageColumn::make('image')
                    ->label('Image')
                    ->circular(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
        $count === 0        => 'gray',
        $count < 5          => 'warning',
        $count < 20         => 'success',
        default             => 'primary',
    };
}


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCultures::route('/'),
            'create' => Pages\CreateCulture::route('/create'),
            'edit' => Pages\EditCulture::route('/{record}/edit'),
        ];
    }
}
