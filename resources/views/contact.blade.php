@extends('layouts.page')

@section('title', "Hubungi Kami")
    
@section('content')
<div class="w-full h-[100vh] relative bg-[url(/images/hero.jpg)] bg-cover bg-center">
    <div class="absolute top-0 left-0 right-0 bottom-0 flex items-center p-20 mobile:p-8 bg-gradient-to-r from-coklat-muda via-coklat-muda to-coklat-muda-gradient text-slate-800">
        <div class="flex flex-col gap-4 w-10/12 mobile:w-full">
            <h1 class="text-[7vh] mobile:text-[4vh] font-bold">Hubungi Kami</h1>
            <div class="grid grid-cols-3 mobile:grid-cols-1 gap-10 mobile:gap-4">
                <a href="https://wa.me/{{ env('PHONE') }}" class="border border-primary text-primary rounded-lg p-8 flex items-center gap-8">
                    <ion-icon name="logo-whatsapp" class="text-4xl"></ion-icon>
                    <div class="flex flex-col gap-2 basis-24 grow">
                        <div class="text-xs">Telepon / WhatsApp</div>
                        <div class="text-lg font-medium">{{ env('PHONE') }}</div>
                    </div>
                </a>
                <a href="mailto:{{ env('EMAIL') }}" class="border border-primary text-primary rounded-lg p-8 flex items-center gap-8">
                    <ion-icon name="mail-outline" class="text-4xl"></ion-icon>
                    <div class="flex flex-col gap-2 basis-24 grow">
                        <div class="text-xs">E-Mail</div>
                        <div class="text-lg font-medium">{{ env('EMAIL') }}</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

@include('partials.footer')
@endsection