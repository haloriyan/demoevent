@extends('layouts.admin')

@section('title', "Pengaturan Email")
    
@section('content')
<form action="#" class="p-10 mobile:p-6 flex flex-col gap-8 bg-white rounded-lg shadow m-8" method="POST">
    @csrf

    @include('partials.flash_message')

    <div class="flex items-center gap-4">
        <div class="group border focus-within:border-primary rounded-lg p-2 relative flex flex-col grow">
            <label class="text-slate-500 group-focus-within:text-primary text-xs absolute top-2 left-2">Server Host :</label>
            <input type="text" name="MAIL_HOST" id="MAIL_HOST" class="w-full h-10 mt-3 outline-none bg-transparent text-sm text-slate-700" value="{{ env('MAIL_HOST') }}" required />
        </div>
        <div class="group border focus-within:border-primary rounded-lg p-2 relative flex flex-col w-3/12">
            <label class="text-slate-500 group-focus-within:text-primary text-xs absolute top-2 left-2">Port :</label>
            <input type="text" name="MAIL_PORT" id="MAIL_PORT" class="w-full h-10 mt-3 outline-none bg-transparent text-sm text-slate-700" value="{{ env('MAIL_PORT') }}" required />
        </div>
        <div class="group border focus-within:border-primary rounded-lg p-2 relative flex flex-col w-3/12">
            <label class="text-slate-500 group-focus-within:text-primary text-xs absolute top-2 left-2">Enkripsi :</label>
            <input type="text" name="MAIL_ENCRYPTION" id="MAIL_ENCRYPTION" class="w-full h-10 mt-3 outline-none bg-transparent text-sm text-slate-700" value="{{ env('MAIL_ENCRYPTION') }}" required />
        </div>
    </div>

    <div class="flex items-center gap-4">
        <div class="group border focus-within:border-primary rounded-lg p-2 relative flex flex-col grow">
            <label class="text-slate-500 group-focus-within:text-primary text-xs absolute top-2 left-2">Username :</label>
            <input type="text" name="MAIL_USERNAME" id="MAIL_USERNAME" class="w-full h-10 mt-3 outline-none bg-transparent text-sm text-slate-700" value="{{ env('MAIL_USERNAME') }}" required />
        </div>
        <div class="group border focus-within:border-primary rounded-lg p-2 relative flex flex-col grow">
            <label class="text-slate-500 group-focus-within:text-primary text-xs absolute top-2 left-2">Password :</label>
            <input type="text" name="MAIL_PASSWORD" id="MAIL_PASSWORD" class="w-full h-10 mt-3 outline-none bg-transparent text-sm text-slate-700" value="{{ env('MAIL_PASSWORD') }}" required />
        </div>
    </div>

    <div class="flex justify-center my-4">
        <div class="w-4/12 h-[1px] bg-slate-200"></div>
    </div>

    <div class="flex items-center gap-4">
        <div class="group border focus-within:border-primary rounded-lg p-2 relative flex flex-col grow">
            <label class="text-slate-500 group-focus-within:text-primary text-xs absolute top-2 left-2">From Name :</label>
            <input type="text" name="MAIL_FROM_NAME" id="MAIL_FROM_NAME" class="w-full h-10 mt-3 outline-none bg-transparent text-sm text-slate-700" value="{{ env('MAIL_FROM_NAME') }}" required />
        </div>
        <div class="group border focus-within:border-primary rounded-lg p-2 relative flex flex-col grow">
            <label class="text-slate-500 group-focus-within:text-primary text-xs absolute top-2 left-2">From Address :</label>
            <input type="text" name="MAIL_FROM_ADDRESS" id="MAIL_FROM_ADDRESS" class="w-full h-10 mt-3 outline-none bg-transparent text-sm text-slate-700" value="{{ env('MAIL_FROM_ADDRESS') }}" required />
        </div>
    </div>

    <div class="flex mobile:flex-col items-center mobile:items-start justify-end gap-8 mobile:gap-4">
        <button class="p-3 px-5 rounded-lg bg-green-500 text-white text-sm font-medium">
            Simpan
        </button>
    </div>
</div>
@endsection