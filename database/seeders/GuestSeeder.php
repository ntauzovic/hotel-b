<?php

namespace Database\Seeders;

use App\Models\Guest;
use Illuminate\Database\Seeder;

class GuestSeeder extends Seeder
{
    public function run(): void
    {
        $guests = [
            [
                'first_name'      => 'Marko',
                'last_name'       => 'Petrovic',
                'email'           => 'marko.petrovic@example.com',
                'phone'           => '+387 61 123 456',
                'date_of_birth'   => '1985-03-15',
                'nationality'     => 'Bosnian',
                'passport_number' => 'BA1234567',
                'address'         => 'Titova 12',
                'city'            => 'Sarajevo',
                'country'         => 'Bosnia and Herzegovina',
                'notes'           => 'VIP gost, preferira sobu na visim spratovima.',
            ],
            [
                'first_name'      => 'Ana',
                'last_name'       => 'Horvat',
                'email'           => 'ana.horvat@example.com',
                'phone'           => '+385 91 234 567',
                'date_of_birth'   => '1990-07-22',
                'nationality'     => 'Croatian',
                'passport_number' => 'HR9876543',
                'address'         => 'Ilica 45',
                'city'            => 'Zagreb',
                'country'         => 'Croatia',
                'notes'           => null,
            ],
            [
                'first_name'      => 'Stefan',
                'last_name'       => 'Nikolic',
                'email'           => 'stefan.nikolic@example.com',
                'phone'           => '+381 63 345 678',
                'date_of_birth'   => '1978-11-05',
                'nationality'     => 'Serbian',
                'passport_number' => 'RS5556677',
                'address'         => 'Knez Mihailova 8',
                'city'            => 'Belgrade',
                'country'         => 'Serbia',
                'notes'           => 'Alergija na perje - potrebni hipoalergeni jastuci.',
            ],
            [
                'first_name'      => 'Emma',
                'last_name'       => 'Schmidt',
                'email'           => 'emma.schmidt@example.com',
                'phone'           => '+49 176 456 789',
                'date_of_birth'   => '1995-02-28',
                'nationality'     => 'German',
                'passport_number' => 'DE2233445',
                'address'         => 'Unter den Linden 17',
                'city'            => 'Berlin',
                'country'         => 'Germany',
                'notes'           => 'Vegetarijanac. Cesto ponavlja rezervaciju svake godine.',
            ],
            [
                'first_name'      => 'James',
                'last_name'       => 'Wilson',
                'email'           => 'james.wilson@example.com',
                'phone'           => '+44 7700 900123',
                'date_of_birth'   => '1982-09-14',
                'nationality'     => 'British',
                'passport_number' => 'GB8899001',
                'address'         => '10 Baker Street',
                'city'            => 'London',
                'country'         => 'United Kingdom',
                'notes'           => null,
            ],
        ];

        foreach ($guests as $guest) {
            Guest::create($guest);
        }

        $this->command->info('Guests seeded successfully!');
    }
}
