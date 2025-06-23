<?php

namespace App\Filament\Resources\TourPackageVariantResource\Pages;

use App\Filament\Resources\TourPackageVariantResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTourPackageVariant extends EditRecord
{
    protected static string $resource = TourPackageVariantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
