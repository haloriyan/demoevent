@extends('layouts.admin')

@section('title', "Peserta")

@section('head')
<!-- Basic Icons -->
<link href="https://cdn.boxicons.com/3.0.8/fonts/basic/boxicons.min.css" rel="stylesheet">
{{-- <link href="https://cdn.boxicons.com/3.0.8/fonts/filled/boxicons-filled.min.css" rel="stylesheet">
<link href="https://cdn.boxicons.com/3.0.8/fonts/brands/boxicons-brands.min.css" rel="stylesheet"> --}}
@endsection

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

        {{-- <div class="group relative">
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
        </div> --}}

        <div class="group relative">
            <div class="w-12 h-12 flex items-center justify-center rounded-full border cursor-pointer">
                <ion-icon name="download-outline" class="text-xl text-green-500"></ion-icon>
            </div>

            <div class="absolute -top-2 right-0 bg-white rounded-lg border py-3 z-40 whitespace-nowrap hidden group-hover:flex flex-col">

                <!-- ITEM WITH SUBMENU -->
                <div class="relative group/item">
                    <button class="flex items-center gap-3 p-2 px-4 w-full text-sm text-slate-600 hover:bg-slate-100" onclick="addFilter({download: 1})">
                        <ion-icon name="people-outline" class="text-xl text-green-500"></ion-icon>
                        Data Peserta
                    </button>

                    @if ($request->q != "" || $request->payment_status != "" || $request->ticket_id != "")
                    <div class="absolute top-0 right-full ml-2 bg-white p-4 border rounded-lg hidden group-hover/item:flex flex-col z-50 whitespace-nowrap">
                        <div class="text-sm text-slate-600">Download dengan Filter?</div>
                        <div class="text-xs text-slate-500">Data yang diunduh akan terbatas pada filter yang diterapkan.</div>

                        <button class="w-full h-10 bg-green-600 text-xs text-center text-white font-bold rounded-lg mb-2 mt-4"
                            onclick="addFilter({download: 1})">
                            Tetap Unduh
                        </button>

                        <a href="?" class="w-full h-10 bg-slate-200 rounded-lg flex items-center justify-center text-xs text-slate-700">
                            Bersihkan Filter
                        </a>
                    </div>
                    @endif
                </div>

                <!-- NORMAL ITEM -->
                <button class="flex items-center gap-3 p-2 px-4 w-full text-sm text-slate-600 hover:bg-slate-100" onclick="addFilter({ qr: 1 })">
                    <i class="bx bx-qr text-lg text-green-500"></i>
                    Unduh QR Peserta
                </button>
                <a href="{{ route('admin.workshop.export') }}" class="flex items-center gap-3 p-2 px-4 w-full text-sm text-slate-600 hover:bg-slate-100">
                    <ion-icon name="clipboard-outline" class="text-xl text-green-500"></ion-icon>
                    Peserta Workshop
                </a>

            </div>
        </div>
    </div>

    @include('partials.flash_message')

    <div class="overflow-x-auto scrollbar-hide bg-white p-4 shadow-sm rounded-lg">
        <table class="min-w-max table-auto border-collapse">
            <thead>
                <tr class="text-left">
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400"></th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">No.</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">NIK</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">Nama</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">Instansi</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">Email</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">No. Telepon</th>
                    
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">Tiket</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">Status Pembayaran</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">
                        <div class="flex items-center">
                            <ion-icon name="time-outline" class="text-lg text-slate-500"></ion-icon>
                        </div>
                    </th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach ($users as $user)
                    @php
                        $color = $statusColors[strtoupper($user->transaction->payment_status)];
                        $userWorkshops = $user->transaction->workshops;
                    @endphp
                    <tr class="hover:bg-slate-100 transition-colors">
                        <td class="py-3 px-4 text-sm text-slate-600">
                            <div class="w-8 h-8 flex items-center justify-center bg-white border rounded cursor-pointer group relative">
                                <ion-icon name="ellipsis-horizontal" class="text-slate-600"></ion-icon>
                                <div class="absolute top-0 left-0 bg-white border rounded py-3 hidden group-hover:flex flex-col z-10">
                                    @if ($user->transaction->payment_status == "PENDING")
                                        <a href="{{ route('admin.transaction.confirm', $user->transaction->id) }}" class="flex items-center gap-3 p-2 px-4 hover:bg-slate-100 text-sm text-slate-700 whitespace-nowrap" onclick="ConfirmTrx(event, '{{ base64_encode(json_encode($user)) }}')">
                                            <ion-icon name="checkmark-circle-outline" class="text-lg text-green-500"></ion-icon>
                                            Konfirmasi Pembayaran
                                        </a>
                                        <a href="{{ route('admin.transaction.resend-order', $user->transaction->id) }}" class="flex items-center gap-3 p-2 px-4 hover:bg-slate-100 text-sm text-slate-700 whitespace-nowrap">
                                            <ion-icon name="mail-outline" class="text-lg text-primary"></ion-icon>
                                            Kirim Ulang Konfirmasi
                                        </a>
                                    @endif
                                    @if ($user->transaction->payment_status == "PAID")
                                        <a href="{{ route('admin.transaction.confirm', ['id' => $user->transaction->id, 'is_resend' => 'y']) }}" class="flex items-center gap-3 p-2 px-4 hover:bg-slate-100 text-sm text-slate-700 whitespace-nowrap">
                                            <ion-icon name="qr-code-outline" class="text-lg text-green-500"></ion-icon>
                                            Kirim Ulang QR
                                        </a>
                                    @endif
                                    
                                    @if ($me->role == "admin")
                                        <a href="{{ route('admin.peserta.update', $user->id) }}" class="flex items-center gap-3 p-2 px-4 hover:bg-slate-100 text-sm text-slate-700 whitespace-nowrap" onclick='EditPeserta(event, @json($user))'>
                                            <ion-icon name="create-outline" class="text-lg text-primary"></ion-icon>
                                            Edit Peserta
                                        </a>
                                    @endif
                                    @if (
                                        $user->transaction->payment_status == "PENDING" ||
                                        $user->transaction->payment_status == "PAID"
                                    )
                                        <div class="my-2 border-t border-slate-100"></div>
                                        <a href="{{ route('admin.transaction.cancel', $user->transaction->id) }}" class="flex items-center gap-3 p-2 px-4 hover:bg-slate-100 text-sm text-slate-700 whitespace-nowrap" onclick="ConfirmCancel(event, '{{ $user->name }}', '{{ $user->transaction->id }}', '{{ $user->transaction->payment_status }}')">
                                            <ion-icon name="close-circle-outline" class="text-lg text-red-500"></ion-icon>
                                            Batalkan Transaksi
                                        </a>
                                    @endif

                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            <div class="flex items-center gap-3">
                                {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                                <div class="p-1 px-3 rounded-full border border-{{ $color }}-500 text-{{ $color }}-500 bg-{{ $color }}-100 text-xs font-medium">
                                    {{ $user->transaction->payment_status }}
                                </div>
                                @if ($user->transaction->payment_status == "PENDING" && $user->transaction->payment_evidence != null)
                                    <a href="{{ route('admin.transaction.confirm', $user->transaction->id) }}" class="p-1 px-4 border-[0.5px] border-green-500 hover:bg-green-500 rounded-full text-xs text-green-500 hover:text-white" onclick="ConfirmTrx(event, '{{ base64_encode(json_encode($user)) }}')">
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
                            {{ $user->instansi ?? '-' }}
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            {{ $user->email }}
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            0{{ $user->whatsapp }}
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            @if ($user->transaction->ticket->category_id != null)
                                <b>&lt;{{ $user->transaction->ticket->category->name }}&gt;</b> {{ $user->transaction->ticket->name }}
                            @else
                                {{ $user->transaction->ticket->name }}
                            @endif
                             : {{ $user->transaction->ticket->id }}
                             @if ($userWorkshops)
                                 <div class="flex items-center gap-2 mt-1">
                                     @foreach (json_decode($userWorkshops) ?? [] as $ws)
                                         <div class="p-1 px-3 border border-primary rounded-full text-xs text-primary">
                                             {{ $ws->title }}
                                         </div>
                                     @endforeach
                                 </div>
                             @endif
                             </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            <div class="flex">
                                <div class="p-1 px-4 rounded-full border border-{{ $color }}-500 text-{{ $color }}-500 bg-{{ $color }}-100 text-xs font-medium">
                                    {{ $user->transaction->payment_status }}
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            {{ Carbon::parse($user->created_at)->isoFormat('DD MMMM Y HH:mm:ss') }}
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            <div class="w-8 h-8 flex items-center justify-center bg-white border rounded cursor-pointer group relative">
                                <ion-icon name="ellipsis-horizontal" class="text-slate-600"></ion-icon>
                                 <div class="absolute top-0 right-0 bg-white border rounded py-3 hidden group-hover:flex flex-col z-10">
                                      @if ($user->transaction->payment_status == "PENDING")
                                          <a href="{{ route('admin.transaction.confirm', $user->transaction->id) }}" class="flex items-center gap-3 p-2 px-4 hover:bg-slate-100 text-sm text-slate-700 whitespace-nowrap" onclick="ConfirmTrx(event, '{{ base64_encode(json_encode($user)) }}')">
                                              <ion-icon name="checkmark-circle-outline" class="text-lg text-green-500"></ion-icon>
                                              Konfirmasi Pembayaran
                                          </a>
                                      @endif
                                      <a href="{{ route('admin.transaction.resend-order', $user->transaction->id) }}" class="flex items-center gap-3 p-2 px-4 hover:bg-slate-100 text-sm text-slate-700 whitespace-nowrap">
                                          <ion-icon name="mail-outline" class="text-lg text-primary"></ion-icon>
                                          Kirim Ulang Konfirmasi
                                      </a>
                                      @if ($me->role == "admin")
                                          <a href="{{ route('admin.peserta.update', $user->id) }}" class="flex items-center gap-3 p-2 px-4 hover:bg-slate-100 text-sm text-slate-700 whitespace-nowrap" onclick='EditPeserta(event, @json($user))'>
                                              <ion-icon name="create-outline" class="text-lg text-primary"></ion-icon>
                                              Edit Peserta
                                          </a>
                                      @endif
                                     @if ($user->transaction->payment_status == "PENDING" || $user->transaction->payment_status == "PAID")
                                         <div class="my-2 border-t border-slate-100"></div>
                                         <a href="{{ route('admin.transaction.cancel', $user->transaction->id) }}" class="flex items-center gap-3 p-2 px-4 hover:bg-slate-100 text-sm text-slate-700 whitespace-nowrap" onclick="ConfirmCancel(event, '{{ $user->name }}', '{{ $user->transaction->id }}', '{{ $user->transaction->payment_status }}')">
                                             <ion-icon name="close-circle-outline" class="text-lg text-red-500"></ion-icon>
                                             Batalkan Transaksi
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

    {{ $users->links() }}
</div>
@endsection

@section('ModalArea')

@include('admin.peserta.ConfirmTransaction')
@include('admin.peserta.filter')
@include('admin.peserta.edit')
@include('WorkshopSelector')

<form id="CancelForm" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    @csrf
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md overflow-hidden">
        <div class="p-6 flex flex-col gap-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 flex items-center justify-center rounded-full bg-red-100 text-red-500">
                    <ion-icon name="alert-circle-outline" class="text-2xl"></ion-icon>
                </div>
                <div class="text-lg font-bold text-slate-800">Batalkan Transaksi?</div>
            </div>
            <div class="text-sm text-slate-600 leading-relaxed" id="UnpaidForm">
                Apakah Anda yakin ingin membatalkan transaksi untuk <b id="CancelUser"></b> (ID: <span id="CancelTrxID"></span>)? 
            </div>
            <div id="PaidForm" class="flex flex-col gap-4 hidden">
                <div class="text-sm text-slate-600">
                    Masukkan informasi bank tujuan pengembalian dana :
                </div>
                <div class="flex flex-col gap-1">
                    <div class="text-xs text-slate-500">Bank Tujuan</div>
                    <input type="text" name="bank_name" class="w-full h-12 border rounded-lg px-4 text-sm text-slate-600">
                </div>
                <div class="flex flex-col gap-1">
                    <div class="text-xs text-slate-500">No. Rekening</div>
                    <input type="text" name="bank_number" class="w-full h-12 border rounded-lg px-4 text-sm text-slate-600">
                </div>
                <div class="flex flex-col gap-1">
                    <div class="text-xs text-slate-500">Atas nama</div>
                    <input type="text" name="bank_account" class="w-full h-12 border rounded-lg px-4 text-sm text-slate-600">
                </div>
            </div>
            <div class="text-xs text-slate-500">
                Tindakan ini akan mengembalikan kuota tiket dan workshop, serta mengizinkan peserta untuk mendaftar kembali menggunakan email dan NIK yang sama.
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" class="px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 rounded-lg" onclick="toggleHidden('#CancelForm')">
                    Batal
                </button>
                <button type="submit" form="CancelForm" class="px-4 py-2 text-sm font-medium text-white bg-red-500 hover:bg-red-600 rounded-lg">
                    Batalkan Transaksi
                </button>
            </div>
        </div>
    </div>
</div>

@endsection


@section('javascript')
<script>
    const ConfirmTrx = (event, data) => {
        event.preventDefault();
        data = atob(data);
        console.log(data);
        
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

    const ConfirmCancel = (event, name, trxId, paymentStatus) => {
        event.preventDefault();
        const link = event.currentTarget;
        console.log(paymentStatus);
        
        select("#CancelForm #CancelUser").innerHTML = name;
        select("#CancelForm #CancelTrxID").innerHTML = trxId;
        select("#CancelForm").setAttribute('action', link.href);

        if (paymentStatus == "PAID") {
            select("#CancelForm #PaidForm").classList.remove('hidden');
        } else {
            select("#CancelForm #PaidForm").classList.add('hidden');
        }

        toggleHidden("#CancelForm");
    }

    let currentUser = null;
    let maxWorkshops = 2;
    let selectedWorkshops = {};
    let WSCategories = @json($workshops);

    const parseJsonData = (data) => {
        if (typeof data === 'string') {
            try {
                return JSON.parse(data);
            } catch (error) {
                console.error('Failed to parse JSON data', error, data);
                return null;
            }
        }
        return data;
    }

    const EditPeserta = (event, data) => {
        event.preventDefault();
        data = parseJsonData(data);
        if (!data) {
            return;
        }
        currentUser = data;
        const link = event.currentTarget;
 
        select("#EditPeserta form").setAttribute('action', link.href);
 
        select("#EditPeserta #nik").value = data.nik;
        select("#EditPeserta #name").value = data.name;
        select("#EditPeserta #email").value = data.email;
        select("#EditPeserta #whatsapp").value = data.whatsapp;
        select("#EditPeserta #instansi").value = data.instansi;

        let qrString = btoa(JSON.stringify({
            trx_id: data.transaction.id,
            user_id: data.id,
        }));
        
        select("#EditPeserta #QRArea").innerHTML = `<img src="https://api.qrserver.com/v1/create-qr-code/?data=${qrString}">`;

        const workshops = parseJsonData(data.transaction.workshops) ?? [];
        select("#EditPeserta #workshops").value = JSON.stringify(workshops);
        
        const wsArea = select("#EditPeserta #SelectedWSArea");
        wsArea.innerHTML = "";
        workshops.forEach(ws => {
            wsArea.innerHTML += `<div class="p-1 px-3 border border-primary rounded-full text-xs text-primary">${ws.title}</div>`;
        });
 
        toggleHidden("#EditPeserta")
    }

    const getAngka = text => {
        let texts = text.split(' ');
        let toReturn = null;
        texts.forEach((txt, t) => {
            if (!isNaN(txt)) {
                toReturn = txt;
            }
        });
        return toReturn !== null ? parseInt(toReturn) : null;
    }

    const OpenWorkshopPicker = () => {
        if (!currentUser) return;
        
        const ticket = currentUser.transaction.ticket;
        const jumlahWS = getAngka(ticket.name);
        
        if (jumlahWS !== null) {
            maxWorkshops = jumlahWS;
            const ticketCategoryID = ticket.category_id;
            
            // Filter and render workshop categories
            select("#WSCategoryRender").innerHTML = "";
            const filteredCategories = WSCategories.map(cat => ({
                ...cat,
                workshops: cat.workshops.filter(ws => ws.ticket_category_id === ticketCategoryID)
            })).filter(cat => cat.workshops.length > 0);

            filteredCategories.map((cat, c) => {
                let WSCat = document.createElement('DIV');
                WSCat.classList.add('flex', 'flex-col', 'gap-4');
                WSCat.setAttribute('data-category', cat.id);
                WSCat.setAttribute('data-category-name', cat.name);
                WSCat.innerHTML = `<div class="p-3 px-4 bg-primary text-white text-sm font-medium">
                    ${cat.name}
                </div>
                <div id="WorkshopItemArea_${cat.id}" class='flex flex-col gap-4'></div>`;
                select("#WSCategoryRender").appendChild(WSCat);
 
                cat.workshops.map((ws, w) => {
                    let WSItem = document.createElement('DIV');
                    let speakers = ws.speakers?.split(',') ?? [];
                    WSItem.classList.add('workshop-item', 'cursor-pointer', 'border', 'rounded-lg', 'p-3', 'px-4', 'text-sm', 'flex', 'items-center', 'gap-3');
                    WSItem.setAttribute('data-id', ws.id);
                    WSItem.setAttribute('data-title', ws.title);
                    WSItem.addEventListener('click', function (e) {
                        ChooseWorkshop(e);
                    });
                    
                    let speakersContent = "<div class='flex flex-col gap-2 text-xs'>";
                    speakers.map((speaker, s) => {
                        speakersContent += `<div class='flex items-center gap-1'>
                            <div class="w-1 h-1 rounded-full bg-primary"></div>
                            ${speaker}
                        </div>`;
                    })
                    speakersContent += "</div>";
 
                    WSItem.innerHTML = `<div class='flex flex-col gap-1 basis-24 grow'>
                        <div class='text-sm font-medium'>${ws.title}</div>
                        ${speakersContent}
                    </div>
                    <div class='text-xs'>${ws?.start_time?.split(':').slice(0, 2).join(':') ?? '-'}</div>`
 
                    select(`#WorkshopItemArea_${cat.id}`).appendChild(WSItem);
                })
            })
            
            select("#WSPickerSubmitArea")?.classList.add('hidden');
            select("#WorkshopPicker #ModalTitle").innerHTML = `Pilih ${jumlahWS} Workshop`;
            
            // Initialize current selections
            selectedWorkshops = {};
            const currentWorkshops = parseJsonData(select("#EditPeserta #workshops").value) ?? [];
            currentWorkshops.forEach(work => {
                const element = select(`.workshop-item[data-id='${work.id}']`);
                if (element) element.click();
            });

            toggleHidden('#WorkshopPicker');
        } else {
            alert("Tiket ini tidak memiliki kuota workshop");
        }
    }

    function ChooseWorkshop(event) {
        const element = event.currentTarget;
        const categoryWrapper = element.closest('[data-category]');
        if (!categoryWrapper) return;
 
        const categoryId = categoryWrapper.dataset.category;
        const categoryName = categoryWrapper.dataset.categoryName;
        const workshopId = element.dataset.id;
        const workshopTitle = element.dataset.title;
        const isSelected = element.classList.contains("border-primary");
 
        if (isSelected) {
            element.classList.remove("border-primary", "bg-primary", "text-white");
            delete selectedWorkshops[categoryId];
            return;
        }
 
        const totalSelected = Object.keys(selectedWorkshops).length;
        const isReplacingSameCategory = !!selectedWorkshops[categoryId];
 
        if (totalSelected >= maxWorkshops && !isReplacingSameCategory) {
            const previousCategoryId = Object.keys(selectedWorkshops)[0];
            const previousSelectedElement = select(`[data-category="${previousCategoryId}"] .border-primary`);
            if (previousSelectedElement) {
                previousSelectedElement.classList.remove("border-primary", "bg-primary", "text-white");
            }
            delete selectedWorkshops[previousCategoryId];
        }
 
        if (selectedWorkshops[categoryId]) {
            const previous = categoryWrapper.querySelector(".border-primary");
            if (previous) {
                previous.classList.remove("border-primary", "bg-primary", "text-white");
            }
        }
 
        element.classList.add("border-primary", "bg-primary", "text-white");
        selectedWorkshops[categoryId] = {
            id: workshopId,
            title: workshopTitle,
            category: { id: categoryId, name: categoryName }
        };
        
        if (Object.keys(selectedWorkshops).length === maxWorkshops) {
            select("#WSPickerSubmitArea")?.classList.remove('hidden');
        }
    }
 
    const ConfirmWorkshop = (e) => {
        e.preventDefault();
        let output = Object.values(selectedWorkshops);
        select("input#workshops").value = JSON.stringify(output);
        
        // Update the UI in EditPeserta modal
        const wsArea = select("#EditPeserta #SelectedWSArea");
        wsArea.innerHTML = "";
        output.forEach(ws => {
            wsArea.innerHTML += `<div class="p-1 px-3 border border-primary rounded-full text-xs text-primary">${ws.title}</div>`;
        });
        
        toggleHidden("#WorkshopPicker");
    }
</script>
@endsection