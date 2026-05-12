@extends('layouts.admin')

@section('title', "Recreate Registrasi")

@section('content')
@php use Carbon\Carbon; @endphp
<div class="p-8 flex flex-col gap-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Recreate Registrasi</h1>
        <p class="text-sm text-slate-500 mt-1">Cari peserta, lalu buat ulang invoice DOKU dan kirim ulang email notifikasi.</p>
    </div>

    @if ($message)
        <div class="bg-green-50 border border-green-200 text-green-800 text-sm rounded-lg px-4 py-3">
            {{ $message }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm p-4">
        <form method="GET" action="{{ route('admin.recreate-registration') }}" class="flex items-center gap-3">
            <div class="flex-1 border rounded-lg flex items-center gap-3 px-4">
                <ion-icon name="search-outline" class="text-slate-400 text-xl"></ion-icon>
                <input
                    type="text"
                    name="name"
                    class="w-full h-12 text-sm text-slate-700 outline-0"
                    placeholder="Cari nama peserta..."
                    value="{{ $request->name }}"
                    autofocus
                >
            </div>
            <button type="submit" class="h-12 px-6 bg-primary text-white text-sm font-semibold rounded-lg">
                Cari
            </button>
        </form>
    </div>

    @if ($request->filled('name'))
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            @if ($users->isEmpty())
                <div class="p-8 text-center text-slate-500 text-sm">
                    Tidak ada peserta dengan nama "<strong>{{ $request->name }}</strong>".
                </div>
            @else
                <div class="px-4 py-3 border-b text-sm text-slate-500">
                    Ditemukan <strong>{{ $users->count() }}</strong> peserta
                </div>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-left text-xs text-slate-500 font-semibold uppercase tracking-wide">
                            <th class="px-4 py-3">Peserta</th>
                            <th class="px-4 py-3">Tiket</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Invoice</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($users as $user)
                            @php
                                $trx = $user->transaction;
                                $statusColors = [
                                    'PENDING' => 'yellow',
                                    'PAID'    => 'green',
                                    'EXPIRED' => 'red',
                                    'CANCELLED' => 'red',
                                ];
                                $color = $statusColors[$trx?->payment_status ?? ''] ?? 'slate';
                            @endphp
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3">
                                    <div class="font-medium text-slate-800">{{ $user->name }}</div>
                                    <div class="text-xs text-slate-400">{{ $user->email }}</div>
                                </td>
                                <td class="px-4 py-3 text-slate-600">
                                    {{ $trx?->ticket?->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    @if ($trx)
                                        <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold bg-{{ $color }}-100 text-{{ $color }}-700">
                                            {{ $trx->payment_status }}
                                        </span>
                                    @else
                                        <span class="text-slate-400 text-xs">Belum ada transaksi</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-slate-500 text-xs font-mono">
                                    {{ $trx?->invoice_number ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    @if ($trx)
                                        <a href="{{ route('admin.recreate-registration.confirm', $trx->id) }}"
                                           class="inline-block px-4 py-2 bg-indigo-600 text-white text-xs font-semibold rounded-lg hover:bg-indigo-700">
                                            Recreate
                                        </a>
                                    @else
                                        <span class="text-slate-300 text-xs">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    @endif
</div>
@endsection
