@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto px-4 py-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Tambah Akun</h2>

    <form action="{{ route('akun.store') }}" method="POST" class="bg-white p-6 rounded-xl shadow-md space-y-5">
        @csrf

        <div>
            <label for="nama_akun" class="block text-sm font-medium text-gray-700">Nama Akun</label>
            <input type="text" name="nama_akun" id="nama_akun" required
                   class="mt-1 block w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="flex justify-between items-center pt-4">
            <a href="{{ route('akun.index') }}"
               class="text-sm text-gray-600 hover:text-gray-900 underline">
                ← Kembali
            </a>

            <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
