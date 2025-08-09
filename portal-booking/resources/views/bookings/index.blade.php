<!-- resources/views/bookings/index.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Booking Ruang Rapat</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

@if (session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
        {{ session('success') }}
    </div>
@endif


<body class="bg-gray-100 p-6">
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Daftar Booking</h1>

        <a href="{{ route('bookings.create') }}" class="mb-4 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            + Tambah Booking
        </a>

        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="px-4 py-2">User ID</th>
                    <th class="px-4 py-2">Room</th>
                    <th class="px-4 py-2">Judul</th>
                    <th class="px-4 py-2">Mulai</th>
                    <th class="px-4 py-2">Selesai</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $booking)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $booking->user_id }}</td>
                        <td class="px-4 py-2">{{ $roomMap[$booking->room_id] ?? 'Tidak ditemukan' }}</td>
                        <td class="px-4 py-2">{{ $booking->title }}</td>
                        <td class="px-4 py-2">{{ $booking->start_time }}</td>
                        <td class="px-4 py-2">{{ $booking->end_time }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('bookings.edit', $booking->id) }}" class="text-blue-600 hover:underline">Edit</a> |
                            <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin ingin menghapus?')" class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
