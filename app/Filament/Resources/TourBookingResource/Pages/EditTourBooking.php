<?php

namespace App\Filament\Resources\TourBookingResource\Pages;

use App\Filament\Resources\TourBookingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTourBooking extends EditRecord
{
    protected static string $resource = TourBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
