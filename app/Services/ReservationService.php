<?php

namespace App\Services;

use App\Models\Reservation;
use Illuminate\Pagination\LengthAwarePaginator;

class ReservationService
{
    public function getAll(array $filters): LengthAwarePaginator
    {
        $query = Reservation::with(['guest', 'room']);

        // Filter po statusu: ?status=confirmed
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Filter po gostu: ?guest_id=1
        if (!empty($filters['guest_id'])) {
            $query->where('guest_id', $filters['guest_id']);
        }

        // Filter po sobi: ?room_id=1
        if (!empty($filters['room_id'])) {
            $query->where('room_id', $filters['room_id']);
        }

        // Filter po datumu check-in: ?check_in_date=2026-06-01
        if (!empty($filters['check_in_date'])) {
            $query->whereDate('check_in_date', $filters['check_in_date']);
        }

        return $query->orderBy('check_in_date')->paginate(15);
    }

    // Dohvati jednu rezervaciju
    public function getById(Reservation $reservation): Reservation
    {
        return $reservation->load(['guest', 'room']);
    }

    // Kreiraj rezervaciju
    public function create(array $data): Reservation
    {
        $reservation = Reservation::create($data);
        return $reservation->load(['guest', 'room']);
    }

    // Azuriraj rezervaciju
    public function update(Reservation $reservation, array $data): Reservation
    {
        $reservation->update($data);
        return $reservation->load(['guest', 'room']);
    }

    // Obrisi rezervaciju (soft delete)
    public function delete(Reservation $reservation): void
    {
        $reservation->delete();
    }
}
