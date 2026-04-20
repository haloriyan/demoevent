<div class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-30" id="CreateWorkshop">
    <form action="{{ route('admin.workshop.store') }}" method="POST" class="bg-white shadow-lg rounded-lg p-10 w-4/12 mobile:w-10/12 flex flex-col gap-4 mt-4">
        @csrf
        <input type="hidden" name="category_id" id="category_id">
        <input type="hidden" name="ticket_category_id" id="ticket_category_id" value="{{ $request->ticket_category }}">
        <input type="hidden" name="start_time" id="start_time">
        <input type="hidden" name="end_time" id="end_time">

        <div class="flex items-center gap-4 mb-4">
            <h3 class="text-lg text-slate-700 font-medium flex grow gap-2">Tambah ke <span id="CategoryName"></span></h3>
            <ion-icon name="close-outline" class="cursor-pointer text-3xl" onclick="toggleHidden('#CreateWorkshop')"></ion-icon>
        </div>

        <div class="text-xs text-slate-500 mt-2">Judul :</div>
        <input type="text" name="title" id="title" class="w-full h-12 -mt-2 border rounded-lg px-4 text-sm text-slate-600 outline-none" required>
        <div class="text-xs text-slate-500 mt-2">Kapasitas (peserta) :</div>
        <input type="number" name="quantity" id="quantity" class="w-full h-12 -mt-2 border rounded-lg px-4 text-sm text-slate-600 outline-none" min="1" required>

        <div class="grid grid-cols-2 gap-10 mt-2">
            <div class="flex flex-col gap-1">
                <div class="text-xs text-slate-500 mt">Waktu Mulai :</div>
                <input type="text" name="start_time" id="start_time_picker" class="w-full h-12 border rounded-lg px-4 text-sm text-slate-600 outline-none" required>
            </div>
            <div class="flex flex-col gap-1">
                <div class="text-xs text-slate-500 mt">Berakhir :</div>
                <input type="text" name="end_time" id="end_time_picker" class="w-full h-12 border rounded-lg px-4 text-sm text-slate-600 outline-none" required>
            </div>
        </div>

        <div class="text-xs text-slate-500 mt-2">Speakers :</div>
        <input type="text" name="speakers" id="speakers" class="w-full h-12 -mt-2 border rounded-lg px-4 text-sm text-slate-600 outline-none" required>
        <div class="text-[11px] text-slate-500 -mt-2">Pisahkan dengan koma ","</div>


        <div class="flex items-center justify-end gap-4 mt-4">
            <button class="p-3 px-6 rounded-lg text-sm bg-slate-200 text-slate-700" type="button" onclick="toggleHidden('#CreateWorkshop')">Batal</button>
            <button class="p-3 px-6 rounded-lg text-sm bg-green-500 text-white font-medium">Tambahkan</button>
        </div>
    </form>
</div>