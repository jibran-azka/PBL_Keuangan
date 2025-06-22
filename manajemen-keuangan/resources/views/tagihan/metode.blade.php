@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-6 text-center">
    <h2 class="text-xl font-bold mb-6">Pilih Metode Pembayaran</h2>

    <form id="form-bank" method="GET" action="{{ route('tagihan.form') }}">
        <input type="hidden" name="metode" value="bank">
        <input type="hidden" name="tujuan" value="BANK-001"> {{-- Atau isi tujuan default bank --}}
        <button type="submit" class="block w-full bg-white border shadow p-4 mb-4 rounded hover:bg-gray-50">
            <i class="fas fa-university text-blue-500 mr-2"></i> Transfer ke Bank
        </button>
    </form>

    <form id="form-ewallet" method="GET" action="{{ route('tagihan.form') }}">
        <input type="hidden" name="metode" value="ewallet">
        <input type="hidden" name="tujuan" value="EWALLET-001"> {{-- Atau isi tujuan default e-wallet --}}
        <button type="submit" class="block w-full bg-white border shadow p-4 rounded hover:bg-gray-50">
            <i class="fas fa-wallet text-orange-500 mr-2"></i> Transfer ke E-Wallet
        </button>
    </form>
</div>
@endsection
