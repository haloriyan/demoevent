@extends('layouts.admin')

@section('title', "Submission")
    
@section('content')
<div class="p-8 flex flex-col gap-8">
    <div class="bg-white rounded-lg shadow p-4 flex items-center gap-4">
        <a href="{{ route('admin.submission', '') }}" class="p-3 px-5 rounded-lg font-medium text-sm {{ $type == '' ? 'bg-primary text-white' : 'text-slate-600' }}">
            Semua
        </a>
        <a href="{{ route('admin.submission', 'abstract') }}" class="p-3 px-5 rounded-lg font-medium text-sm {{ $type == 'abstract' ? 'bg-primary text-white' : 'text-slate-600' }}">
            Abstrak
        </a>
        <a href="{{ route('admin.submission', 'poster') }}" class="p-3 px-5 rounded-lg font-medium text-sm {{ $type == 'poster' ? 'bg-orange-500 text-white' : 'text-slate-600' }}">
            E-Poster
        </a>
        <div class="flex grow"></div>
        <div class="p-3 px-5 rounded-lg font-medium text-xs bg-green-500 text-white flex items-center gap-3 cursor-pointer" onclick="addFilter('is_download', 1)">
            <ion-icon name="download-outline" class="text-lg"></ion-icon>
            Download Excel
        </div>
    </div>

    @include('partials.flash_message')

    <div class="overflow-x-auto scrollbar-hide bg-white p-4 shadow-sm rounded-lg flex flex-col gap-8">
        <table class="w-full table-auto border-collapse">
            <thead>
                <tr class="text-left">
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">ID</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">Nama</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">Email</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">Submission</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">
                        <div class="flex items-center">
                            <ion-icon name="time-outline" class="text-lg text-slate-500"></ion-icon>
                        </div>
                    </th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach ($submissions as $sub)
                    @php
                        $type = $sub->type;
                    @endphp
                    <tr class="hover:bg-slate-100 transition-colors">
                        <td class="py-3 px-4 text-sm text-slate-600">
                            #{{ $sub->id }}
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            {{ $sub->name }}
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            {{ $sub->email }}
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600 flex">
                            <div class="p-2 px-4 rounded text-sm font-medium bg-opacity-20 {{ $type == 'abstract' ? 'bg-primary text-primary' : 'bg-orange-500 text-orange-500' }}">
                                {{ strtoupper($type) }}
                            </div>
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            {{ $sub->created_at }}
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600 flex">
                            <a href="/storage/submission_{{ $type }}/{{ $sub->file }}" target="_blank" class="flex items-center gap-3 p-2 px-4 bg-white border rounded text-primary text-xs font-medium">
                                <ion-icon name="eye-outline" class="text-lg"></ion-icon>
                                Lihat File
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $submissions->links() }}
    </div>
</div>
@endsection