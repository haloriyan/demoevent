@extends('layouts.admin')

@section('title', "Broadcast")

@php
    use Carbon\Carbon;
@endphp
    
@section('content')

<div class="p-8 flex flex-col gap-4">
    <div class="flex items-center gap-4">
        <a href="{{ url()->previous() }}" class="flex items-center gap-2 text-xs text-slate-600">
            <ion-icon name="arrow-back-outline" class="text-lg"></ion-icon>
            Kembali
        </a>
        <div class="flex grow"></div>
    </div>

    <div class="flex gap-8">
        <div class="flex flex-col gap-4 basis-32 grow bg-white rounded-lg p-8 shadow">
            <h3 class="text-lg text-slate-700 font-medium mb-4">{{ $broadcast->title }}</h3>
            <div class="flex items-center gap-2 text-slate-500 text-xs">
                <ion-icon name="phone-portrait-outline" class="text-lg"></ion-icon>
                <div class="flex grow">Perangkat WhatsApp</div>
                @if ($broadcast->device_id != null)
                    <div>{{ $broadcast->device->name }} - {{ $broadcast->device->number }}</div>
                @else
                    <div>-</div>
                @endif
            </div>
            <div class="flex items-center gap-2 text-slate-500 text-xs">
                <ion-icon name="volume-high-outline" class="text-lg"></ion-icon>
                <div class="flex grow">Pesan Terkirim</div>
                <div>{{ $broadcast->sent }} dari {{ $broadcast->total }}</div>
            </div>

            <pre class="whitespace-pre-line font-sans text-base m-0 p-4 break-words bg-slate-100 border rounded-lg">{{ $broadcast->content }}</pre>

        </div>
        <div class="flex flex-col gap-4 w-5/12 bg-white rounded-lg p-8 shadow">
            <div class="flex items-center gap-4 text-sm text-slate-500">
                <ion-icon name="terminal-outline" class="text-lg"></ion-icon>
                Log
            </div>

            <div class="flex flex-col gap-2 mt-4 overflow-y-auto">
                @foreach ($broadcast->logs as $log)
                    <div class="flex items-start gap-4">
                        <div class="flex items-center pt-[5px]">
                            <ion-icon name="ellipse-outline" class="text-xs"></ion-icon>
                        </div>
                        <div class="flex flex-col basis-32 grow gap-1">
                            <div class="text-sm text-slate-600">{{ $log->body }}</div>
                            <div class="text-xs text-slate-400">{{ Carbon::parse($log->created_at)->diffForHumans() }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection