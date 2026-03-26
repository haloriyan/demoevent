<div class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-30" id="AddHandbook">
    <form action="{{ route('admin.handbook.store') }}" method="POST" class="bg-white shadow-lg rounded-lg p-10 w-4/12 mobile:w-10/12 flex flex-col gap-4 mt-4" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="category_ids" id="category_ids" value="[]">
        <div class="flex items-center gap-4 mb-4">
            <h3 class="text-lg text-slate-700 font-medium flex grow">Tambah Handbook</h3>
            <ion-icon name="close-outline" class="cursor-pointer text-3xl" onclick="toggleHidden('#AddHandbook')"></ion-icon>
        </div>

        <div>
            <div class="text-xs text-slate-500 mb-2">Judul</div>
            <input type="text" name="title" id="title" class="w-full h-14 px-4 border rounded-lg text-sm text-slate-600 outline-0" value="{{ old('name') }}" required>
        </div>

        <div>
            <div class="text-xs text-slate-500 mb-2">File</div>
            <div class="border rounded-lg p-4">
                <input type="file" name="file" id="file" accept="application/pdf" class="w-full text-sm text-slate-600 outline-0">
            </div>
            <div class="text-xs text-slate-500 text-right mt-2">Format : PDF</div>
        </div>

        <div>
            <div class="text-xs text-slate-500 mb-2">Kategori</div>
            <div class="flex items-center gap-3">
                @foreach ($categories as $cat)
                    <div class="CategoryItem p-2 px-4 rounded-full cursor-pointer text-xs border cursor-pointer text-slate-600" onclick="toggleCategory('#AddHandbook', this, '{{ $cat }}')">
                        {{ $cat->name }}
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex items-center justify-end gap-4 mt-4">
            <button class="p-3 px-6 rounded-lg text-sm bg-slate-200 text-slate-700" type="button" onclick="toggleHidden('#AddHandbook')">Batal</button>
            <button class="p-3 px-6 rounded-lg text-sm bg-green-500 text-white font-medium">Tambahkan</button>
        </div>
    </form>
</div>