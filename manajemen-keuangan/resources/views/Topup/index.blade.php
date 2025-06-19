@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Daftar Top-Up</h2>

    <div class="overflow-x-auto bg-white shadow-md rounded-xl">
        <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-800">
            <thead class="bg-gray-100 text-gray-600">
                <tr>
                    <th class="px-6 py-3 text-left">Akun</th>
                    <th class="px-6 py-3 text-left">Nominal</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Waktu</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($topUps as $topup)
                <tr>
                    <td class="px-6 py-4">{{ $topup->account->nama_akun }}</td>
                    <td class="px-6 py-4">Rp{{ number_format($topup->amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-block px-2 py-1 rounded-full text-xs font-medium
                            {{ $topup->status === 'success' ? 'bg-green-100 text-green-600' : ($topup->status === 'pending' ? 'bg-yellow-100 text-yellow-600' : 'bg-red-100 text-red-600') }}">
                            {{ ucfirst($topup->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">{{ $topup->created_at->format('d-m-Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6 flex justify-end">
        <a href="{{ url()->previous() }}"
            class="text-sm text-gray-600 hover:text-gray-900 underline">
            ← Kembali
        </a>

    </div>
</div>
@endsection
