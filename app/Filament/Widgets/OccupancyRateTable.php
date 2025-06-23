<?php

namespace App\Filament\Widgets;

use App\Models\Hotel;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use Illuminate\Support\Facades\DB;

class OccupancyRateTable extends BaseWidget implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static ?string $heading = 'Tingkat Hunian Kamar per Hotel';
    protected static ?int $sort = 2;

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return Hotel::query()
            ->select(
                'hotels.id',
                'hotels.name',
                DB::raw('
                    (
                        COALESCE(hotels.room_count_single, 0) +
                        COALESCE(hotels.room_count_double, 0) +
                        COALESCE(hotels.room_count_family, 0)
                    ) AS total_rooms
                '),
                DB::raw('
                    (
                        SELECT COUNT(*) FROM hotel_rooms
                        WHERE hotel_rooms.booking_hotel_id IN (
                            SELECT id FROM booking_hotels WHERE booking_hotels.hotel_id = hotels.id
                        ) AND hotel_rooms.status = "not available"
                    ) AS booked_rooms
                '),
                DB::raw('
                    CASE 
                        WHEN (
                            COALESCE(hotels.room_count_single, 0) +
                            COALESCE(hotels.room_count_double, 0) +
                            COALESCE(hotels.room_count_family, 0)
                        ) = 0 THEN 0
                        ELSE ROUND((
                            (
                                SELECT COUNT(*) FROM hotel_rooms
                                WHERE hotel_rooms.booking_hotel_id IN (
                                    SELECT id FROM booking_hotels WHERE booking_hotels.hotel_id = hotels.id
                                ) AND hotel_rooms.status = "not available"
                            ) * 100.0
                        ) / (
                            COALESCE(hotels.room_count_single, 0) +
                            COALESCE(hotels.room_count_double, 0) +
                            COALESCE(hotels.room_count_family, 0)
                        ), 2)
                    END AS occupancy_rate
                ')
            );
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->label('Nama Hotel')
                ->sortable()
                ->searchable()
                ->weight('bold'),

            Tables\Columns\TextColumn::make('total_rooms')
                ->label('Total Kamar'),

            Tables\Columns\TextColumn::make('booked_rooms')
                ->label('Kamar Terisi'),

            Tables\Columns\TextColumn::make('occupancy_rate')
                ->label('Tingkat Hunian (%)')
                ->formatStateUsing(fn ($state) => number_format($state, 2) . ' %'),
        ];
    }
}
