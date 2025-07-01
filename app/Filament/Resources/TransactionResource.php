<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Transaction;
use App\Models\TourPackage;
use App\Models\Destination;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;
    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Customer Info')
                ->schema([
                    TextInput::make('booking_code')->label('Booking Code')->required()->unique(ignoreRecord: true),
                    TextInput::make('customer_name')->required(),
                    TextInput::make('customer_email')->email()->required(),
                    TextInput::make('customer_phone')->required(),
                ])->columns(4),

            Section::make('Tour & Booking Info')
                ->schema([
                    Select::make('tour_package_id')
                        ->label('Tour Package')
                        ->searchable()
                        ->options(fn () => TourPackage::pluck('name', 'id'))
                        ->reactive()
                        ->afterStateUpdated(function ($state, Get $get, Set $set) {
                            if ($state) {
                                $package = TourPackage::find($state);
                                $price = $package?->price ?? 0;
                                $set('package_price', $price);
                                $set('total_price', $price * ($get('number_of_tickets') ?? 1));
                            }
                        }),

                    Select::make('destination_id')
                        ->label('Destination')
                        ->searchable()
                        ->options(fn () => Destination::pluck('name', 'id'))
                        ->reactive()
                        ->afterStateUpdated(function ($state, Get $get, Set $set) {
                            if ($state && !$get('tour_package_id')) {
                                $destination = Destination::find($state);
                                $price = $destination?->price ?? 0;
                                $set('package_price', $price);
                                $set('total_price', $price * ($get('number_of_tickets') ?? 1));
                            }
                        }),

                    TextInput::make('number_of_tickets')
                        ->numeric()
                        ->minValue(1)
                        ->default(1)
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(fn (Get $get, Set $set) => self::updateTotal($get, $set)),

                    TextInput::make('package_price')
                        ->label('Price per Ticket')
                        ->prefix('Rp')
                        ->numeric()
                        ->readOnly()
                        ->dehydrated(),
                ])->columns(4),

            Section::make('Pricing & Payment')
                ->schema([
                    TextInput::make('discount_amount')
                        ->prefix('Rp')
                        ->numeric()
                        ->default(0)
                        ->reactive()
                        ->afterStateUpdated(fn (Get $get, Set $set) => self::updateTotal($get, $set)),

                    TextInput::make('discount_percent')
                        ->suffix('%')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(100)
                        ->default(0)
                        ->reactive()
                        ->afterStateUpdated(fn (Get $get, Set $set) => self::updateTotal($get, $set)),

                    TextInput::make('total_price')
                        ->prefix('Rp')
                        ->numeric()
                        ->readOnly(),

                    Select::make('payment_method')
                        ->options([
                            'transfer' => 'Transfer',
                            'qris' => 'QRIS',
                            'cash' => 'Cash',
                            'pending' => 'Pending',
                        ])
                        ->default('pending')
                        ->nullable(),

                    Select::make('status')
                        ->required()
                        ->default('pending')
                        ->options([
                            'pending' => 'Pending',
                            'paid' => 'Paid',
                            'confirmed' => 'Confirmed',
                            'completed' => 'Completed',
                            'cancelled' => 'Cancelled',
                            'expired' => 'Expired',
                        ]),

                    DateTimePicker::make('booking_date')->label('Booking Date')->required(),
                    TextInput::make('special_request')
                        ->label('Special Request')
                        ->nullable(),
                ])->columns(3),
        ]);
    }

    protected static function updateTotal(Get $get, Set $set): void
    {
        $price = $get('package_price') ?? 0;
        $qty = $get('number_of_tickets') ?? 1;
        $discountAmount = $get('discount_amount') ?? 0;
        $discountPercent = $get('discount_percent') ?? 0;

        $subtotal = $price * $qty;
        $calculatedDiscount = $discountAmount > 0
            ? $discountAmount
            : ($discountPercent > 0 ? ($subtotal * ($discountPercent / 100)) : 0);

        $total = max($subtotal - $calculatedDiscount, 0);
        $set('total_price', $total);
    }

    public static function mutateFormDataBeforeCreate(array $data): array
    {
        $price = 0;
        if ($data['tour_package_id']) {
            $price = TourPackage::find($data['tour_package_id'])?->price ?? 0;
        } elseif ($data['destination_id']) {
            $price = Destination::find($data['destination_id'])?->price ?? 0;
        }

        $qty = $data['number_of_tickets'] ?? 1;
        $subtotal = $price * $qty;
        $discountAmount = $data['discount_amount'] ?? 0;
        $discountPercent = $data['discount_percent'] ?? 0;

        $calculatedDiscount = $discountAmount > 0
            ? $discountAmount
            : ($discountPercent > 0 ? ($subtotal * ($discountPercent / 100)) : 0);

        $data['package_price'] = $price;
        $data['total_price'] = max($subtotal - $calculatedDiscount, 0);

        return $data;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('booking_code')->searchable(),
                TextColumn::make('customer_name'),
                TextColumn::make('customer_email'),
                TextColumn::make('tourPackage.name')->label('Package')->default('N/A'),
                TextColumn::make('destination.name')->label('Destination')->default('N/A'),
                TextColumn::make('payment_method')->badge()->default('Pending'),
                TextColumn::make('status')->badge(),
                TextColumn::make('booking_date')->dateTime(),
                TextColumn::make('special_request')->limit(50)->default('N/A'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options([
                    'pending' => 'Pending',
                    'paid' => 'Paid',
                    'confirmed' => 'Confirmed',
                    'completed' => 'Completed',
                    'cancelled' => 'Cancelled',
                    'expired' => 'Expired',
                ]),
            ])
            ->actions([
                Tables\Actions\Action::make('confirm_payment')
                    ->label('Confirm')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->status === 'pending')
                    ->action(fn (Transaction $record) => $record->update(['status' => 'confirmed'])),

                Tables\Actions\Action::make('cancel_transaction')
                    ->label('Cancel')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->status === 'pending')
                    ->action(fn (Transaction $record) => $record->update(['status' => 'cancelled'])),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}