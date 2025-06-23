<?php

// app/Filament/Resources/TransactionResource/Pages/EditTransaction.php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Resources\Pages\EditRecord;
use App\Models\BookingHotel;

class EditTransaction extends EditRecord
{
    protected static string $resource = TransactionResource::class;

    protected function afterSave(): void
    {
        parent::afterSave();

        $transaction = $this->record;

        if ($transaction->hotel_id && $transaction->room_type) {
            // Cari booking hotel yg terkait transaksi ini
            $booking = BookingHotel::where('transaction_id', $transaction->id)->first();

            if ($booking) {
                $booking->update([
                    'hotel_id' => $transaction->hotel_id,
                    'room_type' => $transaction->room_type,
                    'check_in' => $transaction->transaction_date,
                    'quantity' => $transaction->ticket_quantity,
                ]);
            } else {
                BookingHotel::create([
                    'transaction_id' => $transaction->id,
                    'hotel_id' => $transaction->hotel_id,
                    'room_type' => $transaction->room_type,
                    'status' => 'booked',
                    'check_in' => $transaction->transaction_date,
                    'quantity' => $transaction->ticket_quantity,
                ]);
            }
        }
    }
}
