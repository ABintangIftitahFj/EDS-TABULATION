<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with(['tournament', 'matches'])->paginate(20);
        return response()->json($rooms);
    }

    public function show($id)
    {
        $room = Room::with(['tournament', 'matches'])->findOrFail($id);
        return response()->json($room);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tournament_id' => 'required|exists:tournaments,id',
            'name' => 'required|string',
            'location' => 'nullable|string',
            'is_active' => 'boolean',
            'capacity' => 'nullable|integer',
        ]);
        $room = Room::create($data);
        return response()->json($room, 201);
    }

    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);
        $data = $request->validate([
            'name' => 'sometimes|string',
            'location' => 'nullable|string',
            'is_active' => 'boolean',
            'capacity' => 'nullable|integer',
        ]);
        $room->update($data);
        return response()->json($room);
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();
        return response()->json(['message' => 'Room deleted']);
    }
}
