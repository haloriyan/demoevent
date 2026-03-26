@extends('layouts.admin')

@section('title', "Pengaturan Tiket Ramayana")
    
@section('content')

@include('admin.ramayana.tab')

<div class="p-10 flex flex-col items-center">
    <form action="{{ route('admin.ramayana.settings') }}" method="POST" class="bg-white p-8 rounded-lg shadow flex flex-col gap-4 w-7/12 mobile:w-full">
        @include('partials.flash_message')
        @csrf
        <div class="flex items-center gap-4">
            <div class="text-xs text-slate-500 flex grow">Harga Tiket</div>
            <input type="text" name="RAMAYANA_PRICE" class="h-10 border rounded-lg outline-none text-sm text-slate-600 px-4" value="{{ env('RAMAYANA_PRICE') }}">
        </div>
        <div class="flex items-center gap-4">
            <div class="text-xs text-slate-500 flex grow">Lokasi Penjemputan</div>
            <input type="text" name="RAMAYANA_PLACE" class="h-10 border rounded-lg outline-none text-sm text-slate-600 px-4" value="{{ env('RAMAYANA_PLACE') }}">
        </div>
        <div class="flex items-center gap-4">
            <div class="text-xs text-slate-500 flex grow">Waktu</div>
            <input type="text" name="RAMAYANA_TIME" class="h-10 border rounded-lg outline-none text-sm text-slate-600 px-4" value="{{ env('RAMAYANA_TIME') }}">
        </div>

        <div class="flex justify-end">
            <button class="p-2 px-4 bg-green-500 text-white text-sm font-medium rounded-lg">
                Simpan
            </button>
        </div>
    </form>
</div>

@endsection