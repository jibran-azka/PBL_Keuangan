@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-6">
    <h2 class="text-xl font-bold mb-4">Isi Detail Tagihan</h2>

    @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tagihan.store') }}" method="POST">
        @csrf

        <input type="hidden" name="metode" value="{{ $metode }}">

        <div class="mb-4">
            <label class="block mb-1 font-medium">Nama Tagihan:</label>
            <input type="text" name="nama_tagihan" class="w-full border px-3 py-2 rounded" required>
        </div>

        {{-- Pilih Bank atau E-Wallet --}}
        @if ($metode === 'bank')
        <div class="mb-4">
            <label class="block mb-1 font-medium">Pilih Bank:</label>
            <select name="tujuan" id="pilihan-tujuan" class="w-full border px-3 py-2 rounded" required onchange="tampilkanLogo()">
                <option value="">-- Pilih Bank --</option>
                <option value="BCA" data-logo="{{ asset('img/bank/bca.png') }}">BCA</option>
                <option value="BNI" data-logo="{{ asset('img/bank/bni.png') }}">BNI</option>
                <option value="BRI" data-logo="{{ asset('img/bank/bri.png') }}">BRI</option>
                <option value="MANDIRI" data-logo="{{ asset('img/bank/mandiri.png') }}">Mandiri</option>
                <option value="SEABANK" data-logo="{{ asset('img/bank/seabank.png') }}">SeaBank</option>
                <option value="BSI" data-logo="{{ asset('img/bank/bsi.png') }}">BSI</option>
            </select>
        </div>
        @elseif ($metode === 'ewallet')
        <div class="mb-4">
            <label class="block mb-1 font-medium">Pilih E-Wallet:</label>
            <select name="tujuan" id="pilihan-tujuan" class="w-full border px-3 py-2 rounded" required onchange="tampilkanLogo()">
                <option value="">-- Pilih E-Wallet --</option>
                <option value="DANA" data-logo="{{ asset('img/ewallet/dana.png') }}">DANA</option>
                <option value="OVO" data-logo="{{ asset('img/ewallet/ovo.png') }}">OVO</option>
                <option value="ShopeePay" data-logo="{{ asset('img/ewallet/shopeepay.png') }}">ShopeePay</option>
                <option value="LINKAJA" data-logo="{{ asset('img/ewallet/linkaja.png') }}">LinkAja</option>
            </select>
        </div>
        @endif

        <div class="mb-4 hidden" id="logo-preview">
            <span class="block mb-1 font-medium">Logo Terpilih:</span>
            <img id="logo-img" src="" alt="Logo" class="w-20 h-20">
        </div>


        <div class="mb-4">
            <label class="block mb-1 font-medium">Nomor Tujuan:</label>
            <input type="text" name="no_tujuan" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Nominal (Rp):</label>
            <input type="number" name="nominal" min="1000" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Tanggal Jatuh Tempo:</label>
            <input type="date" name="tanggal_transfer" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div class="mb-6">
            <label class="block mb-1 font-medium">Akun Keuangan:</label>
            <select name="akun_id" class="w-full border px-3 py-2 rounded" required>
                @foreach ($accounts as $acc)
                    <option value="{{ $acc->id }}">{{ $acc->nama_akun }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('tagihan.metode') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                Kembali
            </a>
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Jadwalkan Tagihan
            </button>
        </div>
    </form>
</div>
@endsection
