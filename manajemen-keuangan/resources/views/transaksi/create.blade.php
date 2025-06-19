@extends('layouts.app')

@section('content')
<div class="max-w-2xl p-6 mx-auto mt-8 bg-white shadow-lg rounded-xl">
    <h2 class="mb-6 text-2xl font-semibold text-gray-800">Tambah Transaksi</h2>

    <form action="{{ route('transaksi.store') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label class="block text-gray-700">Jenis</label>
            <select name="jenis" required class="w-full mt-1 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                <option value="pemasukan">Pemasukan</option>
                <option value="pengeluaran">Pengeluaran</option>
            </select>
        </div>

        <div>
            <label class="block text-gray-700">Jumlah</label>
            <input type="number" name="jumlah" step="0.01" required class="w-full mt-1 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
        </div>

        <div>
            <label class="block text-gray-700">Keterangan</label>
            <input type="text" name="keterangan" class="w-full mt-1 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
        </div>

        <div>
            <label class="block text-gray-700">Akun</label>
            <select name="account_id" required class="w-full mt-1 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                @foreach ($accounts as $account)
                    <option value="{{ $account->id }}">{{ $account->nama_akun }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-gray-700">Tanggal</label>
            <input type="date" name="tanggal" required class="w-full mt-1 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 text-white transition bg-green-500 rounded-lg shadow-md hover:bg-green-600">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
