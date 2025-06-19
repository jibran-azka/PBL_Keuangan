@extends('layouts.app')

@section('content')
<div class="max-w-5xl px-4 py-8 mx-auto">
    <h2 class="mb-6 text-2xl font-semibold text-gray-800">Akun Keuangan</h2>

    @php
        $account = $accounts->first();
    @endphp

    @if ($account)
        <!-- Tombol Top Up dan Riwayat -->
        <div class="mb-4 flex gap-4">
            <a href="{{ route('topup.create', ['account_id' => $account->id]) }}"
               class="px-4 py-2 text-sm text-white bg-green-500 rounded hover:bg-green-600">
                Top Up
            </a>
            <a href="{{ route('topup.index') }}"
               class="px-4 py-2 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600">
                Riwayat Top Up
            </a>
        </div>

        <!-- Tabel Akun -->
        <div class="overflow-x-auto bg-white shadow-md rounded-xl">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="text-sm text-left text-gray-700 bg-gray-100">
                    <tr>
                        <th class="px-6 py-3">Nama Akun</th>
                        <th class="px-6 py-3">Saldo</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-800 bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4">{{ $account->nama_akun }}</td>
                        <td class="px-6 py-4">
                            Rp{{ number_format($account->saldo, 0, ',', '.') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    @else
        <div class="p-4 bg-yellow-100 text-yellow-800 rounded">
            Belum ada akun keuangan. Silakan <a href="{{ route('akun.create') }}" class="underline font-semibold">buat akun</a> terlebih dahulu.
        </div>
    @endif
</div>
@endsection
