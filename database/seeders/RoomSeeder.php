<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        Room::truncate();

        // Standard/Superior/Deluxe images — beach/Mediterranean hotel style (floors 1-5)
        // All IDs verified working as of March 2026.
        $stdImages = [
            'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=800&q=80&auto=format&fit=crop', // tropical resort pool, mountain backdrop
            'https://images.unsplash.com/photo-1582719508461-905c673771fd?w=800&q=80&auto=format&fit=crop', // beach pool deck with sun loungers
            'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?w=800&q=80&auto=format&fit=crop', // luxury resort pool at dusk, palm trees
            'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?w=800&q=80&auto=format&fit=crop', // bright luxury hotel room interior
            'https://images.unsplash.com/photo-1584132967334-10e028bd69f7?w=800&q=80&auto=format&fit=crop', // elegant classic hotel bedroom
            'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=800&q=80&auto=format&fit=crop', // beach terrace dining with sea view
            'https://images.unsplash.com/photo-1445019980597-93fa8acb246c?w=800&q=80&auto=format&fit=crop', // resort pool at twilight
            'https://images.unsplash.com/photo-1564501049412-61c2a3083791?w=800&q=80&auto=format&fit=crop', // luxury white villa with blue pool
            'https://images.unsplash.com/photo-1615460549969-36fa19521a4f?w=800&q=80&auto=format&fit=crop', // resort pool with loungers and greenery
            'https://images.unsplash.com/photo-1590490359683-658d3d23f972?w=800&q=80&auto=format&fit=crop', // resort pool panoramic view
        ];

        // Luxury images — beach resort suites and ocean-view rooms (floors 6-7)
        // All IDs verified working as of March 2026.
        $luxImages = [
            'https://images.unsplash.com/photo-1469796466635-455ede028aca?w=800&q=80&auto=format&fit=crop', // Santorini/Mediterranean terrace, sea view
            'https://images.unsplash.com/photo-1602002418082-a4443e081dd1?w=800&q=80&auto=format&fit=crop', // Mediterranean beach villa with pool
            'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=800&q=80&auto=format&fit=crop', // luxury resort pool lit at night
            'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=800&q=80&auto=format&fit=crop', // luxury hotel room, warm lighting
            'https://images.unsplash.com/photo-1631049552057-403cdb8f0658?w=800&q=80&auto=format&fit=crop', // clean modern resort bedroom
            'https://images.unsplash.com/photo-1543968996-ee822b8176ba?w=800&q=80&auto=format&fit=crop', // beach-view room, turquoise ocean panorama
            'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=800&q=80&auto=format&fit=crop', // sunset resort pool exterior, pink sky
            'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=800&q=80&auto=format&fit=crop', // modern white villa with infinity pool
            'https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=800&q=80&auto=format&fit=crop', // boutique luxury hotel room interior
            'https://images.unsplash.com/photo-1568495248636-6432b97bd949?w=800&q=80&auto=format&fit=crop', // penthouse suite, floor-to-ceiling windows
        ];

        $rooms = [
            // -------------------------
            // Floor 1 — Standard (101-105), 5 rooms
            // -------------------------
            [
                'name'            => '101',
                'type'            => 'standard',
                'description'     => 'Comfortable standard room on the ground floor with a city view. Perfect for solo travellers or couples looking for a cosy retreat.',
                'price_per_night' => 75.00,
                'capacity'        => 2,
                'floor'           => 1,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Safe'],
                'images'          => [$stdImages[0], $stdImages[1], $stdImages[2]],
            ],
            [
                'name'            => '102',
                'type'            => 'standard',
                'description'     => 'Well-appointed standard room with twin beds, ideal for business travellers or friends sharing.',
                'price_per_night' => 78.00,
                'capacity'        => 2,
                'floor'           => 1,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Safe'],
                'images'          => [$stdImages[3], $stdImages[4], $stdImages[5]],
            ],
            [
                'name'            => '103',
                'type'            => 'standard',
                'description'     => 'Bright and airy standard room with modern furnishings and a queen-size bed.',
                'price_per_night' => 80.00,
                'capacity'        => 2,
                'floor'           => 1,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Safe'],
                'images'          => [$stdImages[6], $stdImages[7], $stdImages[8]],
            ],
            [
                'name'            => '104',
                'type'            => 'standard',
                'description'     => 'Cosy standard room featuring a work desk and high-speed WiFi, great for short business stays.',
                'price_per_night' => 80.00,
                'capacity'        => 2,
                'floor'           => 1,
                'is_available'    => false,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Safe', 'Work desk'],
                'images'          => [$stdImages[9], $stdImages[0], $stdImages[1]],
            ],
            [
                'name'            => '105',
                'type'            => 'standard',
                'description'     => 'Relaxing standard room with garden-facing windows and contemporary decor.',
                'price_per_night' => 82.00,
                'capacity'        => 2,
                'floor'           => 1,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Safe'],
                'images'          => [$stdImages[2], $stdImages[3], $stdImages[4]],
            ],

            // -------------------------
            // Floor 2 — Standard (201-206), 6 rooms
            // -------------------------
            [
                'name'            => '201',
                'type'            => 'standard',
                'description'     => 'Standard room on the second floor with a view of the hotel courtyard. Includes a comfortable king-size bed.',
                'price_per_night' => 85.00,
                'capacity'        => 2,
                'floor'           => 2,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Safe'],
                'images'          => [$stdImages[5], $stdImages[6], $stdImages[7]],
            ],
            [
                'name'            => '202',
                'type'            => 'standard',
                'description'     => 'Spacious standard room with twin beds, extra storage space, and a full-length mirror.',
                'price_per_night' => 85.00,
                'capacity'        => 2,
                'floor'           => 2,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Safe'],
                'images'          => [$stdImages[8], $stdImages[9], $stdImages[0]],
            ],
            [
                'name'            => '203',
                'type'            => 'standard',
                'description'     => 'Freshly renovated standard room with modern bathroom and city-facing windows.',
                'price_per_night' => 88.00,
                'capacity'        => 2,
                'floor'           => 2,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Safe', 'Work desk'],
                'images'          => [$stdImages[1], $stdImages[2], $stdImages[3]],
            ],
            [
                'name'            => '204',
                'type'            => 'standard',
                'description'     => 'Light-filled standard room with neutral tones, a plush queen bed, and en-suite bathroom.',
                'price_per_night' => 90.00,
                'capacity'        => 2,
                'floor'           => 2,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Safe'],
                'images'          => [$stdImages[4], $stdImages[5], $stdImages[6]],
            ],
            [
                'name'            => '205',
                'type'            => 'standard',
                'description'     => 'Quiet standard room situated away from the street, ideal for guests who value a peaceful night\'s rest.',
                'price_per_night' => 88.00,
                'capacity'        => 2,
                'floor'           => 2,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Safe'],
                'images'          => [$stdImages[7], $stdImages[8], $stdImages[9]],
            ],
            [
                'name'            => '206',
                'type'            => 'standard',
                'description'     => 'Corner standard room with extra natural light and a panoramic view of the surrounding streets.',
                'price_per_night' => 95.00,
                'capacity'        => 2,
                'floor'           => 2,
                'is_available'    => false,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Safe', 'Mini bar'],
                'images'          => [$stdImages[0], $stdImages[2], $stdImages[4]],
            ],

            // -------------------------
            // Floor 3 — Superior (301-306), 6 rooms
            // -------------------------
            [
                'name'            => '301',
                'type'            => 'superior',
                'description'     => 'Elegant superior room with upgraded furnishings, a seating area, and a partial city view.',
                'price_per_night' => 120.00,
                'capacity'        => 2,
                'floor'           => 3,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Mini bar', 'Safe', 'Work desk'],
                'images'          => [$stdImages[1], $stdImages[3], $stdImages[5]],
            ],
            [
                'name'            => '302',
                'type'            => 'superior',
                'description'     => 'Superior room with a large king-size bed, rainfall shower, and premium bath amenities.',
                'price_per_night' => 125.00,
                'capacity'        => 2,
                'floor'           => 3,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Mini bar', 'Safe', 'Rainfall shower'],
                'images'          => [$stdImages[7], $stdImages[9], $stdImages[1]],
            ],
            [
                'name'            => '303',
                'type'            => 'superior',
                'description'     => 'Spacious superior room accommodating up to 3 guests, with a sofa bed and garden view.',
                'price_per_night' => 130.00,
                'capacity'        => 3,
                'floor'           => 3,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Mini bar', 'Safe', 'Sofa bed'],
                'images'          => [$stdImages[0], $stdImages[4], $stdImages[8]],
            ],
            [
                'name'            => '304',
                'type'            => 'superior',
                'description'     => 'Stylish superior room with hardwood floors, floor-to-ceiling windows, and a Nespresso machine.',
                'price_per_night' => 135.00,
                'capacity'        => 2,
                'floor'           => 3,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Mini bar', 'Safe', 'Coffee machine', 'Work desk'],
                'images'          => [$stdImages[2], $stdImages[6], $stdImages[0]],
            ],
            [
                'name'            => '305',
                'type'            => 'superior',
                'description'     => 'Superior room with a private balcony overlooking the hotel garden, perfect for a romantic stay.',
                'price_per_night' => 140.00,
                'capacity'        => 2,
                'floor'           => 3,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Mini bar', 'Safe', 'Balcony', 'Coffee machine'],
                'images'          => [$stdImages[3], $stdImages[7], $stdImages[9]],
            ],
            [
                'name'            => '306',
                'type'            => 'superior',
                'description'     => 'Corner superior room with dual-aspect windows offering sweeping city views and a walk-in closet.',
                'price_per_night' => 145.00,
                'capacity'        => 3,
                'floor'           => 3,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Mini bar', 'Safe', 'Walk-in closet', 'Coffee machine'],
                'images'          => [$stdImages[5], $stdImages[8], $stdImages[2]],
            ],

            // -------------------------
            // Floor 4 — Superior (401-406), 6 rooms
            // -------------------------
            [
                'name'            => '401',
                'type'            => 'superior',
                'description'     => 'Upper-floor superior room with outstanding city vistas, a king-size bed, and a marble bathroom.',
                'price_per_night' => 145.00,
                'capacity'        => 2,
                'floor'           => 4,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Mini bar', 'Safe', 'Marble bathroom', 'Coffee machine'],
                'images'          => [$stdImages[4], $stdImages[6], $stdImages[1]],
            ],
            [
                'name'            => '402',
                'type'            => 'superior',
                'description'     => 'Elevated superior room featuring a writing desk, lounge chair, and stunning sunset views.',
                'price_per_night' => 148.00,
                'capacity'        => 2,
                'floor'           => 4,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Mini bar', 'Safe', 'Work desk', 'Coffee machine'],
                'images'          => [$stdImages[9], $stdImages[3], $stdImages[7]],
            ],
            [
                'name'            => '403',
                'type'            => 'superior',
                'description'     => 'Superior room for up to 3 guests with two queen beds, ideal for families or small groups.',
                'price_per_night' => 150.00,
                'capacity'        => 3,
                'floor'           => 4,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Mini bar', 'Safe', 'Coffee machine'],
                'images'          => [$stdImages[0], $stdImages[5], $stdImages[9]],
            ],
            [
                'name'            => '404',
                'type'            => 'superior',
                'description'     => 'Luxuriously appointed superior room with a free-standing bathtub and separate shower cabin.',
                'price_per_night' => 155.00,
                'capacity'        => 2,
                'floor'           => 4,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Mini bar', 'Safe', 'Bathtub', 'Coffee machine'],
                'images'          => [$stdImages[2], $stdImages[8], $stdImages[4]],
            ],
            [
                'name'            => '405',
                'type'            => 'superior',
                'description'     => 'Premium superior room with a Juliet balcony, plush robes, and personalised turndown service.',
                'price_per_night' => 158.00,
                'capacity'        => 2,
                'floor'           => 4,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Mini bar', 'Safe', 'Balcony', 'Coffee machine', 'Bathrobe'],
                'images'          => [$stdImages[6], $stdImages[0], $stdImages[3]],
            ],
            [
                'name'            => '406',
                'type'            => 'superior',
                'description'     => 'Corner superior room with panoramic views on two sides, extra living space, and a premium sound system.',
                'price_per_night' => 160.00,
                'capacity'        => 3,
                'floor'           => 4,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Mini bar', 'Safe', 'Coffee machine', 'Sound system', 'Bathrobe'],
                'images'          => [$stdImages[1], $stdImages[7], $stdImages[5]],
            ],

            // -------------------------
            // Floor 5 — Deluxe (501-506), 6 rooms
            // -------------------------
            [
                'name'            => '501',
                'type'            => 'deluxe',
                'description'     => 'Sophisticated deluxe room with a private terrace, designer furniture, and a full city panorama.',
                'price_per_night' => 180.00,
                'capacity'        => 3,
                'floor'           => 5,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Mini bar', 'Safe', 'Terrace', 'Coffee machine', 'Bathrobe', 'Work desk'],
                'images'          => [$stdImages[8], $stdImages[2], $stdImages[6]],
            ],
            [
                'name'            => '502',
                'type'            => 'deluxe',
                'description'     => 'Contemporary deluxe room featuring a king-size bed, walk-in wardrobe, and double vanity bathroom.',
                'price_per_night' => 195.00,
                'capacity'        => 3,
                'floor'           => 5,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Mini bar', 'Safe', 'Coffee machine', 'Bathrobe', 'Walk-in wardrobe'],
                'images'          => [$stdImages[3], $stdImages[9], $stdImages[0]],
            ],
            [
                'name'            => '503',
                'type'            => 'deluxe',
                'description'     => 'Spacious deluxe room for up to 4 guests with a separate lounge area and premium home-cinema system.',
                'price_per_night' => 210.00,
                'capacity'        => 4,
                'floor'           => 5,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Mini bar', 'Safe', 'Coffee machine', 'Bathrobe', 'Home cinema', 'Work desk'],
                'images'          => [$stdImages[5], $stdImages[1], $stdImages[7]],
            ],
            [
                'name'            => '504',
                'type'            => 'deluxe',
                'description'     => 'Deluxe room with a Japanese soaking tub, heated floors, and floor-to-ceiling windows offering sky-high city views.',
                'price_per_night' => 220.00,
                'capacity'        => 3,
                'floor'           => 5,
                'is_available'    => false,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Mini bar', 'Safe', 'Coffee machine', 'Bathrobe', 'Soaking tub', 'Heated floors'],
                'images'          => [$stdImages[4], $stdImages[8], $stdImages[2]],
            ],
            [
                'name'            => '505',
                'type'            => 'deluxe',
                'description'     => 'Elegantly decorated deluxe room with curated artwork, a king bed, and a rain shower with chromotherapy.',
                'price_per_night' => 235.00,
                'capacity'        => 3,
                'floor'           => 5,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Mini bar', 'Safe', 'Coffee machine', 'Bathrobe', 'Rainfall shower'],
                'images'          => [$stdImages[7], $stdImages[3], $stdImages[9]],
            ],
            [
                'name'            => '506',
                'type'            => 'deluxe',
                'description'     => 'Corner deluxe room with wrap-around windows, a private balcony, and a fully stocked mini kitchen.',
                'price_per_night' => 250.00,
                'capacity'        => 4,
                'floor'           => 5,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Mini bar', 'Safe', 'Coffee machine', 'Bathrobe', 'Balcony', 'Mini kitchen'],
                'images'          => [$stdImages[6], $stdImages[0], $stdImages[4]],
            ],

            // -------------------------
            // Floor 6 — Junior Suite (601-605), 5 rooms
            // -------------------------
            [
                'name'            => '601',
                'type'            => 'junior_suite',
                'description'     => 'Opulent junior suite with a separate living room, a king-size bed, and sweeping skyline views from every window.',
                'price_per_night' => 300.00,
                'capacity'        => 4,
                'floor'           => 6,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Mini bar', 'Safe', 'Coffee machine', 'Bathrobe', 'Separate living room', 'Work desk', 'Bathtub'],
                'images'          => [$luxImages[0], $luxImages[1], $luxImages[2]],
            ],
            [
                'name'            => '602',
                'type'            => 'junior_suite',
                'description'     => 'Refined junior suite with a spacious lounge, a whirlpool bath, and bespoke décor by local artists.',
                'price_per_night' => 320.00,
                'capacity'        => 4,
                'floor'           => 6,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Mini bar', 'Safe', 'Coffee machine', 'Bathrobe', 'Whirlpool', 'Separate living room'],
                'images'          => [$luxImages[3], $luxImages[4], $luxImages[5]],
            ],
            [
                'name'            => '603',
                'type'            => 'junior_suite',
                'description'     => 'Contemporary junior suite featuring a private terrace with sun loungers and a panoramic city view.',
                'price_per_night' => 340.00,
                'capacity'        => 4,
                'floor'           => 6,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Mini bar', 'Safe', 'Coffee machine', 'Bathrobe', 'Terrace', 'Separate living room', 'Sound system'],
                'images'          => [$luxImages[6], $luxImages[7], $luxImages[8]],
            ],
            [
                'name'            => '604',
                'type'            => 'junior_suite',
                'description'     => 'Lavish junior suite with a dining area for four, a smart home system, and butler service on request.',
                'price_per_night' => 360.00,
                'capacity'        => 4,
                'floor'           => 6,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Mini bar', 'Safe', 'Coffee machine', 'Bathrobe', 'Dining area', 'Smart home', 'Butler service'],
                'images'          => [$luxImages[9], $luxImages[0], $luxImages[1]],
            ],
            [
                'name'            => '605',
                'type'            => 'junior_suite',
                'description'     => 'Corner junior suite with a jacuzzi on the private balcony, designer interiors, and complimentary evening canapés.',
                'price_per_night' => 380.00,
                'capacity'        => 4,
                'floor'           => 6,
                'is_available'    => false,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Mini bar', 'Safe', 'Coffee machine', 'Bathrobe', 'Jacuzzi', 'Balcony', 'Butler service'],
                'images'          => [$luxImages[2], $luxImages[3], $luxImages[4]],
            ],

            // -------------------------
            // Floor 7 — Penthouse (701-707), 7 rooms
            // -------------------------
            [
                'name'            => '701',
                'type'            => 'penthouse',
                'description'     => 'Spectacular penthouse suite with a private rooftop terrace, panoramic 360° views, and a personal butler on call 24/7.',
                'price_per_night' => 400.00,
                'capacity'        => 4,
                'floor'           => 7,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Mini bar', 'Safe', 'Coffee machine', 'Bathrobe', 'Rooftop terrace', 'Butler service', 'Jacuzzi', 'Kitchen'],
                'images'          => [$luxImages[5], $luxImages[6], $luxImages[7]],
            ],
            [
                'name'            => '702',
                'type'            => 'penthouse',
                'description'     => 'Grand penthouse featuring two bedrooms, a full kitchen, a private pool, and an exclusive lounge area.',
                'price_per_night' => 450.00,
                'capacity'        => 4,
                'floor'           => 7,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Mini bar', 'Safe', 'Coffee machine', 'Bathrobe', 'Private pool', 'Butler service', 'Jacuzzi', 'Kitchen'],
                'images'          => [$luxImages[8], $luxImages[9], $luxImages[0]],
            ],
            [
                'name'            => '703',
                'type'            => 'penthouse',
                'description'     => 'Artfully designed penthouse with bespoke furnishings, a home theatre, and a private dining room for six.',
                'price_per_night' => 470.00,
                'capacity'        => 5,
                'floor'           => 7,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Mini bar', 'Safe', 'Coffee machine', 'Bathrobe', 'Home cinema', 'Butler service', 'Dining room', 'Kitchen'],
                'images'          => [$luxImages[1], $luxImages[2], $luxImages[3]],
            ],
            [
                'name'            => '704',
                'type'            => 'penthouse',
                'description'     => 'Luxurious penthouse with floor-to-ceiling glass walls, an infinity-edge hot tub, and a dedicated gym space.',
                'price_per_night' => 500.00,
                'capacity'        => 5,
                'floor'           => 7,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Mini bar', 'Safe', 'Coffee machine', 'Bathrobe', 'Hot tub', 'Butler service', 'Private gym', 'Kitchen'],
                'images'          => [$luxImages[4], $luxImages[5], $luxImages[6]],
            ],
            [
                'name'            => '705',
                'type'            => 'penthouse',
                'description'     => 'Exclusive penthouse with a wrap-around terrace, a vintage wine cellar, and concierge-curated experiences.',
                'price_per_night' => 520.00,
                'capacity'        => 5,
                'floor'           => 7,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Mini bar', 'Safe', 'Coffee machine', 'Bathrobe', 'Terrace', 'Butler service', 'Wine cellar', 'Kitchen'],
                'images'          => [$luxImages[7], $luxImages[8], $luxImages[9]],
            ],
            [
                'name'            => '706',
                'type'            => 'penthouse',
                'description'     => 'Ultra-premium penthouse with dual master suites, a private spa room, and a helicopter-pad access terrace.',
                'price_per_night' => 560.00,
                'capacity'        => 6,
                'floor'           => 7,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Mini bar', 'Safe', 'Coffee machine', 'Bathrobe', 'Private spa', 'Butler service', 'Jacuzzi', 'Kitchen', 'Terrace'],
                'images'          => [$luxImages[0], $luxImages[1], $luxImages[2]],
            ],
            [
                'name'            => '707',
                'type'            => 'penthouse',
                'description'     => 'The crown jewel of the hotel — a two-storey penthouse with a rooftop infinity pool, private chef, and unrivalled 360° skyline views.',
                'price_per_night' => 600.00,
                'capacity'        => 6,
                'floor'           => 7,
                'is_available'    => true,
                'amenities'       => ['WiFi', 'TV', 'Air conditioning', 'Mini bar', 'Safe', 'Coffee machine', 'Bathrobe', 'Infinity pool', 'Private chef', 'Butler service', 'Jacuzzi', 'Kitchen', 'Rooftop terrace', 'Home cinema'],
                'images'          => [$luxImages[3], $luxImages[4], $luxImages[5]],
            ],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }

        $this->command->info('Rooms seeded successfully!');
    }
}
