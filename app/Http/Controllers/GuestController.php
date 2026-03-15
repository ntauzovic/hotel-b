<?php

namespace App\Http\Controllers;

use App\Services\GuestService;
use App\Http\Resources\GuestResource;
use App\Http\Requests\StoreGuestRequest;
use App\Http\Requests\UpdateGuestRequest;
use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GuestController extends Controller
{
    // Injektujemo GuestService kroz konstruktor
    public function __construct(
        private GuestService $guestService
    ) {}

    /**
     * GET /api/guests
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $guests = $this->guestService->getAll($request->query());

        return GuestResource::collection($guests);
    }

    /**
     * POST /api/guests
     */
    public function store(StoreGuestRequest $request): GuestResource
    {
        $guest = $this->guestService->create($request->validated());

        return new GuestResource($guest);
    }

    /**
     * GET /api/guests/{guest}
     */
    public function show(Guest $guest): GuestResource
    {
        return new GuestResource(
            $this->guestService->getById($guest)
        );
    }

    /**
     * PUT/PATCH /api/guests/{guest}
     */
    public function update(UpdateGuestRequest $request, Guest $guest): GuestResource
    {
        $guest = $this->guestService->update($guest, $request->validated());

        return new GuestResource($guest);
    }

    /**
     * DELETE /api/guests/{guest}
     */
    public function destroy(Guest $guest): JsonResponse
    {
        $this->guestService->delete($guest);

        return response()->json([
            'message' => 'Guest deleted successfully.'
        ]);
    }
}
