<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class TotalRevenueOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // Total pendapatan Destinasi
        $destinasiTotal = DB::table('transactions')
            ->where('status', 'confirmed')
            ->sum('total_price');

        // Total pendapatan Hotel
        $hotelTotal = DB::table('booking_hotels')
            ->where('status', 'checked-out')
            ->sum('total_price');

        // Jumlah user unik untuk Destinasi (berdasarkan customer_email)
        $destinasiUsers = DB::table('transactions')
            ->where('status', 'confirmed')
            ->distinct('customer_email')
            ->count('customer_email');

        // Jumlah user unik untuk Hotel (berdasarkan customer_email)
        $hotelUsers = DB::table('booking_hotels')
            ->where('status', 'checked-out')
            ->distinct('customer_email')
            ->count('customer_email');

        return [
            Stat::make('Pendapatan Destinasi', 'Rp ' . number_format($destinasiTotal, 0, ',', '.'))
                ->description('Pendapatan dari Destinasi')
                ->color('success'),

            Stat::make('Pendapatan Hotel', 'Rp ' . number_format($hotelTotal, 0, ',', '.'))
                ->description('Pendapatan dari Hotel')
                ->color('primary'),

            Stat::make('User Destinasi', $destinasiUsers)
                ->description('Jumlah user destinasi')
                ->color('warning'),

            Stat::make('User Hotel', $hotelUsers)
                ->description('Jumlah user hotel')
                ->color('secondary'),
        ];
    }
}
