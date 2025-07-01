<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PromotionResource\Pages\ListCodePromotion;
use App\Filament\Resources\PromotionResource\Pages\CreateCodePromotion;
use App\Filament\Resources\PromotionResource\Pages\EditCodePromotion;
use App\Models\CodePromotion;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class CodePromotionResource extends Resource
{
    protected static ?string $model = CodePromotion::class;
    protected static ?string $navigationIcon = 'heroicon-o-tag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->label('Promo Code'),

                Textarea::make('description')
                    ->label('Description')
                    ->nullable(),

                TextInput::make('discount_amount')
                    ->numeric()
                    ->label('Discount Amount')
                    ->nullable(),

                TextInput::make('discount_percent')
                    ->numeric()
                    ->label('Discount Percent (%)')
                    ->nullable(),

                DatePicker::make('valid_from')
                    ->label('Valid From')
                    ->nullable(),

                DatePicker::make('valid_until')
                    ->label('Valid Until')
                    ->nullable(),

                Toggle::make('active')
                    ->label('Active')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')->sortable()->searchable(),
                TextColumn::make('description')->limit(50),
                TextColumn::make('discount_percent')->suffix('%'),
                TextColumn::make('valid_from')->date(),
                TextColumn::make('valid_until')->date(),

                // --- UPDATED COLUMN ---
                // Menggunakan accessor 'is_currently_valid' untuk status yang akurat secara real-time
                IconColumn::make('is_currently_valid')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getNavigationBadge(): ?string
    {
        // --- UPDATED BADGE LOGIC ---
        // Menghitung hanya promosi yang benar-benar valid saat ini
        return (string) static::getModel()::currentlyValid()->count();
    }

    public static function getNavigationBadgeColor(): string | array | null
    {
        // --- UPDATED BADGE COLOR LOGIC ---
        // Warna badge sekarang didasarkan pada jumlah promosi yang valid
        $count = static::getModel()::currentlyValid()->count();

        if ($count == 0) {
            return 'gray';
        } elseif ($count < 5) {
            return 'warning';
        } else {
            return 'success';
        }
    }
    
    public static function getPages(): array
    {
        return [
            'index' => ListCodePromotion::route('/'),
            'create' => CreateCodePromotion::route('/create'),
            'edit' => EditCodePromotion::route('/{record}/edit'),
        ];
    }
}