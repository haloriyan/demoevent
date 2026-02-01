@extends('layouts.booth')

@section('Dashboard Booth')

@php
    use Carbon\Carbon;
@endphp
    
@section('content')
<div class="flex items-center gap-4">
    <div class="w-16 mobile:w-14 aspect-square rounded-full bg-primary text-white font-bold flex items-center justify-center text-2xl mobile:text-lg">
        {{ Initial($me->name) }}
    </div>
    <div class="flex flex-col gap-1 grow">
        <div class="text-xl text-slate-700 font-medium">{{ $me->name }}</div>
    </div>
    <a href="#" class="bg-red-100 text-red-500 text-sm font-medium p-3 px-6 rounded-full flex items-center gap-3">
        <ion-icon name="log-out-outline" class="text-xl"></ion-icon>
        <span class="mobile:hidden">Logout</span>
    </a>
</div>

<div class="h-8"></div>

<div class="flex items-center gap-4">
    <div class="text-xs text-slate-500">Riwayat Cek-in</div>
    <div class="flex grow"></div>
    <a href="?download=1" class="flex items-center gap-2 text-xs bg-green-500 text-white font-medium p-3 px-5 rounded-full">
        <ion-icon name="download-outline" class="text-base"></ion-icon>
        Unduh Excel
    </a>
</div>
<div class="bg-white rounded-lg p-4 shadow flex flex-col gap-4 mt-6">
    @if ($checkins->count() == 0)
        <div class="w-full aspect-square flex flex-col gap-4 items-center justify-center">
            <img src="/images/empty.svg" alt="Empty" class="w-4/12">
            <h3 class="text-lg text-slate-700 font-medium">Belum ada data.</h3>
        </div>
    @endif
    @foreach ($checkins as $check)
        <div class="flex items-center gap-4">
            <div class="flex flex-col gap-1 basis-24 grow">
                <div class="text-slate-600">{{ $check->user->name }}</div>
                <div class="text-slate-500 text-xs">{{ $check->user->instansi ?? "-" }}</div>
            </div>
            <div class="flex flex-col items-end gap-2">
                <ion-icon name="time-outline" class="text-slate-500 text-xs"></ion-icon>
                <div class="text-slate-600 text-xs font-medium">
                    {{ Carbon::parse($check->created_at)->isoFormat('DD MMM, HH:mm') }}
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="mt-4">
    {{ $checkins->links() }}
</div>
@endsection