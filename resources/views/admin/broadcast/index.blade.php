@extends('layouts.admin')

@section('title', "Broadcast")

@php
    use Carbon\Carbon;
@endphp
    
@section('content')

<div class="p-8 flex flex-col gap-8">
    <div class="bg-white rounded-lg p-4 flex items-center gap-4 shadow-sm">
        <div class="flex grow"></div>
        <button class="flex items-center gap-3 p-3 px-5 rounded-lg bg-primary text-white text-sm font-medium" onclick="toggleHidden('#CreateBroadcast')">
            <ion-icon name="add-outline"></ion-icon>
            Siaran Baru
        </button>
    </div>

    <div class="overflow-x-auto scrollbar-hide bg-white p-4 shadow-sm rounded-lg">
        <table class="min-w-max table-auto border-collapse w-full">
            <thead>
                <tr class="text-left">
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">Broadcast</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">
                        <div class="flex items-center">
                            <ion-icon name="phone-portrait-outline" class="text-lg text-slate-500"></ion-icon>
                        </div>
                    </th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">Terkirim</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">
                        <div class="flex items-center">
                            <ion-icon name="time-outline" class="text-lg text-slate-500"></ion-icon>
                        </div>
                    </th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach ($broadcasts as $bc)
                    @php
                        $timestamp = Carbon::parse($bc->created_at);
                    @endphp
                    <tr class="hover:bg-slate-100 transition-colors">
                        <td class="py-3 px-4 text-sm text-slate-600">
                            <a href="{{ route('admin.broadcast.detail', $bc->id) }}" class="text-primary underline font-medium">
                                {{ $bc->title }}
                            </a>
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            @if ($bc->device_id != null)
                                <div class="flex items-center gap-3">
                                    <img src="{{ $bc->device->profile_picture }}" alt="{{ $bc->device->name}}" class="w-14 h-14 rounded-lg object-cover">
                                    <div class="flex flex-col gap">
                                        <div class="text-sm text-slate-700">{{ $bc->device->name }}</div>
                                        <div class="text-xs text-slate-500">{{ $bc->device->number }}</div>
                                    </div>
                                </div>
                            @else
                            -
                            @endif
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            {{ $bc->sent }} dari {{ $bc->total }}
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            <div class="flex flex-col gap-1">
                                <div class="text-sm text-slate-700">{{ $timestamp->isoFormat('DD MMM Y') }}</div>
                                <div class="text-xs text-slate-500">{{ $timestamp->isoFormat('HH:mm:ss') }}</div>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            <a href="{{ route('admin.broadcast.detail', $bc->id) }}" class="w-10 h-10 flex items-center justify-center bg-white border rounded-lg cursor-pointer group relative">
                                <ion-icon name="eye-outline" class="text-primary text-lg"></ion-icon>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="h-4"></div>

        {{ $broadcasts->links() }}
    </div>
</div>

@endsection

@section('ModalArea')

@include('admin.broadcast.create')

@endsection