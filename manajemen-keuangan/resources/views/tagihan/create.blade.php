@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-4">
    <h1 class="text-xl font-bold mb-4">Tambah Tagihan</h1>

    <form action="{{ route('tagihan.store') }}" method="POST">
        @csrf
        <label>Nama Tagihan :</label>
        <input type="text" name="nama" class="w-full" required>

        <label>Nominal:</label>
        <input type="number" name="nominal" class="w-full" step="0.01" required>

        <label>Akun:</label>
        <select name="account_id" class="w-full">
            @foreach ($accounts as $account)
                <option value="{{ $account->id }}">{{ $account->nama_akun }}</option>
            @endforeach
        </select>

        <label>Tanggal Jatuh Tempo:</label>
        <input type="date" name="tanggal_jatuh_tempo" class="w-full" required>

        <button class="mt-4 px-4 py-2 bg-blue-500 text-white">Simpan</button>
    </form>
</div>
@endsection
