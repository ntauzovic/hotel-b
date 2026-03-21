<?php

namespace App\Services;

use App\Models\Room;
use Illuminate\Pagination\LengthAwarePaginator;

class RoomService
{
    public function getAll(array $filters): LengthAwarePaginator
    {
        $query = Room::query();

        // Višestruki spratovi: ?floor=1,2,3
        if (!empty($filters['floor'])) {
            $floors = array_map('intval', explode(',', $filters['floor']));
            $query->whereIn('floor', $floors);
        }

        // Višestruki tipovi: ?type=single,double,suite
        if (!empty($filters['type'])) {
            $types = explode(',', $filters['type']);
            $query->whereIn('type', $types);
        }

        // Status: ?status=available,occupied,maintenance
        if (!empty($filters['status'])) {
            $statuses = explode(',', $filters['status']);
            $hasAvailable  = in_array('available', $statuses);
            $hasUnavailable = in_array('occupied', $statuses) || in_array('maintenance', $statuses);

            if ($hasAvailable && !$hasUnavailable) {
                $query->where('is_available', true);
            } elseif (!$hasAvailable && $hasUnavailable) {
                $query->where('is_available', false);
            }
            // ako su oba selektovana — nema filtera
        }

        // Min cijena: ?min=100
        if (!empty($filters['min'])) {
            $query->where('price_per_night', '>=', (float) $filters['min']);
        }

        // Max cijena: ?max=500
        if (!empty($filters['max'])) {
            $query->where('price_per_night', '<=', (float) $filters['max']);
        }

        $perPage = isset($filters['per_page']) ? min((int) $filters['per_page'], 50) : 12;

        return $query->orderBy('floor')->orderBy('name')->paginate($perPage);
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
