<?php

namespace App\Filament\Resources\TourPackageResource\Pages;

use App\Filament\Resources\TourPackageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTourPackages extends ListRecords
{
    protected static string $resource = TourPackageResource::class;

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
