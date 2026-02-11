@extends('layouts.admin')

@section('title', "Workshop")
    
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
</div>
@endsection