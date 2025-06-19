@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-4">
    <h1 class="text-xl font-bold mb-4">Daftar Tagihan</h1>

    <div class="mb-4 text-right">
        <a href="{{ route('tagihan.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Tambah Tagihan
        </a>
    </div>

    <table class="w-full border border-gray-300 text-center">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2">Nama Tagihan</th>
                <th class="border px-4 py-2">Nominal</th>
                <th class="border px-4 py-2">Akun</th>
                <th class="border px-4 py-2">Jatuh Tempo</th>
                <th class="border px-4 py-2">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tagihans as $tagihan)
                <tr class="border-t">
                    <td class="border px-4 py-2">{{ $tagihan->nama }}</td>
                    <td class="border px-4 py-2">Rp {{ number_format($tagihan->nominal, 0, ',', '.') }}</td>
                    <td class="border px-4 py-2">{{ $tagihan->account->nama_akun }}</td>
                    <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($tagihan->tanggal_jatuh_tempo)->format('d M Y') }}</td>
                    <td class="border px-4 py-2">{{ ucfirst($tagihan->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4">Belum ada tagihan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
