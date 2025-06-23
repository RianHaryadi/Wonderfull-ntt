<?php

namespace App\Filament\Resources\BookingHotelResource\Pages;

use App\Filament\Resources\BookingHotelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookingHotels extends ListRecords
{
    protected static string $resource = BookingHotelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('')
                ->color('success')
                ->icon('heroicon-o-plus'),
            Actions\Action::make('export')
                ->label('Export')
                ->icon('heroicon-o-printer')
                // ->url(route('filament.resources.booking-hotels.export')) // Adjust the route as necessary
                ->color('primary'),
        ];
    }
}
