@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-8 bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">Tambah Tagihan</h2>

    <form action="{{ route('tagihan.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Nama Tagihan</label>
            <input type="text" name="nama" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Nominal</label>
            <input type="number" name="nominal" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Tanggal Jatuh Tempo</label>
            <input type="date" name="tanggal_jatuh_tempo" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Simpan
        </button>
    </form>
</div>
@endsection
