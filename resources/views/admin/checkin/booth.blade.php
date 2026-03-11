@extends('layouts.admin')

@section('title', "Check-in Booth")
    
@section('content')
@include('admin.checkin.tab')
<div class="p-8 flex flex-col gap-8">
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