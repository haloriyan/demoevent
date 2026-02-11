@extends('layouts.register')

@section('title', "Pendaftaran")
    
@section('content')

@php
    use Carbon\Carbon;
@endphp

<form action="{{ route('register', ['step' => "konfirmasi"]) }}" class="SlideItem flex flex-col grow gap-4" method="POST">
    @csrf
    <input type="hidden" name="p" value="{{ $request->p }}">

    <div class="flex flex-col gap-3 mb-2">
        <a href="{{ url()->previous() }}" class="flex items-center gap-2 text-xs text-slate-500">
            <ion-icon name="arrow-back-outline"></ion-icon>
            Kembali
        </a>
        <div class="flex flex-col gap-1 mb-3">
            <h2 class="text-xl text-slate-700 font-medium">Konfirmasi Data</h2>
            <div class="text-sm text-slate-600">
                Pastikan data berikut telah sesuai.
            </div>
        </div>
    </div>

    <div>
        <div class="text-xs text-slate-500 mb-2">Nomor Induk Kependudukan</div>
        <input type="text" class="w-full h-14 rounded-lg bg-slate-200 text-slate-700 text-sm px-4" value="{{ $payload['nik'] }}" readonly>
    </div>
    <div>
        <div class="text-xs text-slate-500 mb-2">Nama Lengkap</div>
        <input type="text" class="w-full h-14 rounded-lg bg-slate-200 text-slate-700 text-sm px-4" value="{{ $payload['name'] }}" readonly>
    </div>
    <div>
        <div class="text-xs text-slate-500 mb-2">Email</div>
        <input type="text" class="w-full h-14 rounded-lg bg-slate-200 text-slate-700 text-sm px-4" value="{{ $payload['email'] }}" readonly>
    </div>
    <div>
        <div class="text-xs text-slate-500 mb-2">No. WhatsApp</div>
        <input type="text" class="w-full h-14 rounded-lg bg-slate-200 text-slate-700 text-sm px-4" value="+62{{ $payload['whatsapp'] }}" readonly>
    </div>

    <div class="border border-primary rounded-lg p-4 mt-4 flex items-center gap-4">
        <div class="flex flex-col gap-2 basis-32 grow">
            <h3 class="text-slate-600 font-medium">{{ $payload['ticket']['name'] }}</h3>
            <div class="flex items-center gap-2 text-xs text-slate-500">
                <ion-icon name="calendar-outline" class="text-lg"></ion-icon>
                {{ Carbon::parse($payload['ticket']['start_date'])->isoFormat('DD MMMM Y') }}
            </div>
            @if ($payload['workshops'])
                <div class="flex items-center gap-2 text-xs text-slate-500">
                    <ion-icon name="clipboard-outline" class="text-lg"></ion-icon>
                    @foreach ($payload['workshops'] as $ws)
                        <div class="p-1 px-3 rounded-full border-[0.5px] border-primary text-primary">
                            {{ $ws['title'] }}
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="flex flex-col gap-1">
            <div class="text-xs text-slate-500">Total Pembayaran :</div>
            <div class="text-lg text-primary font-medium">
                {{ currency_encode($payload['ticket']['price']) }}
            </div>
        </div>
    </div>

    <div class="flex items-center gap-4 mt-4">
        <a href="{{ route('register', ['step' => 'detail', 'p' => base64_encode( json_encode($payload) ) ]) }}" class="p-3 px-5 rounded-lg bg-slate-200 text-slate-600 text-sm">
            Ada yang Salah
        </a>
        <div class="flex grow"></div>
        <button class="p-3 px-5 rounded-lg bg-primary text-white font-medium text-sm">
            Benar. Konfirmasi Pendaftaran
        </button>
    </div>
    
</form>

@endsection