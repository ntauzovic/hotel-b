<?php

namespace App\Http\Controllers;

use App\Services\ReservationService;
use App\Http\Resources\ReservationResource;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReservationController extends Controller
{
    public function __construct(
        private ReservationService $reservationService
    ) {}

    /**
     * GET /api/reservations
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $reservations = $this->reservationService->getAll($request->query());

        return ReservationResource::collection($reservations);
    }

    /**
     * POST /api/reservations
     */
    public function store(StoreReservationRequest $request): JsonResponse
    {
        $reservation = $this->reservationService->create($request->validated());

        return (new ReservationResource($reservation))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * GET /api/reservations/{reservation}
     */
    public function show(Reservation $reservation): ReservationResource
    {
        return new ReservationResource(
            $this->reservationService->getById($reservation)
        );
    }

    /**
     * PUT/PATCH /api/reservations/{reservation}
     */
    public function update(UpdateReservationRequest $request, Reservation $reservation): ReservationResource
    {
        $reservation = $this->reservationService->update($reservation, $request->validated());

        return new ReservationResource($reservation);
    }

    /**
     * DELETE /api/reservations/{reservation}
     */
    public function destroy(Reservation $reservation): JsonResponse
    {
        $this->reservationService->delete($reservation);

        return response()->json([
            'message' => 'Reservation deleted successfully.'
        ]);
    }
}
