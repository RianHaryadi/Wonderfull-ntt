<?php

namespace App\Filament\Resources\PromotionResource\Pages;

use App\Filament\Resources\CodePromotionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCodePromotion extends ListRecords
{
    protected static string $resource = CodePromotionResource::class;

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
