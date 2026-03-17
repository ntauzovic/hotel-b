<?php

namespace App\Services;

use App\Models\Room;
use Illuminate\Pagination\LengthAwarePaginator;

class RoomService
{
    public function getAll(array $filters): LengthAwarePaginator
    {
        $query = Room::query();

        // Filter po dostupnosti: ?available=true
        if (isset($filters['available'])) {
            $query->where('is_available', filter_var($filters['available'], FILTER_VALIDATE_BOOLEAN));
        }

        // Filter po tipu: ?type=suite
        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        // Filter po kapacitetu: ?guests=2
        if (!empty($filters['guests'])) {
            $query->where('capacity', '>=', (int) $filters['guests']);
        }

        // Filter po spratu: ?floor=7
        if (!empty($filters['floor'])) {
            $query->where('floor', (int) $filters['floor']);
        }

        // Filter po max cijeni: ?max_price=150
        if (!empty($filters['max_price'])) {
            $query->where('price_per_night', '<=', $filters['max_price']);
        }

        return $query->orderBy('name')->paginate(15);
    }

    // Dohvati jednu sobu
    public function getById(Room $room): Room
    {
        return $room;
    }

    // Kreiraj sobu
    public function create(array $data): Room
    {
        return Room::create($data);
    }

    // Azuriraj sobu
    public function update(Room $room, array $data): Room
    {
        $room->update($data);
        return $room;
    }

    // Obrisi sobu (soft delete)
    public function delete(Room $room): void
    {
        $room->delete();
    }
}
