<?php

namespace App\Http\Controllers;

use App\Services\RoomService;
use App\Http\Resources\RoomResource;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RoomController extends Controller
{
    // Injektujemo RoomService kroz konstruktor
    // Laravel automatski kreira instancu - zove se Dependency Injection
    public function __construct(
        private RoomService $roomService
    ) {}

    /**
     * GET /api/rooms
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $rooms = $this->roomService->getAll($request->query());

        return RoomResource::collection($rooms);
    }

    /**
     * POST /api/rooms
     */
    public function store(StoreRoomRequest $request): RoomResource
    {
        $room = $this->roomService->create($request->validated());

        return new RoomResource($room);
    }

    /**
     * GET /api/rooms/{room}
     */
    public function show(Room $room): RoomResource
    {
        return new RoomResource(
            $this->roomService->getById($room)
        );
    }

    /**
     * PUT/PATCH /api/rooms/{room}
     */
    public function update(UpdateRoomRequest $request, Room $room): RoomResource
    {
        $room = $this->roomService->update($room, $request->validated());

        return new RoomResource($room);
    }

    /**
     * DELETE /api/rooms/{room}
     */
    public function destroy(Room $room): JsonResponse
    {
        $this->roomService->delete($room);

        return response()->json([
            'message' => 'Room deleted successfully.'
        ]);
    }
}
