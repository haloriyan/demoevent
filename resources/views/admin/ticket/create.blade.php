<div class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-30" id="AddTicket">
    <form action="{{ route('admin.ticket.store') }}" method="POST" class="bg-white shadow-lg rounded-lg p-10 w-4/12 mobile:w-10/12 flex flex-col gap-4 mt-4">
        @csrf
        <input type="hidden" name="category_id" id="category_id">
        <input type="hidden" name="price" id="price">

        <div class="flex items-center gap-4 mb-4">
            <div class="flex flex-col gap-1 grow">
                <h3 class="text-lg text-slate-700 font-medium">Buat Tiket</h3>
                <div class="text-xs text-slate-500" id="category_name"></div>
            </div>
            <ion-icon name="close-outline" class="cursor-pointer text-3xl" onclick="toggleHidden('#AddTicket')"></ion-icon>
        </div>

        <div>
            <div class="text-xs text-slate-500 mb-2">Nama</div>
            <input type="text" name="name" id="name" class="w-full h-14 px-4 border rounded-lg text-sm text-slate-600 outline-0" value="{{ old('name') }}" placeholder="Nama tiket / acara / workshop" required>
        </div>
        <div>
            <div class="text-xs text-slate-500 mb-2">Harga</div>
            <input type="text" name="price_type" id="price_type" class="w-full h-14 px-4 border rounded-lg text-sm text-slate-600 outline-0" value="{{ old('price_type') }}" oninput="TypePrice(this, '#AddTicket #price')" required>
        </div>

        <div>
            <div class="text-xs text-slate-500 mb-2">Tanggal Acara</div>
            <input type="text" name="date" id="date" class="w-full h-14 px-4 border rounded-lg text-sm text-slate-600 outline-0" value="{{ old('date') }}" placeholder="Untuk Validasi Scan QR" required>
        </div>

        <div>
            <div class="text-xs text-slate-500 mb-2">Jumlah Tiket Tersedia</div>
            <input type="number" name="quantity" id="quantity" class="w-full h-14 px-4 border rounded-lg text-sm text-slate-600 outline-0" value="{{ old('date') }}" min="1" required>
        </div>

        <div class="flex items-center justify-end gap-4 mt-4">
            <button class="p-3 px-6 rounded-lg text-sm bg-slate-200 text-slate-700" type="button" onclick="toggleHidden('#AddTicket')">Batal</button>
            <button class="p-3 px-6 rounded-lg text-sm bg-green-500 text-white font-medium">Tambahkan</button>
        </div>
    </form>
</div>