@extends('layouts.admin')

@section('title', "Peserta Workshop ")
    
@section('content')
<div class="p-10 flex flex-col gap-8">
    @include('partials.flash_message')

    <div class="bg-white rounded-lg p-8 shadow flex flex-col gap-8 overflow-x-auto scrollbar-hide">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-6">
                <a href="{{ route('admin.workshop') }}">
                    <ion-icon name="arrow-back-outline" class="text-xl"></ion-icon>
                </a>
                <div class="flex flex-col gap-1">
                    <div class="text-xs text-slate-500">Peserta Workshop</div>
                    <h4 class="text-lg text-slate-800 font-medium">{{ $workshop->title }}</h4>
                </div>
            </div>
            <a href="{{ route('admin.workshop.peserta', ['id' => $workshop->id, 'download' => 1]) }}" class="bg-green-600 text-white text-sm font-medium h-10 px-4 rounded-lg flex items-center gap-2">
                <ion-icon name="download-outline" class="text-lg"></ion-icon>
                Download
            </a>
        </div>

        <table class="min-w-max table-auto border-collapse text-left">
            <thead>
                <tr>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">Nama</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">Instansi</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">Email</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">No. Telepon</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="py-3 px-4 text-sm text-slate-600">{{ $user->name }}</td>
                        <td class="py-3 px-4 text-sm text-slate-600">{{ $user->instansi ?? '-' }}</td>
                        <td class="py-3 px-4 text-sm text-slate-600">{{ $user->email ?? '-' }}</td>
                        <td class="py-3 px-4 text-sm text-slate-600">{{ $user->whatsapp ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection