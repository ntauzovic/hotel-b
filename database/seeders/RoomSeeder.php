<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            [
                'name'            => '101',
                'type'            => 'single',
                'description'     => 'Udobna jednokrevetna soba sa pogledom na grad.',
                'price_per_night' => 75.00,
                'capacity'        => 1,
                'floor'           => 1,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Safe'],
            ],
            [
                'name'            => '102',
                'type'            => 'double',
                'description'     => 'Prostrana dvokrevetna soba idealna za parove.',
                'price_per_night' => 120.00,
                'capacity'        => 2,
                'floor'           => 1,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Mini bar', 'Safe'],
            ],
            [
                'name'            => '201',
                'type'            => 'double',
                'description'     => 'Dvokrevetna soba sa balkonom i pogledom na more.',
                'price_per_night' => 150.00,
                'capacity'        => 2,
                'floor'           => 2,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Balcony', 'Mini bar'],
            ],
            [
                'name'            => 'Penthouse Suite',
                'type'            => 'suite',
                'description'     => 'Luksuzni suite sa panoramskim pogledom, džakuzijem i privatnom terasom.',
                'price_per_night' => 450.00,
                'capacity'        => 4,
                'floor'           => 5,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Jacuzzi', 'Mini bar', 'Kitchen', 'Terrace', 'Safe'],
            ],
            [
                'name'            => 'Family Apartment',
                'type'            => 'apartment',
                'description'     => 'Prostrani apartman za porodice sa odvojenom spavaoom sobom i kuhinjom.',
                'price_per_night' => 220.00,
                'capacity'        => 5,
                'floor'           => 3,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Kitchen', 'Washing machine', 'Safe'],
            ],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }

        $this->command->info('✅ Rooms seeded successfully!');
    }
}
