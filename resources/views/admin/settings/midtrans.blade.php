@extends('layouts.admin')

@section('title', "Midtrans")

@php
    $mode = env('MIDTRANS_MODE');
    $isLive = $mode == "LIVE";
@endphp
    
@section('content')
<form action="#" class="p-10 mobile:p-6 flex flex-col gap-4 bg-white rounded-lg shadow m-8" method="POST">
    @csrf

    @include('partials.flash_message')

    <div class="flex items-center gap-4">
        <div class="text-sm text-slate-500 flex grow">Mode</div>
        <div class="bg-slate-200 rounded-lg p-2 flex items-center">
            <a href="{{ route('admin.settings.midtrans.mode', ['LIVE']) }}" class="p-2 px-5 rounded-lg text-xs {{ $isLive ? 'bg-white font-medium text-primary' : 'text-slate-700' }}">
                LIVE
            </a>
            <a href="{{ route('admin.settings.midtrans.mode', ['SANDBOX']) }}" class="p-2 px-5 rounded-lg text-xs {{ !$isLive ? 'bg-white font-medium text-primary' : 'text-slate-700' }}">
                SANDBOX
            </a>
        </div>
    </div>

    <div class="flex items-center gap-4">
        <div class="text-sm text-slate-500 flex grow">Merchant ID</div>
        <div class="group border focus-within:border-primary rounded-lg p-2 relative flex flex-col grow">
            <input type="text" name="MIDTRANS_MERCHANT_ID" id="MIDTRANS_MERCHANT_ID" class="w-full h-10 outline-none bg-transparent text-sm text-slate-700" value="{{ env('MIDTRANS_MERCHANT_ID') }}" required />
        </div>
    </div>
    <div class="flex items-center gap-4">
        <div class="text-sm text-slate-500 flex grow">Client Key</div>
        <div class="group border focus-within:border-primary rounded-lg p-2 relative flex flex-col grow">
            <input type="text" name="MIDTRANS_CLIENT_KEY_{{ $mode }}" id="MIDTRANS_CLIENT_KEY_{{ $mode }}" class="w-full h-10 outline-none bg-transparent text-sm text-slate-700" value="{{ env('MIDTRANS_CLIENT_KEY_' . $mode) }}" required />
        </div>
    </div>
    <div class="flex items-center gap-4">
        <div class="text-sm text-slate-500 flex grow">Server Key</div>
        <div class="group border focus-within:border-primary rounded-lg p-2 relative flex flex-col grow">
            <input type="text" name="MIDTRANS_SERVER_KEY_{{ $mode }}" id="MIDTRANS_SERVER_KEY_{{ $mode }}" class="w-full h-10 outline-none bg-transparent text-sm text-slate-700" value="{{ env('MIDTRANS_SERVER_KEY_' . $mode) }}" required />
        </div>
    </div>

    <div class="flex justify-end">
        <button class="p-3 px-5 rounded-lg bg-primary text-white text-sm font-medium">
            Simpan
        </button>
    </div>
</form>
@endsection