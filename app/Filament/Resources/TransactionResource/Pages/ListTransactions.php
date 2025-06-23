<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTransactions extends ListRecords
{
    protected static string $resource = TransactionResource::class;

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
