<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\BookingHotel;

class CreateTransaction extends CreateRecord
{
    protected static string $resource = TransactionResource::class;

    protected function afterCreate(): void
    {
        $transaction = $this->record;

        // Contoh generate tiket jika status confirmed
        if ($transaction->status === 'confirmed') {
            // $transaction->generateTicket();
        }

        // Cek data hotel dan tipe kamar dari transaksi
        if ($transaction->hotel_id && $transaction->room_type) {
            BookingHotel::create([
                'hotel_id' => $transaction->hotel_id,
                'room_type' => $transaction->room_type,
                'status' => 'pending', // sesuai enum di booking_hotels migration
                'check_in_date' => $transaction->transaction_date, // sesuaikan field tanggal di transaksi
                'night_count' => $transaction->night_count ?? 1,
                'customer_name' => $transaction->customer_name ?? 'Unknown',
                'customer_email' => $transaction->customer_email ?? 'example@example.com',
                // bisa tambah field lain sesuai kebutuhan dan migrasi
            ]);
        }
    }
}
