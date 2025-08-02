<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-xl font-bold mb-4">Tambah Booking</h1>
        @if ($errors->any())
            <article>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </article>
        @endif

        <form action="{{ route('bookings.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block font-medium">User ID</label>
                <input type="number" name="user_id" class="w-full border p-2 rounded" required>
            </div>

            {{-- <div class="mb-4">
                <label class="block font-medium">Room ID</label>
                <input type="number" name="room_id" class="w-full border p-2 rounded" required>
            </div> --}}

            <div class="mb-4">
                <label class="block font-medium">Room</label>
                <select name="room_id" id="room_id" required>
                    <option value="" disabled selected>-- Select Room --</option>
                    @if(!empty($rooms))
                        @foreach ($rooms as $room)
                            <option value="{{ $room['id'] }}">
                                {{ $room['name'] }}
                            </option>
                        @endforeach
                    @else
                            <option disable>Gagal memuat ruang....</option>
                    @endif
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Judul</label>
                <input type="text" name="title" class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Waktu Mulai</label>
                <input type="datetime-local" name="start_time" class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Waktu Selesai</label>
                <input type="datetime-local" name="end_time" class="w-full border p-2 rounded" required>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('bookings.index') }}" class="text-gray-600 hover:underline">← Kembali</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</body>
</html>
