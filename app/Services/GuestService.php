<?php

namespace App\Services;

use App\Models\Guest;
use Illuminate\Pagination\LengthAwarePaginator;

class GuestService
{
    public function getAll(array $filters): LengthAwarePaginator
    {
        $query = Guest::query();

        // Filter po drzavi: ?country=Bosnia
        if (!empty($filters['country'])) {
            $query->where('country', $filters['country']);
        }

        // Filter po nacionalnosti: ?nationality=Bosnian
        if (!empty($filters['nationality'])) {
            $query->where('nationality', $filters['nationality']);
        }

        // Pretraga po imenu ili prezimenu: ?search=Marko
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('first_name', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('last_name', 'like', '%' . $filters['search'] . '%');
            });
        }

        // Pretraga po emailu: ?email=marko@example.com
        if (!empty($filters['email'])) {
            $query->where('email', $filters['email']);
        }

        return $query->orderBy('last_name')->orderBy('first_name')->paginate(15);
    }

    // Dohvati jednog gosta
    public function getById(Guest $guest): Guest
    {
        return $guest;
    }

    // Kreiraj gosta
    public function create(array $data): Guest
    {
        return Guest::create($data);
    }

    // Azuriraj gosta
    public function update(Guest $guest, array $data): Guest
    {
        $guest->update($data);
        return $guest;
    }

    // Obrisi gosta (soft delete)
    public function delete(Guest $guest): void
    {
        $guest->delete();
    }
}
