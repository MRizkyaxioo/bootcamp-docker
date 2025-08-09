<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class BookingController extends Controller
{
   public function index()
{
    $bookings = Booking::all();
    $token = config('services.ruangan.token');

    // Ambil semua rooms dari API
    $roomMap = [];
    // $response = Http::get('http://layanan-ruangan-nginx/api/rooms');
    $response = Http::withToken($token)->timeout(60)->get('http://layanan-ruangan-nginx/api/rooms');
    if ($response->successful()) {
        foreach ($response->json() as $room) {
            $roomMap[$room['id']] = $room['name'];
        }
    }

    return view('bookings.index', compact('bookings', 'roomMap'));
}

public function create()
{
    // return view('bookings.create'); // buat view create nanti
    $token = config('services.ruangan.token');
    //$response = Http::get('http://layanan-ruangan-nginx/api/rooms');
    $response = Http::withToken($token)->timeout(60)->get('http://layanan-ruangan-nginx/api/rooms');
    $rooms = [];
    if ($response->successful()) {
        $rooms = $response->json();
    }
    return view('bookings.create', ['rooms' => $rooms]);
}

public function store(Request $request)
{
    $validated = $request->validate([
        'user_id' => 'required|integer',
        'room_id' => 'required|integer',
        'title' => 'required|string',
        'start_time' => 'required|date',
        'end_time' => 'required|date|after_or_equal:start_time',
    ]);
    $token = config('services.ruangan.token');
    $response = Http::withToken($token)->timeout(60)->get('http://layanan-ruangan-nginx/api/rooms/'. $validated['room_id']);
    // $response = Http::get("http://layanan-ruangan-nginx/api/rooms/");

    if ($response->failed()) {
        return back()->withErrors(['room_id' => 'Room tidak ada atau tidak valid'])->withInput();
    }

    // $room = $response->json();
    // $nameRoom = $room['name'];

    $conflict = Booking::where('room_id', $validated['room_id'])
        ->where(function ($query) use ($validated) {
            $query->where('start_time', '<', $validated['end_time'])
                  ->where('end_time', '>', $validated['start_time']);
        })
        ->exists();

    if ($conflict) {
        return back()->withErrors([
            'start_time' => 'This room is already booked at this time.'
        ])->withInput();
    }

    Booking::create([
        'user_id' => $validated['user_id'],
        'room_id' => $validated['room_id'],
        'title' => $validated['title'],
        'start_time' => $validated['start_time'],
        'end_time' => $validated['end_time']
    ]);
    return redirect()->route('bookings.index')->with('success', 'Successfully saved.');
}

public function edit($id)
{
    $booking = Booking::findOrFail($id);

    $token = config('services.ruangan.token');
    //$response = Http::get('http://layanan-ruangan-nginx/api/rooms');
    $response = Http::withToken($token)->timeout(60)->get('http://layanan-ruangan-nginx/api/rooms');
    $rooms = [];

    if ($response->successful()) {
        $rooms = $response->json();
    }

    return view('bookings.edit', compact('booking', 'rooms'));
}

public function update(Request $request, $id)
{
   $booking = Booking::findOrFail($id);

    $validated = $request->validate([
        'user_id' => 'required|integer',
        'room_id' => 'required|integer',
        'title' => 'required|string',
        'start_time' => 'required|date',
        'end_time' => 'required|date|after_or_equal:start_time',
    ]);

    $token = config('services.ruangan.token');
    $response = Http::withToken($token)->timeout(60)->get('http://layanan-ruangan-nginx/api/rooms/'. $validated['room_id']);
    // $response = Http::get("http://layanan-ruangan-nginx/api/rooms/" . $validated['room_id']);

        if ($response->failed()) {
        return back()->withErrors(['room_id' => 'Room tidak ada atau tidak valid'])->withInput();
    }


    // $booking->update([
    //     'user_id' => $validated['user_id'],
    //     'room_id' => $validated['room_id'],
    //     'title' => $validated['title'],
    //     'start_time' => $validated['start_time'],
    //     'end_time' => $validated['end_time'],
    // ]);

    $conflict = Booking::where('room_id', $validated['room_id'])
        ->where('id', '!=', $id)
        ->where(function ($query) use ($validated) {
            $query->where('start_time', '<', $validated['end_time'])
                  ->where('end_time', '>', $validated['start_time']);
        })
        ->exists();

    if ($conflict) {
        return back()->withErrors([
            'start_time' => 'This room is already booked at this time.'
        ])->withInput();
    }

    $booking->update($validated);

    return redirect()->route('bookings.index')->with('success', 'Changes saved successfully.');
}

public function destroy($id)
{
    Booking::findOrFail($id)->delete();
    return redirect()->route('bookings.index')->with('success', 'Successfully deleted.');
}
}
