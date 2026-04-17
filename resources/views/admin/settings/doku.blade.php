@extends('layouts.admin')

@section('title', "Doku")

@php
    $mode = env('DOKU_MODE');
    $isLive = $mode == "live";
@endphp
    
@section('content')
<form action="#" class="p-10 mobile:p-6 flex flex-col gap-4 bg-white rounded-lg shadow m-8" method="POST">
    @csrf

    @include('partials.flash_message')

    <div class="flex items-center gap-4">
        <div class="text-sm text-slate-500 flex grow">Mode</div>
        <div class="bg-slate-200 rounded-lg p-2 flex items-center">
            <a href="{{ route('admin.settings.doku.mode', ['LIVE']) }}" class="p-2 px-5 rounded-lg text-xs {{ $isLive ? 'bg-white font-medium text-primary' : 'text-slate-700' }}">
                LIVE
            </a>
            <a href="{{ route('admin.settings.doku.mode', ['SANDBOX']) }}" class="p-2 px-5 rounded-lg text-xs {{ !$isLive ? 'bg-white font-medium text-primary' : 'text-slate-700' }}">
                SANDBOX
            </a>
        </div>
    </div>

    <div class="flex items-center gap-4">
        <div class="text-sm text-slate-500 flex grow">Client ID</div>
        <div class="group border focus-within:border-primary rounded-lg p-2 relative flex flex-col grow">
            <input type="text" name="DOKU_CLIENT_ID" id="DOKU_CLIENT_ID" class="w-full h-10 outline-none bg-transparent text-sm text-slate-700" value="{{ env('DOKU_CLIENT_ID') }}" required />
        </div>
    </div>
    <div class="flex items-center gap-4">
        <div class="text-sm text-slate-500 flex grow">Secret Key</div>
        <div class="group border focus-within:border-primary rounded-lg p-2 relative flex flex-col grow">
            <input type="text" name="DOKU_SECRET_KEY" id="DOKU_SECRET_KEY" class="w-full h-10 outline-none bg-transparent text-sm text-slate-700" value="{{ env('DOKU_SECRET_KEY') }}" required />
        </div>
    </div>
    <div class="flex items-center gap-4">
        <div class="text-sm text-slate-500 flex grow">API Key</div>
        <div class="group border focus-within:border-primary rounded-lg p-2 relative flex flex-col grow">
            <input type="text" name="DOKU_API_KEY" id="DOKU_API_KEY" class="w-full h-10 outline-none bg-transparent text-sm text-slate-700" value="{{ env('DOKU_API_KEY') }}" required />
        </div>
    </div>

    <div class="flex justify-end">
        <button class="p-3 px-5 rounded-lg bg-primary text-white text-sm font-medium">
            Simpan
        </button>
    </div>
</form>
@endsection