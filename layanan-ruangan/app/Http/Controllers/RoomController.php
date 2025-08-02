<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Room::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       // Validasi input dari client
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'capacity' => 'required|integer|min:1',
        'facilities' => 'nullable|string'
    ]);

       $room = Room::create($validated);

       return response()->json($room, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        return $room;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
         // Validasi input dari client
        $validated = $request->validate([
        'name' => 'sometimes|required|string|max:255',
        'capacity' => 'sometimes|required|integer|min:1',
        'facilities' => 'sometimes|nullable|string'
    ]);

       $room->update($validated);

       return response()->json($room, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $room->delete();
        return response()->json(null, 204);
    }
}
