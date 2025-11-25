@extends('layouts.admin')

@section('title', "Peserta")

@php
    use Carbon\Carbon;

    $statusColors = [
        'PENDING' => "yellow",
        'CANCELLED' => "red",
        'EXPIRED' => "red",
        'PAID' => "green",
    ]
@endphp
    
@section('content')
<div class="p-8 flex flex-col gap-6">
    <div class="bg-white rounded-lg shadow-sm p-4 flex items-center gap-4">
        <form class="border rounded-lg flex items-center gap-4 grow px-4">
            <button class="flex items-center">
                <ion-icon name="search-outline"></ion-icon>
            </button>
            <input type="text" name="q" class="w-full h-14 text-sm text-slate-500 outline-0" placeholder="Cari nama / no. pendaftaran..." value="{{ $request->q }}">
            @if ($request->q != "")
                <button type="button" class="flex items-center" onclick="addFilter('q', null)">
                    <ion-icon name="close-outline" class="text-red-400 text-xl"></ion-icon>
                </button>
            @endif
        </form>

        <button class="bg-white text-slate-700 text-sm font-medium h-14 px-6 border rounded-lg flex items-center gap-3" onclick="toggleHidden('#FilterPeserta')">
            <ion-icon name="filter-outline" class="text-xl"></ion-icon>
            Filter
            @if ($filterCount > 0)
                <div class="w-7 h-7 ms-2 flex items-center justify-center rounded-full bg-primary text-white text-xs font-medium">
                    {{ $filterCount }}
                </div>
            @endif
        </button>

        <div class="group relative">
            <button class="bg-green-600 text-white text-sm font-medium h-14 px-6 rounded-lg flex items-center gap-3" onclick="addFilter({download: 1})">
                <ion-icon name="download-outline" class="text-lg"></ion-icon>
                Download Excel
            </button>

            @if ($request->q != "" || $request->payment_status != "" || $request->ticket_id != "")
                <div class="absolute top-0 right-0 bg-white p-4 border rounded-lg hidden group-hover:flex flex-col z-40 whitespace-nowrap">
                    <div class="text-sm text-slate-600">Download dengan Filter?</div>
                    <div class="text-xs text-slate-500">Data yang diunduh akan terbatas pada filter yang diterapkan.</div>

                    <button class="w-full h-10 bg-green-600 text-xs text-center text-white font-bold rounded-lg mb-2 mt-4" onclick="addFilter({download: 1})">
                        Tetap Unduh
                    </button>
                    <a href="?" class="w-full h-10 bg-slate-200 rounded-lg flex items-center justify-center text-xs text-slate-700">
                        Bersihkan Filter
                    </a>
                </div>
            @endif
        </div>
    </div>

    @include('partials.flash_message')

    <div class="overflow-x-auto scrollbar-hide bg-white p-4 shadow-sm rounded-lg">
        <table class="min-w-max table-auto border-collapse">
            <thead>
                <tr class="text-left">
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400"></th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">No. Pendaftaran</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">NIK</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">Nama</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">Email</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">No. Telepon</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">
                        <div class="flex items-center">
                            <ion-icon name="time-outline" class="text-lg text-slate-500"></ion-icon>
                        </div>
                    </th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">Tiket</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">Pembayaran</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach ($users as $user)
                    @php
                        $color = $statusColors[strtoupper($user->transaction->payment_status)];
                    @endphp
                    <tr class="hover:bg-slate-100 transition-colors">
                        <td class="py-3 px-4 text-sm text-slate-600">
                            <div class="w-8 h-8 flex items-center justify-center bg-white border rounded cursor-pointer group relative">
                                <ion-icon name="ellipsis-horizontal" class="text-slate-600"></ion-icon>
                                <div class="absolute top-0 left-0 bg-white border rounded py-3 hidden group-hover:flex flex-col z-10">
                                    @if ($user->transaction->payment_status == "PENDING")
                                        <a href="{{ route('admin.transaction.confirm', $user->transaction->id) }}" class="flex items-center gap-3 p-2 px-4 hover:bg-slate-100 text-sm text-slate-700 whitespace-nowrap" onclick="ConfirmTrx(event, '{{ $user }}')">
                                            <ion-icon name="checkmark-circle-outline" class="text-lg text-green-500"></ion-icon>
                                            Konfirmasi Pembayaran
                                        </a>
                                    @endif
                                    @if ($me->role == "admin")
                                        <a href="{{ route('admin.peserta.update', $user->id) }}" class="flex items-center gap-3 p-2 px-4 hover:bg-slate-100 text-sm text-slate-700 whitespace-nowrap" onclick="EditPeserta(event, '{{ $user }}')">
                                            <ion-icon name="create-outline" class="text-lg text-primary"></ion-icon>
                                            Edit Peserta
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            <div class="flex items-center gap-3">
                                #{{ $user->transaction->id }}
                                @if ($user->transaction->payment_status == "PENDING" && $user->transaction->payment_evidence != null)
                                    <a href="{{ route('admin.transaction.confirm', $user->transaction->id) }}" class="p-1 px-4 border-[0.5px] border-green-500 hover:bg-green-500 rounded-full text-xs text-green-500 hover:text-white" onclick="ConfirmTrx(event, '{{ $user }}')">
                                        Konfirmasi
                                    </a>
                                @endif
                            </div>
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            {{ $user->nik }}
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            {{ $user->name }}
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            {{ $user->email }}
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            0{{ $user->whatsapp }}
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            {{ Carbon::parse($user->created_at)->isoFormat('DD MMMM Y HH:mm:ss') }}
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            {{ $user->transaction->ticket->name }}
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            <div class="flex">
                                <div class="p-1 px-4 rounded-full border border-{{ $color }}-500 text-{{ $color }}-500 bg-{{ $color }}-100 text-xs font-medium">
                                    {{ $user->transaction->payment_status }}
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            <div class="w-8 h-8 flex items-center justify-center bg-white border rounded cursor-pointer group relative">
                                <ion-icon name="ellipsis-horizontal" class="text-slate-600"></ion-icon>
                                <div class="absolute top-0 right-0 bg-white border rounded py-3 hidden group-hover:flex flex-col z-10">
                                    @if ($user->transaction->payment_status == "PENDING")
                                        <a href="{{ route('admin.transaction.confirm', $user->transaction->id) }}" class="flex items-center gap-3 p-2 px-4 hover:bg-slate-100 text-sm text-slate-700 whitespace-nowrap" onclick="ConfirmTrx(event, '{{ $user }}')">
                                            <ion-icon name="checkmark-circle-outline" class="text-lg text-green-500"></ion-icon>
                                            Konfirmasi Pembayaran
                                        </a>
                                    @endif
                                    @if ($me->role == "admin")
                                        <a href="{{ route('admin.peserta.update', $user->id) }}" class="flex items-center gap-3 p-2 px-4 hover:bg-slate-100 text-sm text-slate-700 whitespace-nowrap" onclick="EditPeserta(event, '{{ $user }}')">
                                            <ion-icon name="create-outline" class="text-lg text-primary"></ion-icon>
                                            Edit Peserta
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('ModalArea')

@include('admin.peserta.ConfirmTransaction')
@include('admin.peserta.filter')
@include('admin.peserta.edit')
    
@endsection

@section('javascript')
<script>
    const ConfirmTrx = (event, data) => {
        event.preventDefault();
        data = JSON.parse(data);
        const link = event.currentTarget;
        let evidence = select("#ConfirmTrx #evidence");

        select("#ConfirmTrx #user_name").innerHTML = data.name;
        select("#ConfirmTrx #ticket_name").innerHTML = data.transaction.ticket.name;
        select("#ConfirmTrx #amount").innerHTML = Currency(data.transaction.payment_amount).encode();
        select("#ConfirmTrx form").setAttribute('action', link.href);

        if (data.transaction.payment_evidence == null) {
            select("#ConfirmTrx #EvidenceForm").classList.remove('hidden');
            select("#ConfirmTrx #EvidenceStatement").classList.add('hidden');
            select("#ConfirmTrx #evidence").setAttribute('required', 'required');
        } else {
            select("#ConfirmTrx #EvidenceStatement").classList.remove('hidden');
            select("#ConfirmTrx #EvidenceForm").classList.add('hidden');
            select("#ConfirmTrx #evidence").removeAttribute('required');
            select("#ConfirmTrx #EvidenceImage").setAttribute('src', `/storage/payment_evidences/${data.transaction.payment_evidence}`)
        }

        toggleHidden("#ConfirmTrx");
    }

    const EditPeserta = (event, data) => {
        event.preventDefault();
        data = JSON.parse(data);
        const link = event.currentTarget;

        select("#EditPeserta form").setAttribute('action', link.href);

        select("#EditPeserta #nik").value = data.nik;
        select("#EditPeserta #name").value = data.name;
        select("#EditPeserta #email").value = data.email;
        select("#EditPeserta #whatsapp").value = data.whatsapp;

        toggleHidden("#EditPeserta")
    }
</script>
@endsection