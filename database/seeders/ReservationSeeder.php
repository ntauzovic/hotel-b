<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\Guest;
use App\Models\Room;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        // Uzimamo postojece goste i sobe
        $guests = Guest::all();
        $rooms  = Room::all();

        if ($guests->isEmpty() || $rooms->isEmpty()) {
            $this->command->warn('Nema gostiju ili soba. Pokreni RoomSeeder i GuestSeeder prvo.');
            return;
        }

        $reservations = [
            [
                'guest_id'         => $guests->where('email', 'marko.petrovic@example.com')->first()?->id ?? $guests->first()->id,
                'room_id'          => $rooms->where('name', '101')->first()?->id ?? $rooms->first()->id,
                'check_in_date'    => '2026-04-10',
                'check_out_date'   => '2026-04-14',
                'status'           => 'confirmed',
                'number_of_guests' => 1,
                'total_price'      => 300.00,
                'notes'            => 'Gost trazi kasni check-in oko 22h.',
            ],
            [
                'guest_id'         => $guests->where('email', 'ana.horvat@example.com')->first()?->id ?? $guests->first()->id,
                'room_id'          => $rooms->where('name', '102')->first()?->id ?? $rooms->first()->id,
                'check_in_date'    => '2026-04-15',
                'check_out_date'   => '2026-04-18',
                'status'           => 'pending',
                'number_of_guests' => 2,
                'total_price'      => 360.00,
                'notes'            => null,
            ],
            [
                'guest_id'         => $guests->where('email', 'stefan.nikolic@example.com')->first()?->id ?? $guests->first()->id,
                'room_id'          => $rooms->where('name', 'Penthouse Suite')->first()?->id ?? $rooms->first()->id,
                'check_in_date'    => '2026-05-01',
                'check_out_date'   => '2026-05-05',
                'status'           => 'confirmed',
                'number_of_guests' => 2,
                'total_price'      => 1800.00,
                'notes'            => 'Hipoalergeni jastuci obavezni.',
            ],
            [
                'guest_id'         => $guests->where('email', 'emma.schmidt@example.com')->first()?->id ?? $guests->first()->id,
                'room_id'          => $rooms->where('name', 'Family Apartment')->first()?->id ?? $rooms->first()->id,
                'check_in_date'    => '2026-06-20',
                'check_out_date'   => '2026-06-27',
                'status'           => 'pending',
                'number_of_guests' => 4,
                'total_price'      => 1540.00,
                'notes'            => 'Vegetarijanski obrok na dobrodoslici.',
            ],
            [
                'guest_id'         => $guests->where('email', 'james.wilson@example.com')->first()?->id ?? $guests->first()->id,
                'room_id'          => $rooms->where('name', '201')->first()?->id ?? $rooms->first()->id,
                'check_in_date'    => '2026-07-10',
                'check_out_date'   => '2026-07-15',
                'status'           => 'confirmed',
                'number_of_guests' => 2,
                'total_price'      => 750.00,
                'notes'            => null,
            ],
        ];

        foreach ($reservations as $reservation) {
            Reservation::create($reservation);
        }

        $this->command->info('Reservations seeded successfully!');
    }
}
