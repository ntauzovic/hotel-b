<?php

namespace Tests\Feature;

use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoomTest extends TestCase
{
    use RefreshDatabase; // Svaki test dobija svjezu bazu

    // -----------------------------------------------
    // Helper - kreira jednu sobu za testiranje
    // -----------------------------------------------
    private function createRoom(array $overrides = []): Room
    {
        return Room::create(array_merge([
            'name'            => '101',
            'type'            => 'single',
            'description'     => 'Test soba',
            'price_per_night' => 75.00,
            'capacity'        => 1,
            'floor'           => 1,
            'is_available'    => true,
            'amenities'       => ['WiFi', 'TV'],
        ], $overrides));
    }

    // -----------------------------------------------
    // GET /api/rooms - lista soba
    // -----------------------------------------------

    /** @test */
    public function can_get_all_rooms(): void
    {
        $this->createRoom(['name' => '101']);
        $this->createRoom(['name' => '102', 'type' => 'double']);

        $response = $this->getJson('/api/rooms');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => [
                             'id',
                             'name',
                             'type',
                             'price_per_night',
                             'capacity',
                             'is_available',
                             'amenities',
                         ]
                     ],
                     'meta',
                     'links',
                 ]);
    }

    /** @test */
    public function can_filter_rooms_by_type(): void
    {
        $this->createRoom(['name' => '101', 'type' => 'single']);
        $this->createRoom(['name' => '201', 'type' => 'suite']);

        $response = $this->getJson('/api/rooms?type=suite');

        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertCount(1, $data);
        $this->assertEquals('suite', $data[0]['type']);
    }

    /** @test */
    public function can_filter_rooms_by_availability(): void
    {
        $this->createRoom(['name' => '101', 'is_available' => true]);
        $this->createRoom(['name' => '102', 'is_available' => false]);

        $response = $this->getJson('/api/rooms?available=true');

        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertCount(1, $data);
        $this->assertTrue($data[0]['is_available']);
    }

    /** @test */
    public function can_filter_rooms_by_capacity(): void
    {
        $this->createRoom(['name' => '101', 'capacity' => 1]);
        $this->createRoom(['name' => '102', 'capacity' => 4, 'type' => 'double']);

        $response = $this->getJson('/api/rooms?guests=3');

        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertCount(1, $data);
        $this->assertEquals(4, $data[0]['capacity']);
    }

    /** @test */
    public function can_filter_rooms_by_max_price(): void
    {
        $this->createRoom(['name' => '101', 'price_per_night' => 75.00]);
        $this->createRoom(['name' => '102', 'price_per_night' => 300.00, 'type' => 'suite']);

        $response = $this->getJson('/api/rooms?max_price=100');

        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertCount(1, $data);
        $this->assertEquals(75, $data[0]['price_per_night']);
    }

    // -----------------------------------------------
    // GET /api/rooms/{id} - jedna soba
    // -----------------------------------------------

    /** @test */
    public function can_get_single_room(): void
    {
        $room = $this->createRoom();

        $response = $this->getJson("/api/rooms/{$room->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'id'   => $room->id,
                     'name' => '101',
                     'type' => 'single',
                 ]);
    }

    /** @test */
    public function returns_404_for_nonexistent_room(): void
    {
        $response = $this->getJson('/api/rooms/999');

        $response->assertStatus(404);
    }

    // -----------------------------------------------
    // POST /api/rooms - kreiranje sobe
    // -----------------------------------------------

    /** @test */
    public function can_create_room(): void
    {
        $data = [
            'name'            => 'Penthouse',
            'type'            => 'suite',
            'description'     => 'Luksuzna soba',
            'price_per_night' => 450.00,
            'capacity'        => 4,
            'floor'           => 5,
            'amenities'       => ['WiFi', 'Jacuzzi'],
        ];

        $response = $this->postJson('/api/rooms', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment([
                     'name' => 'Penthouse',
                     'type' => 'suite',
                 ]);

        $this->assertDatabaseHas('rooms', ['name' => 'Penthouse']);
    }

    /** @test */
    public function cannot_create_room_without_required_fields(): void
    {
        $response = $this->postJson('/api/rooms', []);

        $response->assertStatus(422) // Unprocessable Entity
                 ->assertJsonValidationErrors(['name', 'type', 'price_per_night', 'capacity']);
    }

    /** @test */
    public function cannot_create_room_with_invalid_type(): void
    {
        $response = $this->postJson('/api/rooms', [
            'name'            => '101',
            'type'            => 'invalid_type',
            'price_per_night' => 75.00,
            'capacity'        => 1,
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['type']);
    }

    /** @test */
    public function cannot_create_duplicate_room_name(): void
    {
        $this->createRoom(['name' => '101']);

        $response = $this->postJson('/api/rooms', [
            'name'            => '101',
            'type'            => 'single',
            'price_per_night' => 75.00,
            'capacity'        => 1,
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }

    // -----------------------------------------------
    // PUT /api/rooms/{id} - update sobe
    // -----------------------------------------------

    /** @test */
    public function can_update_room(): void
    {
        $room = $this->createRoom();

        $response = $this->putJson("/api/rooms/{$room->id}", [
            'name'            => '101-updated',
            'type'            => 'double',
            'price_per_night' => 150.00,
            'capacity'        => 2,
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'name'            => '101-updated',
                     'type'            => 'double',
                     'price_per_night' => 150.00,
                 ]);

        $this->assertDatabaseHas('rooms', ['name' => '101-updated']);
    }

    /** @test */
    public function can_partially_update_room(): void
    {
        $room = $this->createRoom();

        $response = $this->patchJson("/api/rooms/{$room->id}", [
            'price_per_night' => 99.00,
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['price_per_night' => 99.00]);
    }

    // -----------------------------------------------
    // DELETE /api/rooms/{id} - brisanje sobe
    // -----------------------------------------------

    /** @test */
    public function can_delete_room(): void
    {
        $room = $this->createRoom();

        $response = $this->deleteJson("/api/rooms/{$room->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Room deleted successfully.']);

        // Provjeri da je soft deleted - postoji u bazi ali ima deleted_at
        $this->assertSoftDeleted('rooms', ['id' => $room->id]);
    }

    /** @test */
    public function deleted_room_not_visible_in_list(): void
    {
        $room = $this->createRoom();
        $room->delete();

        $response = $this->getJson('/api/rooms');

        $data = $response->json('data');
        $this->assertCount(0, $data);
    }

    // -----------------------------------------------
    // Images & new types
    // -----------------------------------------------

    /** @test */
    public function room_response_includes_images_field(): void
    {
        $room = $this->createRoom([
            'images' => [
                'https://images.unsplash.com/photo-1?w=800',
                'https://images.unsplash.com/photo-2?w=800',
                'https://images.unsplash.com/photo-3?w=800',
            ],
        ]);

        $response = $this->getJson("/api/rooms/{$room->id}");

        $response->assertStatus(200)
                 ->assertJsonStructure(['data' => ['images']]);
        $this->assertIsArray($response->json('data.images'));
        $this->assertCount(3, $response->json('data.images'));
    }

    /** @test */
    public function can_create_room_with_images(): void
    {
        $response = $this->postJson('/api/rooms', [
            'name'            => '801',
            'type'            => 'penthouse',
            'price_per_night' => 500.00,
            'capacity'        => 4,
            'images'          => [
                'https://images.unsplash.com/photo-1?w=800',
                'https://images.unsplash.com/photo-2?w=800',
                'https://images.unsplash.com/photo-3?w=800',
            ],
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('rooms', ['name' => '801', 'type' => 'penthouse']);
        $this->assertIsArray($response->json('data.images'));
        $this->assertCount(3, $response->json('data.images'));
    }

    /** @test */
    public function can_filter_rooms_by_floor(): void
    {
        $this->createRoom(['name' => '701', 'floor' => 7, 'type' => 'penthouse']);
        $this->createRoom(['name' => '301', 'floor' => 3]);

        $response = $this->getJson('/api/rooms?floor=7');

        $response->assertStatus(200);
        $data = $response->json('data');
        $this->assertCount(1, $data);
        $this->assertEquals(7, $data[0]['floor']);
    }

    /** @test */
    public function can_create_room_with_new_types(): void
    {
        $types = ['standard', 'superior', 'deluxe', 'junior_suite', 'penthouse'];

        foreach ($types as $index => $type) {
            $response = $this->postJson('/api/rooms', [
                'name'            => 'Room-' . $index,
                'type'            => $type,
                'price_per_night' => 100.00,
                'capacity'        => 2,
            ]);
            $response->assertStatus(201, "Failed for type: {$type}");
        }
    }
}
