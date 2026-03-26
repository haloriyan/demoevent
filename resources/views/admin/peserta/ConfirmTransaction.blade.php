<div class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-30" id="ConfirmTrx">
    <form method="POST" class="bg-white shadow-lg rounded-lg p-10 w-4/12 mobile:w-10/12 flex flex-col gap-4 mt-4" enctype="multipart/form-data">
        @csrf
        <div class="flex items-center gap-4 mb-4">
            <h3 class="text-lg text-slate-700 font-medium flex grow">Konfirmasi Pembayaran</h3>
            <ion-icon name="close-outline" class="cursor-pointer text-3xl" onclick="toggleHidden('#ConfirmTrx')"></ion-icon>
        </div>

        <div class="flex flex-col gap-4">
            <div class="flex items-center gap-4">
                <div class="text-xs text-slate-500 flex grow basis-64">Peserta</div>
                <div class="text-sm text-slate-600 text-right" id="user_name">USER_NAME</div>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-xs text-slate-500 flex grow basis-64">Tiket</div>
                <div class="text-sm text-slate-600 text-right" id="ticket_name">TICKET_NAME</div>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-xs text-slate-500 flex grow basis-64">Nominal</div>
                <div class="text-sm text-slate-600 text-right" id="amount">0</div>
            </div>
            <div class="flex flex-col gap-4" id="EvidenceStatement">
                <div class="text-xs text-slate-500 ">Bukti Pembayaran</div>
                {{-- <a href="#" target="_blank" class="text-sm text-right text-primary underline" id="EvidenceLink">Lihat</a> --}}
                <img src="#" id="EvidenceImage" alt="Evidence Image" class="w-full aspect-[5/2] object-cover rounded-lg bg-slate-100">
            </div>

            <div class="w-full aspect-[5/2] bg-slate-100 rounded-lg relative flex flex-col gap-2 items-center justify-center mt-2 hidden" id="EvidenceForm">
                <ion-icon name="image-outline" class="text-4xl text-slate-700"></ion-icon>
                <div class="text-xs text-slate-500">Upload Bukti Pembayaran / Transfer</div>
                <input type="file" name="evidence" id="evidence" class="absolute top-0 left-0 right-0 bottom-0 opacity-0 cursor-pointer" onchange="onChangeImage(this, '#EvidenceForm')">
            </div>
        </div>

        <div class="flex items-center justify-end gap-4 mt-4">
            <button class="p-3 px-6 rounded-lg text-sm bg-slate-200 text-slate-700" type="button" onclick="toggleHidden('#ConfirmTrx')">Batal</button>
            <button class="p-3 px-6 rounded-lg text-sm bg-green-500 text-white font-medium">Konfirmasi</button>
        </div>
    </form>
</div>