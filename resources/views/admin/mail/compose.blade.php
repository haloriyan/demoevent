@extends('layouts.admin')

@section('title', "Compsoe")
    
@section('content')
@include('admin.mail.tab')

<form action="{{ route('admin.mail.send') }}" class="bg-white shadow m-8 rounded-lgs" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="border-b flex items-center gap-4 p-2 px-4">
        <div class="text-sm text-slate-600">Kepada</div>
        <input type="text" name="to" class="flex grow h-10 px-4 outline-none text-sm text-slate-600" placeholder="someone@gmail.com">
    </div>
    <div class="border-b flex items-center gap-4 p-2 px-4">
        <div class="text-sm text-slate-600">Subjek</div>
        <input type="text" name="subject" class="flex grow h-10 px-4 outline-none text-sm text-slate-600">
    </div>
    <textarea name="body" id="body" class="w-full outline-none p-4" rows="10"></textarea>
    <div class="border-t flex items-center gap-4 p-2 px-4">
        <div class="text-sm text-slate-600">Lampiran</div>
        <input type="file" name="attachments[]" multiple class="flex grow p-4 outline-none text-xs text-slate-600">
    </div>

    <div class="flex justify-end p-4">
        <button class="p-3 px-5 rounded-lg bg-primary text-white text-sm">
            Kirim
        </button>
    </div>
</div>
@endsection