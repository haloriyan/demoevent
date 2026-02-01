@extends('layouts.admin')

@section('title', "Check-in Registrasi")
    
@section('content')
<div class="p-8 flex flex-col gap-8">
    <div class="bg-white rounded-lg shadow p-4 flex items-center gap-4">
        <a href="{{ route('admin.checkin.registrasi') }}" class="p-3 px-5 rounded-lg font-medium text-sm bg-primary text-white">
            Registrasi
        </a>
        <a href="{{ route('admin.checkin.booth') }}" class="p-3 px-5 rounded-lg text-sm text-slate-600">
            Booth
        </a>
        <div class="flex grow"></div>
        <a href="{{ route('admin.checkin.registrasi') }}" class="p-3 px-5 rounded-lg font-medium text-xs bg-green-500 text-white flex items-center gap-3">
            <ion-icon name="download-outline" class="text-lg"></ion-icon>
            Download Excel
        </a>
    </div>

    <div class="overflow-x-auto scrollbar-hide bg-white p-4 shadow-sm rounded-lg">
        <table class="w-full table-auto border-collapse">
            <thead>
                <tr class="text-left">
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">
                        <div class="flex items-center">
                            <ion-icon name="time-outline" class="text-lg text-slate-500"></ion-icon>
                        </div>
                    </th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">Nama</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">Instansi</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">Keikutsertaan</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach ($checkins as $check)
                    <tr class="hover:bg-slate-100 transition-colors">
                        <td class="py-3 px-4 text-sm text-slate-600">
                            {{ $check->created_at }}
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            {{ $check->user->name }}
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            {{ $check->user->instansi ?? '-' }}
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            {{ $check->ticket->name }}
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            <div class="w-8 h-8 flex items-center justify-center bg-white border rounded cursor-pointer group relative">
                                <ion-icon name="eye-outline" class="text-primary"></ion-icon>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection