<?php
namespace App\Filament\Resources;

use App\Filament\Resources\HotelRoomResource\Pages;
use App\Models\HotelRoom;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class HotelRoomResource extends Resource
{
    protected static ?string $model = HotelRoom::class;
    protected static ?string $navigationGroup = 'Hotel Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('booking_number')
                    ->label('Booking Number')
                    // ->searchable()
                    ->disabled()
                    ->default(fn ($record) => $record?->bookingHotel?->booking_number),

                Forms\Components\TextInput::make('customer_name')
                    ->label('Customer Name')
                    ->disabled()
                    ->default(fn ($record) => $record?->bookingHotel?->customer_name),

                Forms\Components\TextInput::make('room_type')
                    ->label('Room Type')
                    ->disabled()
                    ->default(fn ($record) => $record?->bookingHotel?->roomType?->name),

                Forms\Components\TextInput::make('room_number')
                    ->label('Room Number')
                    ->disabled(),

                Forms\Components\TextInput::make('status')
                    ->label('Status')
                    ->disabled(),

                Forms\Components\Select::make('booking_hotel_id')
                    ->relationship('bookingHotel', 'booking_number')
                    ->label('Booking')
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('booking_number')->label('Booking Number')->searchable(),
                Tables\Columns\TextColumn::make('customer_name')->label('Customer Name')->searchable(),
                Tables\Columns\TextColumn::make('room_type')->label('Room Type')->searchable(),
                Tables\Columns\TextColumn::make('room_number')->label('Room Number')->searchable(),
                Tables\Columns\TextColumn::make('status')->label('Status')->searchable(),
            ])
            ->actions([
                Action::make('set-available')
                ->label('Set Available')
                ->icon('heroicon-m-check-circle')
                ->color('success')
                ->visible(fn ($record) => in_array($record->status, ['not available', 'cleaning','maintenance']))
                ->action(function ($record) {
                    // 1. Ubah status kamar menjadi 'available'
                    $record->status = 'available';
                    $record->save();

                    // 2. Ambil relasi booking hotel
                    $booking = $record->bookingHotel;
                    $hotel = $booking?->hotel;

                    // Jika booking masih checked-in, ubah jadi checked-out
                    if ($booking && $booking->status === 'checked-in') {
                        $booking->status = 'checked-out';
                        $booking->save();
                    }

                    // Tambah kuota kamar pada hotel sesuai tipe kamar (selama ada booking & hotel)
                    if ($booking && $hotel) {
                        if ($record->room_type === 'single') {
                            $hotel->increment('room_count_single');
                        } elseif ($record->room_type === 'double') {
                            $hotel->increment('room_count_double');
                        } elseif ($record->room_type === 'family') {
                            $hotel->increment('room_count_family');
                        }
                    }

                    // 5. Hapus data HotelRoom
                    $record->delete();
                }),
        Action::make('set-cleaning')
        ->label('Set Cleaning')
        ->icon('heroicon-m-sparkles')
        ->color('warning')
        ->visible(fn ($record) => !in_array($record->status, ['cleaning', 'available']))
        ->action(function ($record) {
            // Ubah status kamar menjadi cleaning
            $record->status = 'cleaning';
            $record->save();

            // Jika ada booking dan statusnya checked-in, ubah jadi checked-out
            $booking = $record->bookingHotel;
            if ($booking && $booking->status === 'checked-in') {
                $booking->status = 'checked-out';
                $booking->save();
            }
            // Tidak menambah kuota kamar dan tidak menghapus data HotelRoom
        }),
        Action::make('set-maintenance')
        ->label('Set Maintenance')
        ->icon('heroicon-m-wrench-screwdriver')
        ->color('danger')
        ->visible(fn ($record) => $record->status !== 'maintenance')
        ->action(function ($record) {
            $record->status = 'maintenance';
            $record->save();

            // Jika ada booking dan statusnya checked-in, ubah jadi checked-out
            $booking = $record->bookingHotel;
            if ($booking && $booking->status === 'checked-in') {
                $booking->status = 'checked-out';
                $booking->save();
            }
            // Tidak menambah kuota kamar dan tidak menghapus data HotelRoom
        }),
    Tables\Actions\ViewAction::make(),
    Tables\Actions\DeleteAction::make(),
])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
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
            'index' => Pages\ListHotelRooms::route('/'),
            'create' => Pages\CreateHotelRoom::route('/create'),
            'edit' => Pages\EditHotelRoom::route('/{record}/edit'),
        ];
    }
}
