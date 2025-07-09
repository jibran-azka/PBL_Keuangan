@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Daftar Tagihan</h2>

    <div class="mb-4">
        <a href="{{ route('tagihan.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Tambah Tagihan
        </a>
    </div>

    <div class="overflow-x-auto bg-white shadow-md rounded-xl">
        <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-800">
            <thead class="bg-gray-100 text-gray-600">
                <tr>
                    <th class="px-6 py-3 text-left">Nama Tagihan</th>
                    <th class="px-6 py-3 text-left">Nominal</th>
                    <th class="px-6 py-3 text-left">Tanggal Transfer</th>
                    <th class="px-6 py-3 text-left">Status Reminder</th>
                    <th class="px-6 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($tagihans as $tagihan)
                <tr>
                    <td class="px-6 py-4">{{ $tagihan->nama }}</td>
                    <td class="px-6 py-4">Rp {{ number_format($tagihan->nominal, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">{{ $tagihan->tanggal_transfer->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        @if ($tagihan->sudah_dikirim)
                            <span class="inline-block bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Sudah Diingatkan</span>
                        @elseif (\Carbon\Carbon::parse($tagihan->tanggal_transfer)->isToday())
                            <span class="inline-block bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full">Jatuh Tempo Hari Ini</span>
                        @else
                            <span class="inline-block bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">Belum Diingatkan</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <form action="{{ route('tagihan.destroy', $tagihan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus tagihan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-xs">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-6 text-gray-500">Belum ada tagihan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
