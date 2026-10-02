<div class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-30" id="ConfirmTicket">
    <form method="GET" class="bg-white shadow-lg rounded-lg p-10 w-4/12 mobile:w-10/12 flex flex-col gap-4 mt-4">
        <div class="flex items-center gap-4 mb-4">
            <h3 class="text-lg text-slate-700 font-medium flex grow">Konfirmasi</h3>
            <ion-icon name="close-outline" class="cursor-pointer text-3xl" onclick="toggleHidden('#ConfirmTicket')"></ion-icon>
        </div>

        <div class="mt-2">
            <div class="text-xs text-slate-500 mb-2">NAMA</div>
            <div class="text-slate-600 font-bold" id="name"></div>
        </div>

        <div>
            <div class="text-xs text-slate-500 mb-2">TIKET</div>
            <div class="text-slate-600 font-bold mb-2" id="ticket_name"></div>
            <div class="flex items-center gap-3" id="WorkshopArea"></div>
        </div>

        <div class="text-xs text-slate-500">Pastikan data di atas sudah benar sebelum mengkonfirmasi</div>

        <div class="flex items-center justify-end gap-4 mt-4">
            <button class="p-3 px-6 rounded-lg text-sm bg-slate-200 text-slate-700" type="button" onclick="toggleHidden('#ConfirmTicket')">Batal</button>
            <button class="p-3 px-6 rounded-lg text-sm bg-green-500 text-white font-medium" type="button" onclick="confirmUser()">Check</button>
        </div>
    </form>
</div>