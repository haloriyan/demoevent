@extends('layouts.booth')

@section('Profile Booth')
    
@section('content')
<form action="{{ route('booth.profile.update', $me->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
    @csrf
    <div class="w-full aspect-[5/2] bg-slate-300 rounded-lg relative flex flex-col gap-1 items-center justify-center bg-cover bg-[url({{ '/storage/booth_covers/' . $me->cover  }})]" id="CoverArea">
        @if ($me->cover == null)
            <ion-icon name="image-outline" class="text-4xl text-slate-700"></ion-icon>
        @endif
        <div class="absolute top-4 right-4 text-xs text-slate-700 font-medium bg-white p-1 px-3 rounded-lg">
            Pilih Cover
        </div>
        <input type="file" name="cover" id="cover" class="absolute top-0 left-0 right-0 bottom-0 opacity-0 cursor-pointer" onchange="onChangeImage(this, '#CoverArea')">
    </div>

    <div class="flex justify-center">
        <div class="w-[120px] h-[120px] bg-slate-200 rounded-full relative flex flex-col gap-1 items-center justify-center border-[12px] border-slate-100 mt-[-60px] bg-cover bg-[url({{ '/storage/booth_icons/' . $me->icon }})]" id="IconArea">
            @if ($me->icon == null)
                <ion-icon name="image-outline" class="text-4xl text-slate-700"></ion-icon>
            @endif
            <input type="file" name="icon" id="icon" class="absolute top-0 left-0 right-0 bottom-0 opacity-0 cursor-pointer" onchange="onChangeImage(this, '#IconArea')">
        </div>
    </div>

    @include('partials.flash_message')

    <div class="bg-white rounded-lg shadow-sm p-8 flex flex-col gap-4">
        <div>
            <div class="text-xs text-slate-500 mb-2">Nama Booth</div>
            <input type="text" name="name" id="name" class="w-full h-12 outline-0 px-4 border rounded text-sm text-slate-700" value="{{ $me->name }}" required>
        </div>
        <div>
            <div class="text-xs text-slate-500 mb-2">Username</div>
            <input type="text" name="username" id="username" class="w-full h-12 outline-0 px-4 border rounded text-sm text-slate-700" value="{{ $me->username }}" required>
        </div>
        <div>
            <div class="text-xs text-slate-500 mb-2">Ubah Password</div>
            <input type="password" name="password" id="password" class="w-full h-12 outline-0 px-4 border rounded text-sm text-slate-700">
        </div>

        <button class="w-full h-12 bg-green-500 text-white text-sm font-medium rounded-lg">
            Simpan Perubahan
        </button>
    </div>
</form>

<div class="h-24"></div>
@endsection