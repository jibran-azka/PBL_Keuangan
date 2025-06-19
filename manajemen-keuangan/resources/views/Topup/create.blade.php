@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto px-4 py-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Top Up Saldo</h2>

    <form action="{{ route('topup.store') }}" method="POST" class="bg-white p-6 rounded-xl shadow-md space-y-5">
        @csrf

        <div>
            <label for="account_id" class="block text-sm font-medium text-gray-700">Pilih Akun</label>
            <select name="account_id" id="account_id" required
                    class="mt-1 block w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500">
                @foreach ($accounts as $account)
                    <option value="{{ $account->id }}">{{ $account->nama_akun }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="amount" class="block text-sm font-medium text-gray-700">Nominal</label>
            <input type="number" name="amount" id="amount" min="1000" required
                   class="mt-1 block w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500">
        </div>

        <div class="flex justify-between items-center pt-4">
            <a href="{{ route('akun.index') }}"
               class="text-sm text-gray-600 hover:text-gray-900 underline">
                ← Kembali
            </a>

            <button type="submit"
                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg shadow-md text-sm">
                Top Up Sekarang
            </button>
        </div>
    </form>
</div>
@endsection
