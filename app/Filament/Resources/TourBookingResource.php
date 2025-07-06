<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TourBookingResource\Pages;
use App\Models\TourBooking;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Tables\View\TablesRenderHook;

class TourBookingResource extends Resource
{
    protected static ?string $model = TourBooking::class;
    protected static ?string $navigationIcon = '';
    protected static ?string $navigationGroup = 'Tour Management';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\Section::make('Booking Info')
                ->schema([
                    Forms\Components\TextInput::make('booking_number')->disabled(),
                    Forms\Components\Select::make('tour_package_id')
                        ->relationship('tourPackage', 'name')
                        ->disabled(),
                    Forms\Components\Select::make('hotel_id')
                        ->relationship('hotel', 'name')
                        ->disabled()
                        ->nullable(),
                ]),

            Forms\Components\Section::make('Customer Info')
                ->schema([
                    Forms\Components\TextInput::make('customer_name')->disabled(),
                    Forms\Components\TextInput::make('customer_email')->disabled(),
                    Forms\Components\TextInput::make('customer_phone')->disabled(),
                ]),

            Forms\Components\Section::make('Payment Info')
                ->schema([
                    Forms\Components\TextInput::make('tour_price')->prefix('Rp')->disabled(),
                    Forms\Components\TextInput::make('hotel_price')->prefix('Rp')->disabled(),
                    Forms\Components\TextInput::make('total_price')->prefix('Rp')->disabled(),
                    Forms\Components\Select::make('payment_method')
                        ->options([
                            '' => 'Not Selected',
                            'transfer' => 'Bank Transfer',
                            'qris' => 'QRIS',
                            'cash' => 'Cash',
                        ])
                        ->nullable()
                        ->disabled(),
                    Forms\Components\Select::make('status')
                        ->options([
                            'pending' => 'Pending',
                            'confirmed' => 'Confirmed',
                            'completed' => 'Completed',
                            'cancelled' => 'Cancelled',
                        ])
                        ->required(),
                ]),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('booking_number')->searchable(),
            Tables\Columns\TextColumn::make('customer_name')->searchable(),
            Tables\Columns\TextColumn::make('tourPackage.name')->label('Tour'),
            Tables\Columns\TextColumn::make('payment_method')->label('Payment'),
            Tables\Columns\TextColumn::make('total_price')->money('IDR'),
            Tables\Columns\TextColumn::make('status')
                ->badge()
                ->color(fn ($state) => match ($state) {
                    'pending' => 'warning',
                    'confirmed' => 'primary',
                    'completed' => 'success',
                    'cancelled' => 'danger',
                    default => 'secondary',
                }),
        ])->filters([
            Tables\Filters\SelectFilter::make('status')
                ->options([
                    'pending' => 'Pending',
                    'confirmed' => 'Confirmed',
                    'completed' => 'Completed',
                    'cancelled' => 'Cancelled',
                ]),
        ])->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])->bulkActions([
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
            $count < 5 => 'warning',
            $count < 20 => 'success',
            default => 'primary',
        };
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTourBookings::route('/'),
            'create' => Pages\CreateTourBooking::route('/create'),
            'edit' => Pages\EditTourBooking::route('/{record}/edit'),
        ];
    }
}