<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingHotelResource\Pages;
use App\Models\BookingHotel;
use App\Models\Hotel;
use App\Models\CodePromotion;
use App\Models\HotelRoom;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Carbon\Carbon;
use Filament\Forms\Set;

class BookingHotelResource extends Resource
{
    protected static ?string $model = BookingHotel::class;
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Bookings';
    protected static ?string $navigationGroup = 'Hotel Management';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                // Nama customer
                Forms\Components\TextInput::make('customer_name')
                    ->label('Customer Name')
                    ->required(),

                // Email customer
                Forms\Components\TextInput::make('customer_email')
                    ->label('Customer Email')
                    ->required(),

                // Nomor telepon customer
                Forms\Components\TextInput::make('customer_phone')
                    ->label('Customer Phone')
                    ->required(),

                            // Pilih hotel
            Forms\Components\Select::make('hotel_id')
                ->label('Hotel')
                ->options(Hotel::all()->pluck('name', 'id'))
                ->required()
                ->reactive()
                ->afterStateUpdated(function (callable $set) {
                    // Reset harga dan total saat hotel berganti
                    $set('room_price', null);
                    $set('tax', null);
                    $set('service_charge', null);
                    $set('total_price', null);
                    $set('room_type', null); // Reset pilihan tipe kamar juga
                }),

            // Pilihan tipe kamar
            Forms\Components\Select::make('room_type')
                ->label('Room Type')
                ->options(function ($get) {
                    $hotel = Hotel::find($get('hotel_id'));
                    if (!$hotel) {
                        return [];
                    }

                    $pendingSingle = \App\Models\BookingHotel::where('hotel_id', $hotel->id)
                        ->where('room_type', 'single')
                        ->whereIn('status', ['pending', 'checked-in'])
                        ->count();
                    $pendingDouble = \App\Models\BookingHotel::where('hotel_id', $hotel->id)
                        ->where('room_type', 'double')
                        ->whereIn('status', ['pending', 'checked-in'])
                        ->count();
                    $pendingFamily = \App\Models\BookingHotel::where('hotel_id', $hotel->id)
                        ->where('room_type', 'family')
                        ->whereIn('status', ['pending', 'checked-in'])
                        ->count();

                    $sisaSingle = $hotel->room_count_single - $pendingSingle;
                    $sisaDouble = $hotel->room_count_double - $pendingDouble;
                    $sisaFamily = $hotel->room_count_family - $pendingFamily;

                    return [
                        'single' => 'Single (' . max($sisaSingle, 0) . ' tersedia)' . ($sisaSingle <= 0 ? ' - Penuh' : ''),
                        'double' => 'Double (' . max($sisaDouble, 0) . ' tersedia)' . ($sisaDouble <= 0 ? ' - Penuh' : ''),
                        'family' => 'Family (' . max($sisaFamily, 0) . ' tersedia)' . ($sisaFamily <= 0 ? ' - Penuh' : ''),
                    ];
                })
                ->required()
                ->reactive()
                ->afterStateUpdated(function (callable $set, $state, Get $get) {
                    $hotel = Hotel::find($get('hotel_id'));
                    $roomPrice = 0;

                    if ($hotel) {
                        switch ($state) {
                            case 'single':
                                $roomPrice = $hotel->single_room_price;
                                break;
                            case 'double':
                                $roomPrice = $hotel->double_room_price;
                                break;
                            case 'family':
                                $roomPrice = $hotel->family_room_price;
                                break;
                        }

                        $tax = $roomPrice * 0.1;
                        $serviceCharge = $roomPrice * 0.05;

                        $set('room_price', $roomPrice);
                        $set('tax', $tax);
                        $set('service_charge', $serviceCharge);
                        $set('total_price', $roomPrice + $tax + $serviceCharge);
                    }
                }),

            // Harga kamar
            Forms\Components\TextInput::make('room_price')
                ->label('Room Price')
                ->prefix('Rp')
                ->disabled()
                ->dehydrated(true)
                ->numeric(),

                Forms\Components\DatePicker::make('check_in_date')
                    ->label('Check-in Date')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, $state, Get $get) {
                        // Pastikan $checkInDate adalah objek Carbon
                        $checkInDate = Carbon::parse($state); // Mengubah string menjadi objek Carbon
                        $checkOutDate = $get('check_out_date') ? Carbon::parse($get('check_out_date')) : null;

                        if ($checkInDate && $checkOutDate) {
                            $nightCount = max(1, $checkInDate->diffInDays($checkOutDate));
                            $set('night_count', $nightCount);
                            $roomPrice = $get('room_price');
                            $tax = $get('tax'); // Ambil nilai pajak dari form
                            $serviceCharge = $get('service_charge'); // Ambil nilai biaya layanan dari form

                            // Perhitungan total harga berdasarkan jumlah malam, pajak, dan biaya layanan
                            $totalPrice = ($roomPrice * $nightCount) + $tax + $serviceCharge;
                            $set('total_price', $totalPrice);
                        }
                    }),

                Forms\Components\DatePicker::make('check_out_date')
                    ->label('Check-out Date')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, $state, Get $get) {
                        // Pastikan $checkOutDate adalah objek Carbon
                        $checkInDate = $get('check_in_date') ? Carbon::parse($get('check_in_date')) : null;
                        $checkOutDate = Carbon::parse($state); // Mengubah string menjadi objek Carbon

                        if ($checkInDate && $checkOutDate) {
                           $nightCount = max(1, $checkInDate->diffInDays($checkOutDate));
                            $set('night_count', $nightCount);
                            $roomPrice = $get('room_price');
                            $tax = $get('tax'); // Ambil nilai pajak dari form
                            $serviceCharge = $get('service_charge'); // Ambil nilai biaya layanan dari form

                            // Perhitungan total harga berdasarkan jumlah malam, pajak, dan biaya layanan
                            $totalPrice = ($roomPrice * $nightCount) + $tax + $serviceCharge;
                            $set('total_price', $totalPrice);
                        }
                    }),

                // Jumlah malam
                Forms\Components\TextInput::make('night_count')
                    ->label('Night Count')
                    ->dehydrated(true)
                    ->disabled(),

                // Pilihan kode promo
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

                // Status booking
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'checked-in' => 'Checked-in',
                        'checked-out' => 'Checked-out',
                        'failed' => 'Failed',
                    ])

                    ->default('pending')
                    ->required(),

                // Payment Method
                Forms\Components\Select::make('payment_method')
                    ->label('Payment Method')
                    ->options([
                        'transfer' => 'Transfer',
                        'qris' => 'QRIS',
                        'cash' => 'Cash',
                    ])
                    ->nullable()
                    ->required(),

                // Pajak
                Forms\Components\TextInput::make('tax')
                    ->label('Tax')
                    ->disabled()
                    ->dehydrated(true)
                    ->numeric(),

                // Biaya Layanan
                Forms\Components\TextInput::make('service_charge')
                    ->label('Service Charge')
                    ->disabled()
                    ->dehydrated(true)
                    ->numeric(),

                // Total Price
                Forms\Components\TextInput::make('total_price')
                    ->label('Total Price')
                    ->disabled()
                    ->dehydrated(true)
                    ->numeric(),

                // Nomor booking
                Forms\Components\TextInput::make('booking_number')
                    ->label('Booking Number')
                    ->required()
                    ->disabled()
                    ->dehydrated(true)
                    ->default(function () {
                        return 'BOOK-' . now()->format('Ymd') . '-' . str_pad(BookingHotel::count() + 1, 4, '0', STR_PAD_LEFT);
                    }),
            ]);
    }

   public static function table(Tables\Table $table): Tables\Table
{
    return $table
        ->columns([
            // Menambahkan kolom customer_name
            Tables\Columns\TextColumn::make('customer_name')
                ->label('Customer Name')
                ->sortable()
                ->searchable(),

            // Menambahkan kolom customer_email
            Tables\Columns\TextColumn::make('customer_email')
                ->label('Customer Email')
                ->sortable()
                ->searchable(),

            // Menambahkan kolom customer_phone
            Tables\Columns\TextColumn::make('customer_phone')
                ->label('Customer Phone')
                ->sortable(),

            // Menambahkan kolom night_count
            Tables\Columns\TextColumn::make('night_count')
                ->label('Night Count')
                ->sortable(),

            // Menambahkan kolom booking_number
            Tables\Columns\TextColumn::make('booking_number')
                ->searchable()            
                ->label('Booking Number')
                ->sortable(),
                
            Tables\Columns\TextColumn::make('room_type')
                ->label('Room Type')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('check_in_date')
                ->label('Check-in Date')
                ->date('d/m/Y')
                ->sortable(),

            Tables\Columns\TextColumn::make('check_out_date')
                ->label('Check-out Date')
                ->date('d/m/Y')
                ->sortable(),

            Tables\Columns\TextColumn::make('status')
                ->label('Status')
                ->formatStateUsing(function ($state) {
                    return match ($state) {
                        'pending' => 'Pending',
                        'checked-in' => 'Checked-in',
                        'checked-out' => 'Checked-out',
                        'failed' => 'Failed',
                        default => 'Unknown',
                    };
                })
                ->badge(function ($state) {
                    return match ($state) {
                        'pending' => 'warning',
                        'checked-in' => 'success',
                        'checked-out' => 'primary',
                        'failed' => 'danger',
                        default => 'secondary',
                    };
                })
                ->sortable(),

            Tables\Columns\TextColumn::make('payment_method')
                ->label('Payment Method')
                ->formatStateUsing(function ($state) {
                    return match ($state) {
                        'pending' => 'Pending',
                        'transfer' => 'Transfer',
                        'qris' => 'QRIS',
                        'cash' => 'Cash',
                        default => 'Unknown',
                    };
                })
                ->badge(function ($state) {
                    return match ($state) {
                        'pending' => 'warning',
                        'transfer' => 'info',
                        'qris' => 'success',
                        'cash' => 'primary',
                        default => 'secondary',
                    };
                })
                ->sortable(),

            Tables\Columns\TextColumn::make('total_price')
                ->label('Total Price')
                ->money('IDR') // Menggunakan IDR untuk mata uang Indonesia
        ])
        ->filters([
            //
        ])
        ->actions([
            
            Action::make('approve')
            ->label('Approve')
            ->icon('heroicon-m-check-circle')
            ->color('success')
            ->visible(fn ($record) => $record->status === 'pending')
            ->action(function ($record) {
                $roomType = $record->room_type;
                $hotel = $record->hotel;

                // Hitung booking aktif
                $pendingCount = \App\Models\BookingHotel::where('hotel_id', $hotel->id)
                    ->where('room_type', $roomType)
                    ->whereIn('status', ['pending', 'checked-in'])
                    ->count();

                $roomCount = match ($roomType) {
                    'single' => $hotel->room_count_single,
                    'double' => $hotel->room_count_double,
                    'family' => $hotel->room_count_family,
                    default => 0,
                };

                if ($pendingCount >= $roomCount) {
                    \Filament\Notifications\Notification::make()
                        ->title('Kamar tipe ini sudah penuh!')
                        ->danger()
                        ->send();
                    return;
                }

                // Lanjutkan logic approve booking di bawah ini
                $record->status = 'checked-in';
                $record->save();
                
                if ($roomType === 'single') {
                    $hotel->decrement('room_count_single');
                } elseif ($roomType === 'double') {
                    $hotel->decrement('room_count_double');
                } elseif ($roomType === 'family') {
                    $hotel->decrement('room_count_family');
                }
                $hotel->save();

                $roomNumber = \App\Models\HotelRoom::generateRoomNumber($roomType);

                \App\Models\HotelRoom::create([
                    'booking_number' => $record->booking_number,
                    'customer_name' => $record->customer_name,
                    'room_type' => $record->room_type,
                    'room_number' => $roomNumber,
                    'status' => 'not available',
                    'booking_hotel_id' => $record->id,
                ]);
            })
            ->requiresConfirmation()
            ->successNotificationTitle('Booking approved!'),

            Action::make('fail')
                ->label('Fail')
                ->icon('heroicon-m-x-circle')
                ->color('danger')
                ->visible(fn ($record) => $record->status === 'pending') // Tampil hanya jika status pending
                ->action(function ($record) {
                    $record->status = 'failed';
                    $record->save();

                    // Menambah jumlah kamar yang tersedia berdasarkan tipe yang dipilih
                    $roomType = $record->room_type; // single, double, family
                    $hotel = $record->hotel; // Relasi ke hotel

                    if ($roomType === 'single') {
                        $hotel->decrement('room_count_single');
                    } elseif ($roomType === 'double') {
                        $hotel->decrement('room_count_double');
                    } elseif ($roomType === 'family') {
                        $hotel->decrement('room_count_family');
                    }

                    // Mengupdate status kamar yang sebelumnya digunakan untuk booking
                    $hotelRoom = HotelRoom::where('booking_number', $record->booking_number)->first();
                    if ($hotelRoom) {
                        $hotelRoom->status = 'available';
                        $hotelRoom->save();
                    }
                })
                ->requiresConfirmation()
                ->successNotificationTitle('Booking failed!'),
                Action::make('checkout')
    ->label('Check Out')
    ->icon('heroicon-m-arrow-right-on-rectangle')
    ->color('primary')
    ->visible(fn ($record) => $record->status === 'checked-in')
    ->action(function ($record) {
        $record->status = 'checked-out';
        $record->save();

        $roomType = $record->room_type;
        $hotel = $record->hotel;

        // Tambah kembali kuota kamar sesuai tipe
        if ($roomType === 'single') {
            $hotel->increment('room_count_single');
        } elseif ($roomType === 'double') {
            $hotel->increment('room_count_double');
        } elseif ($roomType === 'family') {
            $hotel->increment('room_count_family');
        }
        $hotel->save();

        // Update status kamar menjadi available
        $hotelRoom = \App\Models\HotelRoom::where('booking_number', $record->booking_number)->first();
        if ($hotelRoom) {
            $hotelRoom->status = 'available';
            $hotelRoom->save();
        }
    })
    ->requiresConfirmation()
      ->successNotificationTitle('Booking checked out!')
        ],
        )
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make()
                ->label('Delete All')
                ->requiresConfirmation()
                ->deselectRecordsAfterCompletion()
                ->successNotificationTitle('All selected bookings deleted!'),
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
            'index' => Pages\ListBookingHotels::route('/'),
            'create' => Pages\CreateBookingHotel::route('/create'),
            'edit' => Pages\EditBookingHotel::route('/{record}/edit'),
        ];
    }
    
    
}