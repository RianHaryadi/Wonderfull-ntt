<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class PaymentMethodPieChart extends ChartWidget
{
    protected static ?string $heading = 'Metode Pembayaran';
    protected static ?int $sort = 3;

    protected function getType(): string
    {
        return 'pie'; // tipe pie chart
    }

    protected function getData(): array
{
    // Ambil data payment_method dan jumlah dari transactions
    $transactionsData = DB::table('transactions')
        ->select('payment_method', DB::raw('count(*) as total'))
        ->groupBy('payment_method');

    // Ambil data payment_method dan jumlah dari booking_hotels
    $bookingHotelsData = DB::table('booking_hotels')
        ->select('payment_method', DB::raw('count(*) as total'))
        ->groupBy('payment_method');

    // Gabungkan data dari kedua query menggunakan unionAll
    $combinedData = DB::query()
        ->fromSub(function ($query) use ($transactionsData, $bookingHotelsData) {
            $query->select('payment_method', DB::raw('sum(total) as total'))
                ->fromSub(function ($sub) use ($transactionsData, $bookingHotelsData) {
                    $sub->select('payment_method', DB::raw('count(*) as total'))
                        ->from('transactions')
                        ->groupBy('payment_method')
                        ->unionAll(
                            DB::table('booking_hotels')
                                ->select('payment_method', DB::raw('count(*) as total'))
                                ->groupBy('payment_method')
                        );
                }, 'unioned')
                ->groupBy('payment_method');
        }, 'combined')
        ->get();

    $colors = [
        '#16a34a', // hijau
        '#3b82f6', // biru
        '#f59e0b', // kuning
        '#ef4444', // merah
        '#8b5cf6', // ungu
    ];

    return [
        'labels' => $combinedData->pluck('payment_method')->toArray(),
        'datasets' => [
            [
                'data' => $combinedData->pluck('total')->toArray(),
                'backgroundColor' => array_slice($colors, 0, $combinedData->count()),
            ],
        ],
    ];
}
}   