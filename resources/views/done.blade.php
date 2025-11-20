@extends('layouts.register')

@section('title', "Pendaftaran Berhasil")
    
@section('content')
<form class="SlideItem flex flex-col items-center justify-center text-center grow gap-4">

    <div class="w-24 h-24 flex items-center justify-center text-4xl bg-green-600 rounded-full text-white">
        <ion-icon name="checkmark-outline"></ion-icon>
    </div>
    <h2 class="text-3xl text-slate-700 font-medium mt-8">Pendaftaran Berhasil.</h2>
    <div class="text-base text-slate-600">
        Silahkan cek email Anda untuk mendapatkan informasi selanjutnya tentang pendaftaran ini berikut cara pembayaran. Terima kasih atas partisipasi Anda.
    </div>
    
    <div class="flex flex-col items-start gap-3 mt-4">
        <div class="text-xs text-slate-500">Rekomendasi Berikutnya :</div>
        <div class="flex items-center gap-4">
            @if ($mailDomain == "icloud.com")
                <a href="https://icloud.com/mail" target="_blank" class="p-3 px-5 rounded-lg border border-primary bg-primary transition-colors text-white text-sm flex items-center gap-3">
                    <ion-icon name="logo-apple" class="text-2xl"></ion-icon>
                    Buka iCloud Mail
                </a>
            @endif
            @if ($mailDomain == "gmail.com")
                <a href="https://mail.google.com" target="_blank" class="p-3 px-5 rounded-lg border border-primary bg-primary transition-colors text-white text-sm flex items-center gap-3">
                    <ion-icon name="logo-google" class="text-2xl"></ion-icon>
                    Buka GMail
                </a>
            @endif
            <a href="#" class="p-3 px-5 rounded-lg border border-primary hover:bg-primary transition-colors text-primary hover:text-white text-sm flex items-center gap-3">
                <ion-icon name="book" class="text-2xl"></ion-icon>
                Unduh Guidebook
            </a>
            <a href="#" class="p-3 px-5 rounded-lg border border-primary hover:bg-primary transition-colors text-primary hover:text-white text-sm flex items-center gap-3">
                <ion-icon name="bed" class="text-2xl"></ion-icon>
                Booking Penginapan
            </a>
        </div>
    </div>
</form>
@endsection