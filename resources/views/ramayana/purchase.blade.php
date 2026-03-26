<div class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-30" id="TicketModal">
    <form action="{{ route('ramayana.purchase') }}" method="POST" class="bg-white shadow-lg rounded-lg p-10 w-4/12 mobile:w-10/12 flex flex-col gap-4 mt-4">
        @csrf
        <div class="flex items-center gap-4 mb-4">
            <div class="flex flex-col gap-1 grow">
                <div class="text-xs text-slate-500">Beli Tiket</div>
                <h3 class="text-lg text-slate-700 font-medium">Nonton Bareng Ramayana</h3>
            </div>
            <ion-icon name="close-outline" class="cursor-pointer text-3xl" onclick="toggleHidden('#TicketModal')"></ion-icon>
        </div>

        <div class="group border focus-within:border-primary rounded-lg p-1 relative">
            <label class="text-slate-500 group-focus-within:text-primary text-xs absolute top-2 left-2">Nama</label>
            <input type="text" name="name" id="name" class="w-full h-12 px-1 mt-3 outline-none bg-transparent text-sm text-slate-700" required />
        </div>
        <div class="group border focus-within:border-primary rounded-lg p-1 relative">
            <label class="text-slate-500 group-focus-within:text-primary text-xs absolute top-2 left-2">Email</label>
            <input type="email" name="email" id="email" class="w-full h-12 px-1 mt-3 outline-none bg-transparent text-sm text-slate-700" required />
        </div>
        <div class="group border focus-within:border-primary rounded-lg p-1 relative flex items-center gap-4">
            <label class="text-slate-500 group-focus-within:text-primary text-xs absolute top-2 left-2">Jumlah Tiket</label>
            <input type="number" name="qty" id="qty" class="flex grow h-12 px-1 mt-3 outline-none bg-transparent text-sm text-slate-700" min="1" max="5" value="1" required />

            <div class="w-10 h-10 rounded-lg flex items-center justify-center cursor-pointer bg-primary bg-opacity-20 text-primary" onclick="qty(null, 'decrease')">
                <ion-icon name="remove-outline" class="text-lg"></ion-icon>
            </div>
            <div class="w-10 h-10 rounded-lg flex items-center justify-center cursor-pointer bg-primary bg-opacity-20 text-primary" onclick="qty(null, 'increase')">
                <ion-icon name="add-outline" class="text-lg"></ion-icon>
            </div>
        </div>

        <div class="flex items-center gap-4 mt-2">
            <div class="text-xs text-slate-500 flex grow">Total Pembayaran :</div>
            <div class="mobile:text-sm text-primary font-bold" id="TotalPrice">{{ currency_encode(env('RAMAYANA_PRICE')) }}</div>
        </div>

        <button class="w-full h-12 rounded-full bg-primary text-white text-sm font-medium mt-2">
            Beli Sekarang
        </button>
    </form>
</div>