@extends('layouts.app')

@section('content')
<div class="py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
    <div class="p-6 bg-white shadow dark:bg-gray-800 sm:rounded-lg">
        <h2 class="mb-4 text-2xl font-semibold text-gray-900 dark:text-white">Laporan Transaksi</h2>

        <form method="GET" action="{{ route('laporan.index') }}" class="flex flex-wrap gap-4 mb-6">
            <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}" class="border-gray-300 rounded" />
            <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="border-gray-300 rounded" />
            <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Filter</button>
        </form>

        <div class="flex gap-4 mb-4">
            <a href="{{ route('laporan.pdf', request()->all()) }}" class="px-4 py-2 text-sm text-white bg-red-600 rounded hover:bg-red-700">Download PDF</a>
            <a href="{{ route('laporan.excel', request()->all()) }}" class="px-4 py-2 text-sm text-white bg-green-600 rounded hover:bg-green-700">Download Excel</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse table-auto">
                <thead>
                    <tr class="text-left bg-gray-200 dark:bg-gray-700">
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Jenis</th>
                        <th class="px-4 py-2">Jumlah</th>
                        <th class="px-4 py-2">Keterangan</th>
                        <th class="px-4 py-2">Akun</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800 dark:text-gray-200">
                    @foreach ($transactions as $t)
                        <tr class="border-b border-gray-300 dark:border-gray-700">
                            <td class="px-4 py-2">{{ $t->tanggal }}</td>
                            <td class="px-4 py-2 capitalize">{{ $t->jenis }}</td>
                            <td class="px-4 py-2">Rp{{ number_format($t->jumlah, 0, ',', '.') }}</td>
                            <td class="px-4 py-2">{{ $t->keterangan }}</td>
                            <td class="px-4 py-2">{{ $t->account->nama_akun }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
