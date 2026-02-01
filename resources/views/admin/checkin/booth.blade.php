@extends('layouts.admin')

@section('title', "Check-in Booth")
    
@section('content')
<div class="p-8 flex flex-col gap-8">
    <div class="bg-white rounded-lg shadow p-4 flex items-center gap-4">
        <a href="{{ route('admin.checkin.registrasi') }}" class="p-3 px-5 rounded-lg text-sm text-slate-600">
            Registrasi
        </a>
        <a href="{{ route('admin.checkin.booth') }}" class="p-3 px-5 rounded-lg font-medium text-sm bg-primary text-white">
            Booth
        </a>
        <div class="flex grow"></div>
        <select name="booth_id" id="booth_id" class="text-xs text-slate-600 border rounded-lg outline-0 px-4 h-12" onchange="addFilter('booth_id', this.value)">
            <option value="">Semua Booth</option>
            @foreach ($booths as $boo)
                <option value="{{ $boo->id }}" {{ $request->booth_id == $boo->id ? "selected='selected'" : "" }}>{{ $boo->name }}</option>
            @endforeach
        </select>
        <button class="p-3 px-5 rounded-lg font-medium text-xs bg-green-500 text-white flex items-center gap-3" onclick="addFilter({download: 1})">
            <ion-icon name="download-outline" class="text-lg"></ion-icon>
            Download Excel
        </button>
    </div>

    <div class="overflow-x-auto scrollbar-hide bg-white p-4 shadow-sm rounded-lg">
        <table class="w-full table-auto border-collapse">
            <thead>
                <tr class="text-left">
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">
                        <div class="flex items-center">
                            <ion-icon name="storefront-outline" class="text-lg text-slate-500"></ion-icon>
                        </div>
                    </th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">Nama</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">Instansi</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">
                        <div class="flex items-center">
                            <ion-icon name="time-outline" class="text-lg text-slate-500"></ion-icon>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach ($checkins as $check)
                    <tr class="hover:bg-slate-100 transition-colors">
                        <td class="py-3 px-4 text-sm text-slate-600">
                            {{ $check->booth->name }}
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            {{ $check->user->name }}
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            {{ $check->user->instansi ?? '-' }}
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            {{ $check->created_at }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection