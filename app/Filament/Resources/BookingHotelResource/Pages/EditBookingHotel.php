<?php

namespace App\Filament\Resources\BookingHotelResource\Pages;

use App\Filament\Resources\BookingHotelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookingHotel extends EditRecord
{
    protected static string $resource = BookingHotelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
