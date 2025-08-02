<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-xl font-bold mb-4">Edit Booking</h1>

        <form action="{{ route('bookings.update', $booking->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-medium">User ID</label>
                <input type="number" name="user_id" class="w-full border p-2 rounded" value="{{ $booking->user_id }}" required>
            </div>

<div class="mb-4">
    <label class="block font-medium">Room</label>
    <select name="room_id" id="room_id" required class="w-full border p-2 rounded">
        <option value="" disabled>-- Pilih Ruangan --</option>
        @if(!empty($rooms))
            @foreach ($rooms as $room)
                <option value="{{ $room['id'] }}" {{ $room['id'] == $booking->room_id ? 'selected' : '' }}>
                    {{ $room['name'] }}
                </option>
            @endforeach
        @else
            <option disabled>Gagal memuat ruang....</option>
        @endif
    </select>
</div>


            <div class="mb-4">
                <label class="block font-medium">Judul</label>
                <input type="text" name="title" class="w-full border p-2 rounded" value="{{ $booking->title }}" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Waktu Mulai</label>
                <input type="datetime-local" name="start_time" class="w-full border p-2 rounded"
                       value="{{ \Carbon\Carbon::parse($booking->start_time)->format('Y-m-d\TH:i') }}" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Waktu Selesai</label>
                <input type="datetime-local" name="end_time" class="w-full border p-2 rounded"
                       value="{{ \Carbon\Carbon::parse($booking->end_time)->format('Y-m-d\TH:i') }}" required>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('bookings.index') }}" class="text-gray-600 hover:underline">← Batal</a>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Update</button>
            </div>
        </form>
    </div>
</body>
</html>
