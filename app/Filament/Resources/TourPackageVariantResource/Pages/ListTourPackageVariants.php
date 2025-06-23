<?php

namespace App\Filament\Resources\TourPackageVariantResource\Pages;

use App\Filament\Resources\TourPackageVariantResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTourPackageVariants extends ListRecords
{
    protected static string $resource = TourPackageVariantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('')
            // ->color('success')
            ->icon('heroicon-o-plus'),
        ];
    }
}
