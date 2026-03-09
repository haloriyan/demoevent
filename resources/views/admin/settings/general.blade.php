@extends('layouts.admin')

@section('title', "Pengaturan Umum")
    
@section('content')
<form action="#" class="p-10 mobile:p-6 flex flex-col gap-8 bg-white rounded-lg shadow m-8" method="POST">
    @csrf

    @include('partials.flash_message')

    <div class="group border focus-within:border-primary rounded-lg p-2 relative flex flex-col grow">
        <label class="text-slate-500 group-focus-within:text-primary text-xs absolute top-2 left-2">Nama Aplikasi / Situs / Event :</label>
        <input type="text" name="EVENT_NAME" id="EVENT_NAME" class="w-full h-10 mt-3 outline-none bg-transparent text-sm text-slate-700" value="{{ env('EVENT_NAME') }}" required />
    </div>
    <div class="group border focus-within:border-primary rounded-lg p-2 relative flex flex-col grow">
        <label class="text-slate-500 group-focus-within:text-primary text-xs absolute top-2 left-2">Tanggal Event :</label>
        <input type="text" name="EVENT_DATES" id="EVENT_DATES" class="w-full h-10 mt-3 outline-none bg-transparent text-sm text-slate-700" value="{{ env('EVENT_DATES') }}" required />
    </div>
    <div class="group border focus-within:border-primary rounded-lg p-2 relative flex flex-col grow">
        <label class="text-slate-500 group-focus-within:text-primary text-xs absolute top-2 left-2">Lokasi :</label>
        <input type="text" name="EVENT_PLACE" id="EVENT_PLACE" class="w-full h-10 mt-3 outline-none bg-transparent text-sm text-slate-700" value="{{ env('EVENT_PLACE') }}" required />
    </div>

    <div class="flex justify-center my-4">
        <div class="w-4/12 h-[1px] bg-slate-200"></div>
    </div>

    <div class="flex items-center gap-4">
        <div class="group border focus-within:border-primary rounded-lg p-2 relative flex flex-col grow">
            <label class="text-slate-500 group-focus-within:text-primary text-xs absolute top-2 left-2">Kontak Email :</label>
            <input type="text" name="EMAIL" id="EMAIL" class="w-full h-10 mt-3 outline-none bg-transparent text-sm text-slate-700" value="{{ env('EMAIL') }}" required />
        </div>
        <div class="group border focus-within:border-primary rounded-lg p-2 relative flex flex-col grow">
            <label class="text-slate-500 group-focus-within:text-primary text-xs absolute top-2 left-2">Kontak No. Telepon :</label>
            <input type="text" name="PHONE" id="PHONE" class="w-full h-10 mt-3 outline-none bg-transparent text-sm text-slate-700" value="{{ env('PHONE') }}" required />
        </div>
    </div>

    <div class="flex mobile:flex-col items-center mobile:items-start justify-end gap-8 mobile:gap-4">
        <button class="p-3 px-5 rounded-lg bg-green-500 text-white text-sm font-medium">
            Simpan
        </button>
    </div>
</div>
@endsection