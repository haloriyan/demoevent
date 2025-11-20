@extends('layouts.register')

@section('title', "Pendaftaran")
    
@section('content')

<form action="{{ route('index', ['step' => "welcome"]) }}" class="SlideItem flex flex-col grow gap-8" method="POST">
    @csrf
    <input type="hidden" name="ticket_id" id="ticket_id">
    <div class="flex flex-col gap-1">
        <h2 class="text-xl text-slate-700 font-medium">Paket Registrasi</h2>
        <div class="text-sm text-slate-600">
            Pilih paket pendaftaran yang ingin Anda ikuti.
        </div>
    </div>

    <div class="flex flex-col grow gap-8">
        @foreach ($categories as $category)
            <div class="flex flex-col gap-4">
                <h3 class="text-lg text-slate-500">{{ $category->name }}</h3>
                <div class="flex flex-col gap-2">
                    @foreach ($category->tickets as $ticket)
                        <div class="flex items-center gap-4 border rounded-lg p-4 cursor-pointer TicketItem" id="Ticket_{{ $ticket->id }}" onclick="ChooseTicket('{{ $ticket }}', this)">
                            <div class="w-6 h-6 rounded bg-slate-200 flex items-center justify-center">
                                <div class="w-4 h-4 rounded RadioInner"></div>
                            </div>
                            <div class="text-slate-700 flex grow">{{ $ticket->name }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <div class="flex items-center gap-4 hidden" id="Bottom">
        <div class="flex flex-col gap-1 basis-24 grow">
            <div class="text-xs text-slate-500">Total Pembayaran :</div>
            <div class="text-lg text-primary font-medium" id="PriceArea">{{ currency_encode(0) }}</div>
        </div>
        <button class="p-3 px-5 rounded-lg bg-primary text-white text-sm font-medium">
            Lanjut
        </button>
    </div>
</div>

@endsection

@section('javascript')
<script>
    const ChooseTicket = (data, btn) => {
        data = JSON.parse(data);
        selectAll(".TicketItem").forEach(item => {
            item.classList.remove('border-primary');
        });
        selectAll(".RadioInner").forEach(item => item.classList.remove('bg-primary'));

        btn.classList.add('border-primary');

        select(`#Ticket_${data.id} .RadioInner`).classList.add('bg-primary')
        select("#PriceArea").innerHTML = Currency(data.price).encode();
        select("#ticket_id").value = data.id;

        select("#Bottom").classList.remove('hidden');
    }
</script>
@endsection