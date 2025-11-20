@extends('layouts.admin')

@section('title', "Dashboard")
    
@section('content')
<div class="flex flex-col gap-8 p-8">
    <div class="flex items-center gap-4">
        <div class="text-xs text-slate-500 flex grow">
            @if ($isValid)
                Menampilkan peserta bertiket dan telah dibayar
            @else
                Menampilkan semua data yang terekam
            @endif
        </div>
        <div class="flex items-center gap-3">
            <div class="text-sm text-slate-800">Tampilkan Transaksi Valid</div>
            <a href="{{ route('admin.dashboard', ['isValid' => $isValid == 1 ? 0 : 1]) }}" class="p-1 rounded-full {{ $isValid ? 'bg-green-500' : 'bg-slate-200' }}">
                <div class="h-4 w-4 bg-white rounded-full {{ $isValid ? 'ms-4' : 'me-4' }}" id="SwitchDot"></div>
            </a>
        </div>
    </div>
    <div class="grid grid-cols-3 gap-8">
        <div class="flex items-center gap-6 bg-white rounded-lg p-4">
            <div class="w-16 aspect-square rounded-lg flex items-center justify-center bg-blue-400">
                <ion-icon name="people-outline" class="text-2xl text-white"></ion-icon>
            </div>
            <div class="flex flex-col gap-1 basis-32 grow">
                <div class="text-xs text-slate-500">Peserta</div>
                <div class="text-xl text-slate-700 font-bold">
                    {{ $users }}
                </div>
            </div>
        </div>
        <div class="flex items-center gap-6 bg-white rounded-lg p-4">
            <div class="w-16 aspect-square rounded-lg flex items-center justify-center bg-purple-400">
                <ion-icon name="ticket-outline" class="text-2xl text-white"></ion-icon>
            </div>
            <div class="flex flex-col gap-1 basis-32 grow">
                <div class="text-xs text-slate-500">Tiket Terjual</div>
                <div class="text-xl text-slate-700 font-bold">
                    {{ $transactions->count() }}
                </div>
            </div>
        </div>
        <div class="flex items-center gap-6 bg-white rounded-lg p-4">
            <div class="w-16 aspect-square rounded-lg flex items-center justify-center bg-green-400">
                <ion-icon name="cash-outline" class="text-2xl text-white"></ion-icon>
            </div>
            <div class="flex flex-col gap-1 basis-32 grow">
                <div class="text-xs text-slate-500">Penjualan</div>
                <div class="text-xl text-slate-700 font-bold">
                    {{ currency_encode($transactions->sum('payment_amount')) }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection