{{-- Ini di views\dashboard.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
    <h1 class="mb-6 text-3xl font-bold text-gray-800">Dashboard</h1>

    <!-- Cards -->
    <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-3">
        <div class="p-6 bg-white border-l-4 border-blue-500 shadow-md rounded-2xl">
            <p class="mb-1 text-gray-600">Total Saldo</p>
            <p class="text-3xl font-bold text-blue-600">Rp {{ number_format($totalSaldo) }}</p>
        </div>
        <div class="p-6 bg-white border-l-4 border-green-500 shadow-md rounded-2xl">
            <p class="mb-1 text-gray-600">Pemasukan Bulan Ini</p>
            <p class="text-3xl font-bold text-green-600">Rp {{ number_format($pemasukan) }}</p>
        </div>
        <div class="p-6 bg-white border-l-4 border-red-500 shadow-md rounded-2xl">
            <p class="mb-1 text-gray-600">Pengeluaran Bulan Ini</p>
            <p class="text-3xl font-bold text-red-600">Rp {{ number_format($pengeluaran) }}</p>
        </div>
    </div>

    <!-- Grafik -->
    <div class="p-6 mb-8 bg-white shadow-md rounded-2xl">
        <h2 class="mb-4 text-2xl font-bold text-gray-800">Grafik Keuangan Bulanan</h2>
        <canvas id="grafikKeuangan" height="120"></canvas>
    </div>

    <!-- Tabel Transaksi -->
    <div class="p-6 bg-white shadow-md rounded-2xl">
        <h2 class="mb-4 text-2xl font-bold text-gray-800">Riwayat Transaksi Terakhir</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Jenis</th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Deskripsi</th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($riwayat as $trx)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                {{ $trx->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold
                                {{ $trx->jenis === 'pemasukan' ? 'text-green-600' : 'text-red-600' }}">
                                {{ ucfirst($trx->jenis) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">
                                {{ $trx->keterangan ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                Rp {{ number_format($trx->jumlah) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">Tidak ada transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('grafikKeuangan').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($bulan) !!}, // contoh: ['Jan', 'Feb', 'Mar']
            datasets: [
                {
                    label: 'Pemasukan',
                    backgroundColor: '#22c55e',
                    data: {!! json_encode($dataPemasukan) !!}, // array angka
                },
                {
                    label: 'Pengeluaran',
                    backgroundColor: '#ef4444',
                    data: {!! json_encode($dataPengeluaran) !!}, // array angka
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
