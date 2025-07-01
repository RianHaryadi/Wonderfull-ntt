<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;
    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('transaction_id')
                ->relationship('transaction', 'customer_name')
                ->label('Transaction')
                ->searchable()
                ->required(),

            Forms\Components\TextInput::make('ticket_code')
                ->label('Ticket Code')
                ->required()
                ->disabled(), // jika auto generate

            Forms\Components\Select::make('status')
                ->label('Status')
                ->options([
                    'active' => 'Active',
                    'used' => 'Used',
                    'cancelled' => 'Cancelled',
                ])
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ticket_code')
                    ->label('Ticket Code')
                    ->searchable(),

                TextColumn::make('transaction.customer_name')
                    ->label('Customer'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'primary' => 'active',
                        'success' => 'used',
                        'danger' => 'cancelled',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('validate')
                    ->label('Validate Ticket')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->status === 'active')
                    ->action(fn (Ticket $record) => $record->update([
                        'status' => 'used',
            ])),
        Tables\Actions\Action::make('cancel')
    ->label('Cancel Ticket')
    ->icon('heroicon-o-x-circle')
    ->color('danger')
    ->requiresConfirmation()
    ->visible(fn ($record) => $record->status === 'active')
    ->action(fn (Ticket $record) => $record->update([
        'status' => 'cancelled',
    ])),
        Tables\Actions\ViewAction::make(),
        Tables\Actions\EditAction::make(),
        Tables\Actions\DeleteAction::make(),
])

            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
