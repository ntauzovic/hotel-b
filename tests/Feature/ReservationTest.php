<?php

namespace Tests\Feature;

use App\Models\Guest;
use App\Models\Room;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationTest extends TestCase
{
    use RefreshDatabase;

    // -----------------------------------------------
    // Helpers
    // -----------------------------------------------
    private function createGuest(array $overrides = []): Guest
    {
        static $counter = 1;
        return Guest::create(array_merge([
            'first_name'      => 'Test',
            'last_name'       => 'Guest',
            'email'           => 'guest' . $counter++ . '@example.com',
            'passport_number' => 'BA' . str_pad($counter, 7, '0', STR_PAD_LEFT),
        ], $overrides));
    }

    private function createRoom(array $overrides = []): Room
    {
        static $counter = 1;
        return Room::create(array_merge([
            'name'            => 'Room ' . $counter++,
            'type'            => 'single',
            'price_per_night' => 100.00,
            'capacity'        => 2,
            'is_available'    => true,
        ], $overrides));
    }

    private function createReservation(array $overrides = []): Reservation
    {
        $guest = $this->createGuest();
        $room  = $this->createRoom();

        return Reservation::create(array_merge([
            'guest_id'         => $guest->id,
            'room_id'          => $room->id,
            'check_in_date'    => '2026-08-01',
            'check_out_date'   => '2026-08-05',
            'status'           => 'pending',
            'number_of_guests' => 1,
            'total_price'      => 400.00,
            'notes'            => null,
        ], $overrides));
    }

    // -----------------------------------------------
    // GET /api/reservations
    // -----------------------------------------------

    /** @test */
    public function can_get_all_reservations(): void
    {
        $this->createReservation();
        $this->createReservation();

        $response = $this->getJson('/api/reservations');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => [
                             'id',
                             'guest',
                             'room',
                             'check_in_date',
                             'check_out_date',
                             'status',
                             'total_price',
                         ]
                     ],
                     'meta',
                     'links',
                 ]);
    }

    /** @test */
    public function can_filter_reservations_by_status(): void
    {
        $this->createReservation(['status' => 'confirmed']);
        $this->createReservation(['status' => 'pending']);

        $response = $this->getJson('/api/reservations?status=confirmed');

        $response->assertStatus(200);
        $data = $response->json('data');
        $this->assertCount(1, $data);
        $this->assertEquals('confirmed', $data[0]['status']);
    }

    /** @test */
    public function can_filter_reservations_by_guest(): void
    {
        $guest1 = $this->createGuest(['email' => 'filter1@example.com']);
        $guest2 = $this->createGuest(['email' => 'filter2@example.com']);
        $room   = $this->createRoom();

        Reservation::create([
            'guest_id' => $guest1->id, 'room_id' => $room->id,
            'check_in_date' => '2026-08-01', 'check_out_date' => '2026-08-03',
            'status' => 'pending', 'number_of_guests' => 1, 'total_price' => 200,
        ]);
        Reservation::create([
            'guest_id' => $guest2->id, 'room_id' => $room->id,
            'check_in_date' => '2026-09-01', 'check_out_date' => '2026-09-03',
            'status' => 'pending', 'number_of_guests' => 1, 'total_price' => 200,
        ]);

        $response = $this->getJson("/api/reservations?guest_id={$guest1->id}");

        $response->assertStatus(200);
        $data = $response->json('data');
        $this->assertCount(1, $data);
        $this->assertEquals($guest1->id, $data[0]['guest']['id']);
    }

    // -----------------------------------------------
    // GET /api/reservations/{id}
    // -----------------------------------------------

    /** @test */
    public function can_get_single_reservation(): void
    {
        $reservation = $this->createReservation();

        $response = $this->getJson("/api/reservations/{$reservation->id}");

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         'id', 'guest', 'room',
                         'check_in_date', 'check_out_date',
                         'status', 'total_price',
                     ]
                 ]);
    }

    /** @test */
    public function returns_404_for_nonexistent_reservation(): void
    {
        $response = $this->getJson('/api/reservations/999');

        $response->assertStatus(404);
    }

    // -----------------------------------------------
    // POST /api/reservations
    // -----------------------------------------------

    /** @test */
    public function can_create_reservation(): void
    {
        $guest = $this->createGuest();
        $room  = $this->createRoom();

        $data = [
            'guest_id'         => $guest->id,
            'room_id'          => $room->id,
            'check_in_date'    => '2026-09-01',
            'check_out_date'   => '2026-09-05',
            'number_of_guests' => 2,
            'total_price'      => 400.00,
        ];

        $response = $this->postJson('/api/reservations', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('reservations', [
            'guest_id' => $guest->id,
            'room_id'  => $room->id,
        ]);
    }

    /** @test */
    public function cannot_create_reservation_without_required_fields(): void
    {
        $response = $this->postJson('/api/reservations', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors([
                     'guest_id', 'room_id',
                     'check_in_date', 'check_out_date',
                     'number_of_guests', 'total_price',
                 ]);
    }

    /** @test */
    public function cannot_create_reservation_with_nonexistent_guest(): void
    {
        $room = $this->createRoom();

        $response = $this->postJson('/api/reservations', [
            'guest_id'         => 9999,
            'room_id'          => $room->id,
            'check_in_date'    => '2026-09-01',
            'check_out_date'   => '2026-09-05',
            'number_of_guests' => 1,
            'total_price'      => 400.00,
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['guest_id']);
    }

    /** @test */
    public function cannot_create_reservation_with_checkout_before_checkin(): void
    {
        $guest = $this->createGuest();
        $room  = $this->createRoom();

        $response = $this->postJson('/api/reservations', [
            'guest_id'         => $guest->id,
            'room_id'          => $room->id,
            'check_in_date'    => '2026-09-10',
            'check_out_date'   => '2026-09-05',
            'number_of_guests' => 1,
            'total_price'      => 400.00,
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['check_out_date']);
    }

    /** @test */
    public function cannot_create_reservation_with_invalid_status(): void
    {
        $guest = $this->createGuest();
        $room  = $this->createRoom();

        $response = $this->postJson('/api/reservations', [
            'guest_id'         => $guest->id,
            'room_id'          => $room->id,
            'check_in_date'    => '2026-09-01',
            'check_out_date'   => '2026-09-05',
            'status'           => 'invalid_status',
            'number_of_guests' => 1,
            'total_price'      => 400.00,
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['status']);
    }

    // -----------------------------------------------
    // PUT/PATCH /api/reservations/{id}
    // -----------------------------------------------

    /** @test */
    public function can_update_reservation(): void
    {
        $reservation = $this->createReservation();

        $response = $this->putJson("/api/reservations/{$reservation->id}", [
            'guest_id'         => $reservation->guest_id,
            'room_id'          => $reservation->room_id,
            'check_in_date'    => '2026-10-01',
            'check_out_date'   => '2026-10-07',
            'status'           => 'confirmed',
            'number_of_guests' => 2,
            'total_price'      => 600.00,
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'status'      => 'confirmed',
                     'total_price' => 600.00,
                 ]);
    }

    /** @test */
    public function can_partially_update_reservation(): void
    {
        $reservation = $this->createReservation(['status' => 'pending']);

        $response = $this->patchJson("/api/reservations/{$reservation->id}", [
            'status' => 'confirmed',
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['status' => 'confirmed']);
    }

    // -----------------------------------------------
    // DELETE /api/reservations/{id}
    // -----------------------------------------------

    /** @test */
    public function can_delete_reservation(): void
    {
        $reservation = $this->createReservation();

        $response = $this->deleteJson("/api/reservations/{$reservation->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Reservation deleted successfully.']);

        $this->assertSoftDeleted('reservations', ['id' => $reservation->id]);
    }

    /** @test */
    public function deleted_reservation_not_visible_in_list(): void
    {
        $reservation = $this->createReservation();
        $reservation->delete();

        $response = $this->getJson('/api/reservations');

        $data = $response->json('data');
        $this->assertCount(0, $data);
    }

    /** @test */
    public function returns_404_when_deleting_nonexistent_reservation(): void
    {
        $response = $this->deleteJson('/api/reservations/999');

        $response->assertStatus(404);
    }
}
