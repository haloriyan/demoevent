<div class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-30" id="AddCategory">
    <form action="{{ route('admin.handbook.category.store') }}" method="POST" class="bg-white shadow-lg rounded-lg p-10 w-4/12 mobile:w-10/12 flex flex-col gap-4 mt-4">
        @csrf
        <div class="flex items-center gap-4 mb-4">
            <h3 class="text-lg text-slate-700 font-medium flex grow">Kategori Baru</h3>
            <ion-icon name="close-outline" class="cursor-pointer text-3xl" onclick="toggleHidden('#AddCategory')"></ion-icon>
        </div>

        <div>
            <div class="text-xs text-slate-500 mb-2">Kategori</div>
            <input type="text" name="name" id="name" class="w-full h-14 px-4 border rounded-lg text-sm text-slate-600 outline-0" value="{{ old('name') }}" required>
        </div>

        <div class="flex items-center justify-end gap-4 mt-4">
            <button class="p-3 px-6 rounded-lg text-sm bg-slate-200 text-slate-700" type="button" onclick="toggleHidden('#AddCategory')">Batal</button>
            <button class="p-3 px-6 rounded-lg text-sm bg-green-500 text-white font-medium">Tambahkan</button>
        </div>
    </form>
</div>