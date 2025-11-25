@extends('layouts.admin')

@php
    $steps = [
        'Buka WhatsApp di Ponsel',
        'Di Android, Ketuk Menu Titik Tiga Vertikal. Di iPhone ketuk Pengaturan',
        'Ketuk Perangkat Tertaut, lalu Tautkan Perangkat',
        'Pindai QR di atas untuk mengonfirmasi'
    ];
@endphp

@section('content')
<div class="p-8 flex mobile:flex-col gap-8">
    <div class="bg-white rounded-lg shadow-sm p-8 w-4/12 flex flex-col gap-4 {{ $devices->count() > 0 ? 'hidden' : '' }}" id="AddArea">
        <div class="w-full aspect-square rounded-lg bg-slate-200 flex flex-col gap-2 items-center justify-center" id="QRArea">
            <button class="p-3 px-5 rounded-lg text-xs text-white bg-primary font-bold" onclick="getQR(this)">
                Generate QR
            </button>
        </div>
        
        <div class="bg-primary text-white text-sm p-3 rounded-lg flex items-center gap-4 hidden" id="ReloadAlert">
            <div class="text-sm flex grow">Sudah scan?</div>
            <a href="{{ route('admin.settings.whatsapp') }}" class="p-2 px-4 rounded bg-white text-primary font-medium text-xs">
                Muat Ulang
            </a>
        </div>

        <h4>Langkah untuk login</h4>
        <div class="flex flex-col gap-2">
            @foreach ($steps as $s => $step)
                <div class="flex items-center gap-4">
                    <div class="w-6 h-6 rounded-full border border-primary text-xs text-slate-700 flex items-center justify-center">
                        {{ $s + 1}}
                    </div>
                    <div class="text-sm text-slate-600 flex basis-24 grow">
                        {{ $step }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="bg-white rounded-lg shadow-sm p-8 flex grow flex-col gap-4">
        <div class="flex items-center gap-4">
            <div class="flex flex-col gap-1 grow">
                <h2 class="text-xl text-slate-700 font-medium">Perangkat Terhubung</h2>
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-green-500"></div>
                    <h4 class="text-xs text-slate-500">
                        {{ $devices->count() }} Perangkat Terhubung
                    </h4>
                </div>
            </div>

            @if ($devices->count() > 0)
                <button class="bg-primary text-white text-xs font-medium p-3 px-5 rounded-lg flex items-center gap-2" onclick="toggleHidden('#AddArea')">
                    <ion-icon name="add-outline" class="text-lg"></ion-icon>
                    Perangkat
                </button>
            @endif
        </div>

        @include('partials.flash_message')
        
        <div class="flex flex-col">
            @foreach ($devices as $dev)
                <div class="flex items-center gap-6">
                    <img src="{{ $dev->profile_picture }}" alt="{{ $dev->id }}" class="w-20 h-20 rounded-lg object-cover bg-slate-200">
                    <div class="flex flex-col grow gap-1">
                        <div class="text-sm font-medium text-slate-700">{{ $dev->name }}</div>
                        <div class="text-xs text-slate-500">{{ $dev->number }}</div>
                    </div>
                    @if ($dev->is_primary)
                        <div class="text-xs p-2 px-4 rounded-full border-[0.5px] border-primary bg-primary text-white">Utama</div>
                    @else
                        <a href="{{ route('admin.settings.whatsapp.primary', $dev->id) }}" class="text-xs p-2 px-4 rounded-full border-[0.5px] border-primary bg-primary-transparent text-primary">Jadikan Utama</a>
                    @endif

                    <a href="{{ route('admin.settings.whatsapp.remove', $dev->id) }}" class="flex items-center justify-center w-10 h-10 rounded-lg bg-red-500 text-white" onclick="RemoveDevice(event, '{{ $dev }}')">
                        <ion-icon name="trash-outline"></ion-icon>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('ModalArea')

@include('admin.settings.whatsapp.remove')

@endsection

@section('javascript')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    let isGeneratingQR = false;
    const QRArea = select("#QRArea");

    const getQR = async (btn) => {
        if (isGeneratingQR) return;

        isGeneratingQR = true;

        btn.innerHTML = "Generating QR Code...";
        try {
            const response = await axios.post(`{{ env('WA_URL') }}/connect`, {
                callback_url: "{{ $_SERVER['HTTP_HOST'] }}/api/callback/wa"
            });
            const res = await response.data;
            console.log(res);
            

            QRArea.innerHTML = "";

            let img = document.createElement('img');
            img.classList.add('w-full', 'aspect-square', 'rounded-lg', 'bg-whie');
            QRArea.appendChild(img);

            setInterval(() => {
                axios.get(`{{ env('WA_URL') }}/qr/${res.client_id}`)
                .then(response => {
                    let data = response.data;
                    console.log(data);
                    img.src = data.qr;
                    
                    isGeneratingQR = false;
                });
            }, 2000);

            setTimeout(() => {
                select("#ReloadAlert").classList.remove('hidden');
            }, 5000);
        } catch (err) {
            console.error(err);
        }
        
    }

    const RemoveDevice = (event, data) => {
        event.preventDefault();
        data = JSON.parse(data);
        const link = event.currentTarget;

        select("#RemoveDevice form").setAttribute('action', link.href);
        select("#RemoveDevice #name").innerHTML = data.name;

        toggleHidden("#RemoveDevice");
    }
</script>
@endsection