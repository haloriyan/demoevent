<div class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-30" id="EditBooth">
    <form action="{{ route('admin.booth.store') }}" method="POST" class="bg-white shadow-lg rounded-lg p-10 w-8/12 mobile:w-10/12 flex flex-col gap-4 mt-4" enctype="multipart/form-data">
        @csrf
        <div class="flex items-center gap-4 mb-4">
            <h3 class="text-lg text-slate-700 font-medium flex grow">Edit Booth</h3>
            <ion-icon name="close-outline" class="cursor-pointer text-3xl" onclick="toggleHidden('#EditBooth')"></ion-icon>
        </div>

        <div class="grid grid-cols-2 mobile:grid-cols-1 gap-8 mt-2">
            <div class="flex flex-col gap-4">

                <div class="flex justify-center">
                    <div class="w-32 h-32 bg-slate-200 rounded-full relative flex flex-col gap-1 items-center justify-center" id="IconArea">
                        <ion-icon name="image-outline" class="text-4xl text-slate-700"></ion-icon>
                        <input type="file" name="icon" id="icon" class="absolute top-0 left-0 right-0 bottom-0 opacity-0 cursor-pointer" onchange="onChangeImage(this, '#EditBooth #IconArea')">
                    </div>
                </div>
                <div class="text-slate-500 text-xs text-center">Klik gambar untuk mengganti</div>

                <div>
                    <div class="text-xs text-slate-500 mb-2">Nama Booth</div>
                    <input type="text" name="name" id="name" class="w-full h-14 px-4 border rounded-lg text-sm text-slate-600 outline-0" value="{{ old('name') }}" required>
                </div>
                <div>
                    <div class="text-xs text-slate-500 mb-2">Deskripsi</div>
                    <textarea type="text" name="description" id="description" class="w-full h-24 p-4 border rounded-lg text-sm text-slate-600 outline-0" required>{{ old('description') }}</textarea>
                </div>
            </div>
            <div class="flex flex-col gap-4">
                <div class="flex flex-col gap-1">
                    <h4 class="text-lg text-slate-700">Detail login.</h4>
                    <div class="text-xs text-slate-500">
                        Digunakan untuk login ke dashboard khusus mereka.
                    </div>
                </div>
                <div></div>
                <div>
                    <div class="text-xs text-slate-500 mb-2">Username</div>
                    <input type="text" name="username" id="username" class="w-full h-14 px-4 border rounded-lg text-sm text-slate-600 outline-0" value="{{ old('email') }}" required>
                </div>
                <div>
                    <div class="text-xs text-slate-500 mb-2">Ganti Password</div>
                    <input type="password" name="password" id="password" class="w-full h-14 px-4 border rounded-lg text-sm text-slate-600 outline-0" value="{{ old('password') }}">
                    <div class="text-xs text-slate-400 mt-1 text-right">
                        Biarkan kosong jika tidak ingin mengganti password
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-4 mt-4">
            <button class="p-3 px-6 rounded-lg text-sm bg-slate-200 text-slate-700" type="button" onclick="toggleHidden('#EditBooth')">Batal</button>
            <button class="p-3 px-6 rounded-lg text-sm bg-green-500 text-white font-medium">Simpan</button>
        </div>
    </form>
</div>