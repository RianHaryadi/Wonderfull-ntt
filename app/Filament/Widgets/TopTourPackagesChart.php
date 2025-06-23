<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class TopTourPackagesChart extends ChartWidget
{
    protected static ?string $heading = 'Paket Tur Terlaris';
    protected static ?int $sort = 4;

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $data = DB::table('transactions')
            ->join('tour_packages', 'transactions.tour_package_id', '=', 'tour_packages.id')
            ->select('tour_packages.name', DB::raw('COUNT(*) as total'))
            ->where('transactions.status', 'confirmed')
            ->groupBy('tour_packages.name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return [
            'labels' => $data->pluck('name')->toArray(),
            'datasets' => [
                [
                    'label' => 'Jumlah Tiket',
                    'data' => $data->pluck('total')->toArray(),
                    'backgroundColor' => '#60a5fa',
                ],
            ],
        ];
    }
}
