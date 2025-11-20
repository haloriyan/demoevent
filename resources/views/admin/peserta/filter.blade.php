@php
    $statuses = [
        'PENDING', 'CANCELLED', 'EXPIRED', 'PAID'
    ];
@endphp
<div class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-30" id="FilterPeserta">
    <form method="GET" class="bg-white shadow-lg rounded-lg p-10 w-5/12 mobile:w-10/12 flex flex-col gap-4 mt-4">
        <div class="flex items-center gap-4 mb-4">
            <h3 class="text-lg text-slate-700 font-medium flex grow">Filter</h3>
            <ion-icon name="close-outline" class="cursor-pointer text-3xl" onclick="toggleHidden('#FilterPeserta')"></ion-icon>
        </div>

        <div class="flex items-center gap-4">
            <div class="text-xs text-slate-500 flex grow basis-32">Tiket</div>
            <select name="ticket_id" id="ticket_id" class="border rounded-lg h-12 px-4 text-sm text-slate-700 font-medium cursor-pointer">
                <option value="">Semua</option>
                @foreach ($tickets as $tick)
                    <option value="{{ $tick->id }}" {{ $request->ticket_id == $tick->id ? "selected='selected'" : "" }}>{{ $tick->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-center gap-4">
            <div class="text-xs text-slate-500 flex grow basis-32">Status Pembayaran</div>
            <select name="payment_status" id="payment_status" class="border rounded-lg h-12 px-4 text-sm text-slate-700 font-medium cursor-pointer">
                <option value="">Semua</option>
                @foreach ($statuses as $stat)
                    <option value="{{ $stat }}" {{ $request->payment_status == $stat ? "selected='selected'" : "" }}>{{ $stat }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex items-center justify-end gap-4 mt-4">
            <a href="?" class="p-3 px-6 rounded-lg text-sm text-red-500 flex items-center gap-3">
                <ion-icon name="close-outline" class="text-xl"></ion-icon>
                Bersihkan Filter
            </a>
            <div class="flex grow"></div>
            <button class="p-3 px-6 rounded-lg text-sm bg-slate-200 text-slate-700" type="button" onclick="toggleHidden('#FilterPeserta')">Batal</button>
            <button class="p-3 px-6 rounded-lg text-sm bg-green-500 text-white font-medium">Terapkan</button>
        </div>
    </form>
</div>