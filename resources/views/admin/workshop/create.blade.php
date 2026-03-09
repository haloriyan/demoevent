<div class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-30" id="CreateWorkshop">
    <form action="{{ route('admin.workshop.store') }}" method="POST" class="bg-white shadow-lg rounded-lg p-10 w-4/12 mobile:w-10/12 flex flex-col gap-4 mt-4">
        @csrf
        <input type="hidden" name="category_id" id="category_id">
        <div class="flex items-center gap-4 mb-4">
            <h3 class="text-lg text-slate-700 font-medium flex grow gap-2">Tambah ke <span id="CategoryName"></span></h3>
            <ion-icon name="close-outline" class="cursor-pointer text-3xl" onclick="toggleHidden('#CreateWorkshop')"></ion-icon>
        </div>

        <div class="text-xs text-slate-500 mt-2">Judul :</div>
        <input type="text" name="title" id="title" class="w-full h-12 -mt-2 border rounded-lg px-4 text-sm text-slate-600 outline-none" required>
        <div class="text-xs text-slate-500 mt-2">Kapasitas (peserta) :</div>
        <input type="number" name="quantity" id="quantity" class="w-full h-12 -mt-2 border rounded-lg px-4 text-sm text-slate-600 outline-none" min="1" required>

        <div class="flex items-center justify-end gap-4 mt-4">
            <button class="p-3 px-6 rounded-lg text-sm bg-slate-200 text-slate-700" type="button" onclick="toggleHidden('#CreateWorkshop')">Batal</button>
            <button class="p-3 px-6 rounded-lg text-sm bg-green-500 text-white font-medium">Tambahkan</button>
        </div>
    </form>
</div>