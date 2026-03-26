@extends('layouts.admin')

@section('title', "Tiket Ramayana")

@php
    $statusColors = [
        'PENDING' => "yellow",
        'CANCELLED' => "red",
        'EXPIRED' => "red",
        'PAID' => "green",
    ]
@endphp
    
@section('content')

@include('admin.ramayana.tab')

<div class="p-10">
    <div class="overflow-x-auto scrollbar-hide bg-white p-8 shadow-sm rounded-lg flex flex-col gap-6">
        <table class="w-full table-auto border-collapse">
            <thead>
                <tr class="text-left">
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">
                        <div class="flex items-center">
                            <ion-icon name="person-outline" class="text-lg text-slate-500"></ion-icon>
                        </div>
                    </th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">
                        Jumlah Tiket
                    </th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">
                        Total Pembayaran
                    </th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">
                        Status
                    </th>
                    {{-- <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">Actions</th> --}}
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach ($transactions as $trx)
                    @php
                        $color = $statusColors[strtoupper($trx->payment_status)];
                    @endphp
                    <tr class="hover:bg-slate-100 transition-colors">
                        <td class="py-3 px-4 text-sm text-slate-600">
                            {{ $trx->name }}
                            <div class="text-xs text-slate-500">{{ $trx->email }}</div>
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            {{ $trx->quantity }}
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            {{ currency_encode($trx->total_pay) }}
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            <div class="flex">
                                <div class="p-2 px-4 text-xs rounded-lg border border-{{ $color }}-500 text-{{ $color }}-500 bg-{{ $color }}-100">
                                    {{ strtoupper($trx->payment_status) }}
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $transactions->links() }}
    </div>
</div>

@endsection