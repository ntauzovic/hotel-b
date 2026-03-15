<?php

namespace Tests\Feature;

use App\Models\Guest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuestTest extends TestCase
{
    use RefreshDatabase; // Svaki test dobija svjezu bazu

    // -----------------------------------------------
    // Helper - kreira jednog gosta za testiranje
    // -----------------------------------------------
    private function createGuest(array $overrides = []): Guest
    {
        return Guest::create(array_merge([
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
            'notes'           => null,
        ], $overrides));
    }

    // -----------------------------------------------
    // GET /api/guests - lista gostiju
    // -----------------------------------------------

    /** @test */
    public function can_get_all_guests(): void
    {
        $this->createGuest(['email' => 'guest1@example.com', 'passport_number' => 'AA111111']);
        $this->createGuest(['email' => 'guest2@example.com', 'passport_number' => 'BB222222']);

        $response = $this->getJson('/api/guests');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => [
                             'id',
                             'first_name',
                             'last_name',
                             'email',
                             'phone',
                             'nationality',
                             'country',
                         ]
                     ],
                     'meta',
                     'links',
                 ]);
    }

    /** @test */
    public function can_filter_guests_by_country(): void
    {
        $this->createGuest([
            'email'           => 'ba@example.com',
            'passport_number' => 'BA1111111',
            'country'         => 'Bosnia and Herzegovina',
        ]);
        $this->createGuest([
            'email'           => 'hr@example.com',
            'passport_number' => 'HR2222222',
            'country'         => 'Croatia',
        ]);

        $response = $this->getJson('/api/guests?country=Croatia');

        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertCount(1, $data);
        $this->assertEquals('Croatia', $data[0]['country']);
    }

    /** @test */
    public function can_filter_guests_by_nationality(): void
    {
        $this->createGuest([
            'email'           => 'bosnian@example.com',
            'passport_number' => 'BA3333333',
            'nationality'     => 'Bosnian',
        ]);
        $this->createGuest([
            'email'           => 'german@example.com',
            'passport_number' => 'DE4444444',
            'nationality'     => 'German',
        ]);

        $response = $this->getJson('/api/guests?nationality=German');

        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertCount(1, $data);
        $this->assertEquals('German', $data[0]['nationality']);
    }

    /** @test */
    public function can_search_guests_by_name(): void
    {
        $this->createGuest([
            'first_name'      => 'Marko',
            'last_name'       => 'Petrovic',
            'email'           => 'marko@example.com',
            'passport_number' => 'BA5555555',
        ]);
        $this->createGuest([
            'first_name'      => 'Ana',
            'last_name'       => 'Horvat',
            'email'           => 'ana@example.com',
            'passport_number' => 'HR6666666',
        ]);

        $response = $this->getJson('/api/guests?search=Marko');

        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertCount(1, $data);
        $this->assertEquals('Marko', $data[0]['first_name']);
    }

    /** @test */
    public function can_search_guests_by_last_name(): void
    {
        $this->createGuest([
            'first_name'      => 'Marko',
            'last_name'       => 'Petrovic',
            'email'           => 'marko@example.com',
            'passport_number' => 'BA7777777',
        ]);
        $this->createGuest([
            'first_name'      => 'Ana',
            'last_name'       => 'Horvat',
            'email'           => 'ana@example.com',
            'passport_number' => 'HR8888888',
        ]);

        $response = $this->getJson('/api/guests?search=Horvat');

        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertCount(1, $data);
        $this->assertEquals('Horvat', $data[0]['last_name']);
    }

    // -----------------------------------------------
    // GET /api/guests/{id} - jedan gost
    // -----------------------------------------------

    /** @test */
    public function can_get_single_guest(): void
    {
        $guest = $this->createGuest();

        $response = $this->getJson("/api/guests/{$guest->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'id'         => $guest->id,
                     'first_name' => 'Marko',
                     'last_name'  => 'Petrovic',
                     'email'      => 'marko.petrovic@example.com',
                 ]);
    }

    /** @test */
    public function returns_404_for_nonexistent_guest(): void
    {
        $response = $this->getJson('/api/guests/999');

        $response->assertStatus(404);
    }

    // -----------------------------------------------
    // POST /api/guests - kreiranje gosta
    // -----------------------------------------------

    /** @test */
    public function can_create_guest(): void
    {
        $data = [
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
        ];

        $response = $this->postJson('/api/guests', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment([
                     'first_name' => 'James',
                     'last_name'  => 'Wilson',
                     'email'      => 'james.wilson@example.com',
                 ]);

        $this->assertDatabaseHas('guests', ['email' => 'james.wilson@example.com']);
    }

    /** @test */
    public function cannot_create_guest_without_required_fields(): void
    {
        $response = $this->postJson('/api/guests', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['first_name', 'last_name', 'email']);
    }

    /** @test */
    public function cannot_create_guest_with_invalid_email(): void
    {
        $response = $this->postJson('/api/guests', [
            'first_name' => 'Test',
            'last_name'  => 'User',
            'email'      => 'not-a-valid-email',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function cannot_create_guest_with_duplicate_email(): void
    {
        $this->createGuest(['email' => 'duplicate@example.com']);

        $response = $this->postJson('/api/guests', [
            'first_name' => 'Drugi',
            'last_name'  => 'Gost',
            'email'      => 'duplicate@example.com',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function cannot_create_guest_with_duplicate_passport_number(): void
    {
        $this->createGuest(['passport_number' => 'BA1234567']);

        $response = $this->postJson('/api/guests', [
            'first_name'      => 'Drugi',
            'last_name'       => 'Gost',
            'email'           => 'novi@example.com',
            'passport_number' => 'BA1234567',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['passport_number']);
    }

    /** @test */
    public function cannot_create_guest_with_future_date_of_birth(): void
    {
        $response = $this->postJson('/api/guests', [
            'first_name'    => 'Test',
            'last_name'     => 'User',
            'email'         => 'test@example.com',
            'date_of_birth' => '2099-01-01',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['date_of_birth']);
    }

    // -----------------------------------------------
    // PUT /api/guests/{id} - update gosta
    // -----------------------------------------------

    /** @test */
    public function can_update_guest(): void
    {
        $guest = $this->createGuest();

        $response = $this->putJson("/api/guests/{$guest->id}", [
            'first_name' => 'Marko',
            'last_name'  => 'Markovic',
            'email'      => 'marko.markovic@example.com',
            'city'       => 'Mostar',
            'country'    => 'Bosnia and Herzegovina',
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'last_name' => 'Markovic',
                     'email'     => 'marko.markovic@example.com',
                     'city'      => 'Mostar',
                 ]);

        $this->assertDatabaseHas('guests', ['email' => 'marko.markovic@example.com']);
    }

    /** @test */
    public function can_partially_update_guest(): void
    {
        $guest = $this->createGuest();

        $response = $this->patchJson("/api/guests/{$guest->id}", [
            'phone' => '+387 65 999 000',
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['phone' => '+387 65 999 000']);
    }

    /** @test */
    public function cannot_update_guest_email_to_existing_one(): void
    {
        $guest1 = $this->createGuest(['email' => 'guest1@example.com', 'passport_number' => 'BA0000001']);
        $guest2 = $this->createGuest(['email' => 'guest2@example.com', 'passport_number' => 'BA0000002']);

        $response = $this->patchJson("/api/guests/{$guest2->id}", [
            'email' => 'guest1@example.com',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email']);
    }

    // -----------------------------------------------
    // DELETE /api/guests/{id} - brisanje gosta
    // -----------------------------------------------

    /** @test */
    public function can_delete_guest(): void
    {
        $guest = $this->createGuest();

        $response = $this->deleteJson("/api/guests/{$guest->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Guest deleted successfully.']);

        // Provjeri da je soft deleted - postoji u bazi ali ima deleted_at
        $this->assertSoftDeleted('guests', ['id' => $guest->id]);
    }

    /** @test */
    public function deleted_guest_not_visible_in_list(): void
    {
        $guest = $this->createGuest();
        $guest->delete();

        $response = $this->getJson('/api/guests');

        $data = $response->json('data');
        $this->assertCount(0, $data);
    }

    /** @test */
    public function returns_404_when_deleting_nonexistent_guest(): void
    {
        $response = $this->deleteJson('/api/guests/999');

        $response->assertStatus(404);
    }
}
