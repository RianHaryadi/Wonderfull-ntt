<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Transaction;
use App\Models\TourPackage;
use App\Models\TourPackageVariant;
use App\Models\CodePromotion;
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
use App\Filament\Widgets\TotalRevenueCard;
use App\Filament\Widgets\MonthlyTransactionChart;
use App\Filament\Widgets\PaymentMethodPieChart;
use App\Models\Hotel;


class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;
    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('customer_name')
                ->label('Full Name')
                ->required(),

            TextInput::make('customer_email')
                ->label('Email')
                ->email()
                ->required(),

            TextInput::make('customer_phone')
                ->label('Phone Number')
                ->required(),

            Select::make('tour_package_id')
                ->label('Tour Package')
                ->options(fn () => TourPackage::pluck('name', 'id'))
                ->reactive()
                ->required()
                ->afterStateUpdated(function ($state, Set $set) {
                    // reset varian dan harga kalau ganti paket
                    $set('tour_package_variant_id', null);

                    $packagePrice = TourPackage::find($state)?->price ?? 0;
                    $set('base_price', $packagePrice);
                    $set('variant_price', 0);

                    $qty = 1;
                    $set('ticket_quantity', $qty);

                    $set('discount', 0);

                    $total = $packagePrice * $qty;
                    $set('total_price', $total);
                }),

            Select::make('tour_package_variant_id')
                ->label('Tour Package Variant')
                ->options(function (callable $get) {
                    $packageId = $get('tour_package_id');
                    if (!$packageId) return [];

                    // Gunakan label yang user-friendly
                    return TourPackageVariant::where('tour_package_id', $packageId)
                        ->pluck('label', 'id');
                })
                ->reactive()
                ->nullable()
                ->afterStateUpdated(function ($state, Set $set, Get $get) {
                    $variantPrice = 0;
                    $includesHotel = false;

                    if ($state) {
                        $variant = TourPackageVariant::find($state);
                        if ($variant) {
                            $variantPrice = $variant->price ?? 0;
                            $includesHotel = $variant->includes_hotel ?? false;
                            // kalau includes hotel, ambil harga hotelnya juga
                            if ($includesHotel && $variant->hotel) {
                                $variantPrice += $variant->hotel->price ?? 0;
                            }
                        }
                    }

                    
                    $set('variant_price', $variantPrice);

                    $basePrice = $get('base_price') ?? 0;
                    $qty = $get('ticket_quantity') ?? 1;
                    $discount = $get('discount') ?? 0;

                    $total = (($basePrice + $variantPrice) * $qty) - $discount;
                    $set('total_price', max($total, 0));
                }),

                Select::make('hotel_id')
                ->label('Select Hotel')
                ->nullable()
                ->reactive()
                ->visible(fn (callable $get) => (bool) $get('tour_package_variant_id') && TourPackageVariant::find($get('tour_package_variant_id'))?->includes_hotel)
                ->options(function (callable $get) {
                    $tourPackageId = $get('tour_package_id');
                    if (!$tourPackageId) {
                        return [];
                    }

                    $tourPackage = TourPackage::find($tourPackageId);
                    if (!$tourPackage || !$tourPackage->location) {
                        return [];
                    }

                    $keywords = array_map('trim', explode(',', $tourPackage->location));

                    return Hotel::where(function ($query) use ($keywords) {
                        foreach ($keywords as $keyword) {
                            $query->orWhere('location', 'like', "%{$keyword}%");
                        }
                    })->pluck('name', 'id')->toArray();
                }),

            Select::make('room_type')
                ->label('Room Type')
                ->nullable()
                ->reactive()
                ->visible(fn (callable $get) => (bool) $get('hotel_id'))
                ->options([
                    'single' => 'Single',
                    'double' => 'Double',
                    'family' => 'Family',
                ])
                ->afterStateUpdated(function ($state, Set $set, Get $get) {
                    $hotelId = $get('hotel_id');
                    $roomPrice = 0;

                    if ($hotelId && $state) {
                        $hotel = Hotel::find($hotelId);
                        if ($hotel) {
                            $roomPrice = match ($state) {
                                'single' => $hotel->single_room_price,
                                'double' => $hotel->double_room_price,
                                'family' => $hotel->family_room_price,
                                default => 0,
                            };
                        }
                    }

                    // Dapatkan harga varian dasar
                    $baseVariantPrice = 0;
                    $variantId = $get('tour_package_variant_id');
                    if ($variantId) {
                        $variant = TourPackageVariant::find($variantId);
                        if ($variant) {
                            $baseVariantPrice = $variant->price ?? 0;
                        }
                    }

                    $finalVariantPrice = $baseVariantPrice + $roomPrice;
                    $set('variant_price', $finalVariantPrice);

                    // Hitung ulang total harga
                    $basePrice = $get('base_price') ?? 0;
                    $qty = $get('ticket_quantity') ?? 1;
                    $discount = $get('discount') ?? 0;

                    $total = (($basePrice + $finalVariantPrice) * $qty) - $discount;
                    $set('total_price', max($total, 0));
                }),

        TextInput::make('ticket_quantity')
            ->label('Ticket Quantity')
            ->default(1)
            ->numeric()
            ->minValue(1)
            ->reactive()
            ->required()
            ->afterStateUpdated(function (Get $get, Set $set, $state) {
                $basePrice = $get('base_price') ?? 0;
                $variantPrice = $get('variant_price') ?? 0;
                $discount = $get('discount') ?? 0;

                $total = (($basePrice + $variantPrice) * $state) - $discount;
                $set('total_price', max($total, 0));
            }),
            
           Select::make('promo_code') // atau 'code' jika memang field-nya itu
                ->label('Promo Code')
                ->searchable()
                ->nullable()
                ->options(function () {
                    return CodePromotion::where('active', true)
                        ->whereDate('valid_from', '<=', now())
                        ->whereDate('valid_until', '>=', now())
                        ->pluck('code', 'code'); // kode = value dan label
                })
                ->reactive()
                ->afterStateUpdated(function ($state, Set $set, Get $get) {
                    $discount = 0;

                    $basePrice = $get('base_price') ?? 0;
                    $variantPrice = $get('variant_price') ?? 0;
                    $qty = $get('ticket_quantity') ?? 1;

                    if ($state) {
                        $promo = CodePromotion::where('code', $state)->first();

                        if ($promo && $promo->isValid()) {
                            $subtotal = ($basePrice + $variantPrice) * $qty;

                            if (!is_null($promo->discount_percent)) {
                                $discount = $subtotal * ($promo->discount_percent / 100);
                            } elseif (!is_null($promo->discount_amount)) {
                                $discount = $promo->discount_amount;
                            }
                        }
                    }

                    $set('discount', $discount);
                    $set('total_price', max((($basePrice + $variantPrice) * $qty) - $discount, 0));
                }),
                
            TextInput::make('base_price')
                ->label('Base Price')
                ->prefix('Rp')
                ->numeric()
                ->readOnly()
                ->dehydrated(),

            TextInput::make('variant_price')
                ->label('Variant Price')
                ->prefix('Rp')
                ->numeric()
                ->readOnly()
                ->dehydrated(),

            TextInput::make('discount')
                ->label('Discount')
                ->prefix('Rp')
                ->numeric()
                ->readOnly()
                ->dehydrated(),

            TextInput::make('total_price')
                ->label('Total Price')
                ->prefix('Rp')
                ->numeric()
                ->readOnly()
                ->dehydrated(),

            Select::make('payment_method')
                ->label('Payment Method')
                ->required()
                ->options([
                    'pending' => 'Pending',
                    'transfer' => 'Transfer',
                    'qris' => 'QRIS',
                    'cash' => 'Cash',
                ]),

            Select::make('status')
                ->label('Status')
                ->required()
                ->default('pending')
                ->options([
                    'pending' => 'Pending',
                    'confirmed' => 'Confirmed',
                    'cancelled' => 'Cancelled',
                ]),

            DateTimePicker::make('transaction_date')
                ->label('Transaction Date')
                ->default(now())
                ->nullable(),

        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('customer_name')->searchable(),
            TextColumn::make('customer_email'),
            TextColumn::make('tourPackage.name')->label('Tour Package'),
            TextColumn::make('tourPackage.price')->money('IDR')->label('Package Price'),
            TextColumn::make('tourPackageVariant.label')->label('Variant'),
            TextColumn::make('ticket_quantity')->label('Qty'),
            TextColumn::make('total_price')->money('IDR'),
            TextColumn::make('payment_method')
                ->badge()
                ->color(fn ($state) => match ($state) {
                    'pending' => 'gray',
                    'transfer' => 'success',
                    'qris' => 'warning',
                    'cash' => 'danger',
                    default => 'secondary',
                }),
            TextColumn::make('status')
                ->badge()
                ->color(fn ($state) => match ($state) {
                    'pending' => 'gray',
                    'confirmed' => 'success',
                    'cancelled' => 'danger',
                    default => 'secondary',
                }),
            TextColumn::make('transaction_date')->dateTime(),
        ])->filters([
            Tables\Filters\SelectFilter::make('status')
                ->label('Status')
                ->options([
                    'pending' => 'Pending',
                    'confirmed' => 'Confirmed',
                    'cancelled' => 'Cancelled',
                ]),
        ])->actions([
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
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }

    
    

    // Override before save to re-check total price calculation (optional)
    public static function mutateFormDataBeforeCreate(array $data): array
    {
        $package = TourPackage::find($data['tour_package_id']);
        $variant = null;
        $variantPrice = 0;

        if (!empty($data['tour_package_variant_id'])) {
            $variant = TourPackageVariant::find($data['tour_package_variant_id']);
            if ($variant) {
                $variantPrice = $variant->price ?? 0;
                if ($variant->includes_hotel && $variant->hotel) {
                    $variantPrice += $variant->hotel->price ?? 0;
                }
            }
        }

        $basePrice = $package->price ?? 0;
        $qty = $data['ticket_quantity'] ?? 1;

        $discount = 0;
        if (!empty($data['promo_code'])) {
            $promo = CodePromotion::where('code', $data['promo_code'])
                ->where('is_active', true)
                ->first();
            if ($promo) {
                $subtotal = ($basePrice + $variantPrice) * $qty;
                if ($promo->discount_type === 'percentage') {
                    $discount = $subtotal * ($promo->discount_amount / 100);
                } else {
                    $discount = $promo->discount_amount;
                }
            }
        }
        $hotel = \App\Models\Hotel::find($data['hotel_id'] ?? null);
        $roomPrice = 0;

        if ($hotel && isset($data['room_type'])) {
            $roomPrice = match ($data['room_type']) {
                'single' => $hotel->single_room_price,
                'double' => $hotel->double_room_price,
                'family' => $hotel->family_room_price,
                default => 0,
            };
        }

        $data['total_price'] = (($data['base_price'] ?? 0) + ($data['variant_price'] ?? 0) + $roomPrice) * ($data['ticket_quantity'] ?? 1) - ($data['discount'] ?? 0);


        $totalPrice = max((($basePrice + $variantPrice) * $qty) - $discount, 0);

        $data['base_price'] = $basePrice;
        $data['variant_price'] = $variantPrice;
        $data['discount'] = $discount;
        $data['total_price'] = $totalPrice;

        return $data;
    }
}
