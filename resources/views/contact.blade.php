@extends('layouts.page')

@section('title', "Hubungi Kami")
    
@section('content')
<div class="w-full h-[100vh] bg-primary text-white flex flex-col gap-8 justify-center p-20 py-24">
    <h2 class="text-4xl font-bold">Hubungi Kami</h2>
    <div class="font-medium">Jangan ragu menghubungi kami jika Anda memiliki pertanyaan apapun, melalui channel berikut ini :</div>
    <div class="grid grid-cols-3 gap-10">
        <a href="https://wa.me/{{ env('PHONE') }}" class="border rounded-lg p-8 flex items-center gap-8">
            <ion-icon name="logo-whatsapp" class="text-4xl"></ion-icon>
            <div class="flex flex-col gap-2 basis-24 grow">
                <div class="text-xs">Telepon / WhatsApp</div>
                <div class="text-lg font-medium">{{ env('PHONE') }}</div>
            </div>
        </a>
        <a href="mailto:{{ env('EMAIL') }}" class="border rounded-lg p-8 flex items-center gap-8">
            <ion-icon name="mail-outline" class="text-4xl"></ion-icon>
            <div class="flex flex-col gap-2 basis-24 grow">
                <div class="text-xs">E-Mail</div>
                <div class="text-lg font-medium">{{ env('EMAIL') }}</div>
            </div>
        </a>
    </div>
</div>

@include('partials.footer')
@endsection