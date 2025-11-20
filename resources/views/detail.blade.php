@extends('layouts.register')

@section('title', "Informasi Pribadi")
    
@section('content')

<form action="{{ route('index', ['step' => "detail"]) }}" class="SlideItem flex flex-col gap-6" method="POST">
    @csrf
    <input type="hidden" name="p" value="{{ $request->p }}">
    <div class="flex flex-col gap-3">
        <a href="{{ url()->previous() }}" class="flex items-center gap-2 text-xs text-slate-500">
            <ion-icon name="arrow-back-outline"></ion-icon>
            Kembali
        </a>
        <div class="flex flex-col gap-1 mb-3">
            <h2 class="text-xl text-slate-700 font-medium">Informasi Pribadi</h2>
            <div class="text-sm text-slate-600">
                Mohon lengkapi detail informasi Anda untuk melanjutkan pendaftaran.
            </div>
        </div>
    </div>

    <div>
        <div class="group border focus-within:border-primary rounded-lg p-1 relative">
            <label class="text-slate-500 group-focus-within:text-primary text-xs absolute top-2 left-2">Nomor Induk Kependudukan</label>
            <input type="text" name="nik" id="nik" class="w-full h-12 px-1 mt-3 outline-none bg-transparent text-sm text-slate-700" value="{{ $payload['nik'] ?? '' }}" required />
        </div>
        <div class="text-[11px] text-slate-400 mt-2">
            NIK diperlukan sebagai syarat untuk SKP KEMENKES. Pastikan NIK sesuai dengan data di SATU SEHAT.
        </div>
    </div>

    <div>
        <div class="group border focus-within:border-primary rounded-lg p-1 relative">
            <label class="text-slate-500 group-focus-within:text-primary text-xs absolute top-2 left-2">Nama</label>
            <input type="text" name="name" id="name" class="w-full h-12 px-1 mt-3 outline-none bg-transparent text-sm text-slate-700" value="{{ $payload['name'] ?? '' }}" required />
        </div>
        <div class="text-[11px] text-slate-400 mt-2">
            Nama lengkap tanpa gelar
        </div>
    </div>

    <div>
        <div class="group border focus-within:border-primary rounded-lg p-1 relative">
            <label class="text-slate-500 group-focus-within:text-primary text-xs absolute top-2 left-2">Email</label>
            <input type="email" name="email" id="email" class="w-full h-12 px-1 mt-3 outline-none bg-transparent text-sm text-slate-700" value="{{ $payload['email'] ?? '' }}" required />
        </div>
        <div class="text-[11px] text-slate-400 mt-2">
            Gunakan email pribadi, bukan email pihak ketiga / sponsor / perusahaan.
        </div>
    </div>

    <div>
        <div class="group border focus-within:border-primary rounded-lg p-1 relative">
            <label class="text-slate-500 group-focus-within:text-primary text-xs absolute top-2 left-2">No. Whatsapp</label>
            <div class="flex items-center mt-4">
                <div class="text-sm text-slate-600">+62</div>
                <input type="text" name="whatsapp" id="whatsapp" class="w-full h-12 outline-none bg-transparent text-sm text-slate-700" value="{{ $payload['whatsapp'] ?? '' }}" placeholder="8XXXXXXXXXX" required />
            </div>
        </div>
        <div class="text-[11px] text-slate-400 mt-2">
            Pastikan nomor terdaftar di aplikasi WhatsApp. Untuk pengiriman pemberitahuan.
        </div>
    </div>

    <div class="flex justify-end gap-4">
        <button class="p-3 px-5 rounded-lg bg-primary text-white text-sm font-medium">
            Daftar
        </button>
    </div>
</div>

@endsection