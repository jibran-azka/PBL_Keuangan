@extends('layouts.app')

@section('content')
<div class="max-w-2xl p-6 mx-auto mt-8 bg-white shadow-lg rounded-xl">
    <h2 class="mb-6 text-2xl font-semibold text-gray-800">Edit Transaksi</h2>

    <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-gray-700">Jenis</label>
            <select name="jenis" required class="w-full mt-1 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                <option value="pemasukan" {{ $transaksi->jenis == 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                <option value="pengeluaran" {{ $transaksi->jenis == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
            </select>
        </div>

        <div>
            <label class="block text-gray-700">Jumlah</label>
            <input type="number" name="jumlah" step="0.01" value="{{ $transaksi->jumlah }}" required class="w-full mt-1 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
        </div>

        <div>
            <label class="block text-gray-700">Keterangan</label>
            <input type="text" name="keterangan" value="{{ $transaksi->keterangan }}" class="w-full mt-1 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
        </div>

        {{-- <div>
            <label class="block text-gray-700">Akun</label>
            <select name="account_id" required class="w-full mt-1 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                @foreach ($accounts as $account)
                    <option value="{{ $account->id }}" {{ $transaksi->account_id == $account->id ? 'selected' : '' }}>
                        {{ $account->nama_akun }}
                    </option>
                @endforeach
            </select>
        </div> --}}

        <div>
            <label class="block text-gray-700">Tanggal</label>
            <input type="date" name="tanggal" value="{{ \Carbon\Carbon::parse($transaksi->tanggal)->format('Y-m-d') }}" required class="w-full mt-1 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 text-white transition bg-green-500 rounded-lg shadow-md hover:bg-green-600">
                Perbarui
            </button>
        </div>
    </form>
</div>
@endsection
