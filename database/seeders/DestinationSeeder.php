<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Destination;

class DestinationSeeder extends Seeder
{
    public function run()
    {
        $json = file_get_contents(database_path('data/ntt_destinations.json'));
        $destinations = json_decode($json, true);

        foreach ($destinations as $data) {
           Destination::updateOrCreate(
    ['name' => $data['destination_name']],
    [
        'description'  => $data['description'] ?? null,
        'location'     => $data['location'] ?? null,
        'category'     => $data['category'] ?? null,
        'price'        => $data['price'] ?? 0,
        'is_popular'   => $data['popular'] ?? false,
        'rating'       => $data['rating'] ?? 0,
        'rating_count' => $data['count'] ?? 0,
        'latitude'     => $data['latitude'] ?? null,
        'longitude'    => $data['longitude'] ?? null,
        'maps_url'     => $data['maps_url'] ?? null,
        // jangan update image kalau sudah ada
        'image'        => $data['image'] ?? Destination::where('name', $data['destination_name'])->value('image'),
    ]
);

        }
    }
}
