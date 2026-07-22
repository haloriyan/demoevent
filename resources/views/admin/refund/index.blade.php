@extends('layouts.admin')

@section('title', "Refund")

@section('head')
<link href="https://cdn.boxicons.com/3.0.8/fonts/basic/boxicons.min.css" rel="stylesheet">
@endsection

@php
    use Carbon\Carbon;

    $statusColors = [
        'PENDING' => "yellow",
        'PAID' => "green",
    ];
@endphp

@section('content')
<div class="p-8 flex flex-col gap-6">
    <div class="bg-white rounded-lg shadow-sm p-4 flex items-center gap-4">
        <form class="border rounded-lg flex items-center gap-4 grow px-4">
            <button class="flex items-center">
                <ion-icon name="search-outline"></ion-icon>
            </button>
            <input type="text" name="q" class="w-full h-14 text-sm text-slate-500 outline-0" placeholder="Cari nama, bank, no. rekening..." value="{{ $request->q }}">
            @if ($request->q != "")
                <button type="button" class="flex items-center" onclick="addFilter('q', null)">
                    <ion-icon name="close-outline" class="text-red-400 text-xl"></ion-icon>
                </button>
            @endif
        </form>

        <div class="flex items-center gap-2">
            <select onchange="addFilter('payment_status', this.value)" class="h-14 px-4 border rounded-lg text-sm text-slate-600 bg-white">
                <option value="">Semua Status</option>
                <option value="PENDING" {{ $request->payment_status == 'PENDING' ? 'selected' : '' }}>PENDING</option>
                <option value="PAID" {{ $request->payment_status == 'PAID' ? 'selected' : '' }}>PAID</option>
            </select>
        </div>
    </div>

    @include('partials.flash_message')

    <div class="overflow-x-auto scrollbar-hide bg-white p-4 shadow-sm rounded-lg">
        <table class="min-w-max table-auto border-collapse">
            <thead>
                <tr class="text-left">
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">No.</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">ID Refund</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">Peserta</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">Tiket</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">Bank</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">No. Rekening</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">Atas Nama</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">Status</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">Tanggal Pengajuan</th>
                    <th class="sticky top-0 backdrop-blur-md py-3 px-4 text-sm font-medium tracking-wider border-b border-slate-400">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse ($refunds as $refund)
                    @php
                        $color = $statusColors[strtoupper($refund->payment_status)] ?? 'slate';
                    @endphp
                    <tr class="hover:bg-slate-100 transition-colors">
                        <td class="py-3 px-4 text-sm text-slate-600">
                            {{ ($refunds->currentPage() - 1) * $refunds->perPage() + $loop->iteration }}
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            #{{ $refund->id }}
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            {{ $refund->user->name ?? '-' }}
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            {{ $refund->transaction->ticket->name ?? '-' }}
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            {{ $refund->bank_name }}
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            {{ $refund->bank_number }}
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            {{ $refund->bank_account }}
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            <div class="flex">
                                <div class="p-1 px-4 rounded-full border border-{{ $color }}-500 text-{{ $color }}-500 bg-{{ $color }}-100 text-xs font-medium">
                                    {{ $refund->payment_status }}
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            {{ Carbon::parse($refund->created_at)->isoFormat('DD MMMM Y HH:mm:ss') }}
                        </td>
                        <td class="py-3 px-4 text-sm text-slate-600">
                            @if ($refund->payment_status == "PENDING")
                                <button onclick="ConfirmRefund(event, '{{ base64_encode(json_encode($refund)) }}', '{{ route('admin.refund.confirm', $refund->id) }}')" class="p-1 px-4 border-[0.5px] border-green-500 bg-green-50 hover:bg-green-500 rounded-full text-xs text-green-600 hover:text-white transition-colors">
                                    Konfirmasi Refund
                                </button>
                            @else
                                <button onclick="ConfirmRefund(event, '{{ base64_encode(json_encode($refund)) }}', '')" class="p-1 px-4 border-[0.5px] border-primary bg-primary-transparent rounded-full text-xs text-primary hover:bg-primary hover:text-white transition-colors">
                                    Lihat Bukti
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="py-8 text-center text-sm text-slate-400">
                            Tidak ada data refund ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $refunds->links() }}
</div>
@endsection

@section('ModalArea')
<div class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-30" id="ConfirmRefundModal">
    <form method="POST" class="bg-white shadow-lg rounded-lg p-10 w-4/12 mobile:w-10/12 flex flex-col gap-4 mt-4" enctype="multipart/form-data">
        @csrf
        <div class="flex items-center gap-4 mb-4">
            <h3 class="text-lg text-slate-700 font-medium flex grow" id="ModalTitle">Konfirmasi Refund</h3>
            <ion-icon name="close-outline" class="cursor-pointer text-3xl" onclick="toggleHidden('#ConfirmRefundModal')"></ion-icon>
        </div>

        <div class="flex flex-col gap-4">
            <div class="flex items-center gap-4">
                <div class="text-xs text-slate-500 flex grow basis-64">Peserta</div>
                <div class="text-sm text-slate-600 text-right" id="user_name">USER_NAME</div>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-xs text-slate-500 flex grow basis-64">Bank</div>
                <div class="text-sm text-slate-600 text-right" id="bank_name">BANK_NAME</div>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-xs text-slate-500 flex grow basis-64">No. Rekening</div>
                <div class="text-sm text-slate-600 text-right" id="bank_number">0</div>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-xs text-slate-500 flex grow basis-64">Atas Nama</div>
                <div class="text-sm text-slate-600 text-right" id="bank_account">0</div>
            </div>
            <div class="flex flex-col gap-4" id="EvidenceStatement">
                <div class="text-xs text-slate-500 ">Bukti Transfer Refund</div>
                <img src="#" id="EvidenceImage" alt="Evidence Image" class="w-full aspect-[5/2] object-cover rounded-lg bg-slate-100">
            </div>

            <div class="w-full aspect-[5/2] bg-slate-100 rounded-lg relative flex flex-col gap-2 items-center justify-center mt-2 hidden" id="EvidenceForm">
                <ion-icon name="image-outline" class="text-4xl text-slate-700"></ion-icon>
                <div class="text-xs text-slate-500">Upload Bukti Transfer Refund</div>
                <input type="file" name="evidence" id="evidence" class="absolute top-0 left-0 right-0 bottom-0 opacity-0 cursor-pointer" onchange="onChangeImage(this, '#EvidenceForm')">
            </div>
        </div>

        <div class="flex items-center justify-end gap-4 mt-4">
            <button class="p-3 px-6 rounded-lg text-sm bg-slate-200 text-slate-700" type="button" onclick="toggleHidden('#ConfirmRefundModal')">Batal</button>
            <button class="p-3 px-6 rounded-lg text-sm bg-green-500 text-white font-medium" id="SubmitBtn">Konfirmasi</button>
        </div>
    </form>
</div>
@endsection

@section('javascript')
<script>
    const ConfirmRefund = (event, data, actionUrl) => {
        event.preventDefault();
        data = atob(data);
        console.log(data);
        
        data = JSON.parse(data);
        let evidence = select("#ConfirmRefundModal #evidence");

        select("#ConfirmRefundModal #user_name").innerHTML = data.user ? data.user.name : '-';
        select("#ConfirmRefundModal #bank_name").innerHTML = data.bank_name;
        select("#ConfirmRefundModal #bank_number").innerHTML = data.bank_number;
        select("#ConfirmRefundModal #bank_account").innerHTML = data.bank_account;
        
        if (actionUrl) {
            select("#ConfirmRefundModal form").setAttribute('action', actionUrl);
            select("#ConfirmRefundModal #ModalTitle").innerHTML = "Konfirmasi Refund";
            select("#ConfirmRefundModal #SubmitBtn").classList.remove('hidden');
        } else {
            select("#ConfirmRefundModal form").removeAttribute('action');
            select("#ConfirmRefundModal #ModalTitle").innerHTML = "Detail Refund";
            select("#ConfirmRefundModal #SubmitBtn").classList.add('hidden');
        }

        if (data.payment_payload == null) {
            select("#ConfirmRefundModal #EvidenceForm").classList.remove('hidden');
            select("#ConfirmRefundModal #EvidenceStatement").classList.add('hidden');
            select("#ConfirmRefundModal #evidence").setAttribute('required', 'required');
        } else {
            select("#ConfirmRefundModal #EvidenceStatement").classList.remove('hidden');
            select("#ConfirmRefundModal #EvidenceForm").classList.add('hidden');
            select("#ConfirmRefundModal #evidence").removeAttribute('required');
            select("#ConfirmRefundModal #EvidenceImage").setAttribute('src', `/storage/payment_evidences/${data.payment_payload}`);
        }

        toggleHidden("#ConfirmRefundModal");
    }
</script>
@endsection
