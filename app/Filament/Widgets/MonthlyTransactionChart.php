<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class MonthlyTransactionChart extends ChartWidget
{
    protected static ?string $heading = 'Transaksi Bulanan';
    protected static ?int $sort = 5;

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $data = DB::table('transactions')
            ->selectRaw("MONTHNAME(created_at) as month, COUNT(*) as total")
            ->whereYear('created_at', now()->year)
            ->groupByRaw("MONTH(created_at), MONTHNAME(created_at)")
            ->orderByRaw("MONTH(created_at)")
            ->get();

        return [
            'labels' => $data->pluck('month')->toArray(),
            'datasets' => [
                [
                    'label' => 'Transaksi',
                    'data' => $data->pluck('total')->toArray(),
                    'borderColor' => '#4F46E5',
                    'backgroundColor' => 'rgba(79, 70, 229, 0.3)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
        ];
    }
}
