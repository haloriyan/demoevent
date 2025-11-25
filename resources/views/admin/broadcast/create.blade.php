<div class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-30" id="CreateBroadcast">
    <form action="{{ route('admin.broadcast.store') }}" method="POST" class="bg-white shadow-lg rounded-lg p-10 w-4/12 mobile:w-10/12 flex flex-col gap-4 mt-4" enctype="multipart/form-data">
        @csrf
        <div class="flex items-center gap-4 mb-4">
            <h3 class="text-lg text-slate-700 font-medium flex grow">Buat Siaran Baru</h3>
            <ion-icon name="close-outline" class="cursor-pointer text-3xl" onclick="toggleHidden('#CreateBroadcast')"></ion-icon>
        </div>

        <div class="group border focus-within:border-primary rounded-lg p-2 relative flex flex-col grow">
            <label class="text-slate-500 group-focus-within:text-primary text-xs absolute top-2 left-2">Perangkat WhatsApp :</label>
            <select name="device_id" id="device_id" class="h-12 mt-3 cursor-pointer outline-0 text-sm text-slate-600">
                <option value="">Pilih Perangkat WhatsApp...</option>
                @foreach ($devices as $dev)
                    <option value="{{ $dev->id }}">{{ $dev->name }} - {{ $dev->number }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <div class="text-xs text-slate-500 mb-2">Judul Siaran</div>
            <input type="text" name="title" id="title" class="w-full h-14 px-4 border rounded-lg text-sm text-slate-600 outline-0" value="{{ old('name') }}" required>
        </div>

        <div class="group border focus-within:border-primary rounded-lg p-2 relative flex flex-col grow">
            <label class="text-slate-500 group-focus-within:text-primary text-xs absolute top-2 left-2">Pesan :</label>
            <textarea name="content" id="content" class="w-full outline-0 text-sm text-slate-600 h-24 py-2 mt-4"></textarea>
        </div>

        <div class="flex items-center justify-end gap-4 mt-4">
            <button class="p-3 px-6 rounded-lg text-sm bg-slate-200 text-slate-700" type="button" onclick="toggleHidden('#CreateBroadcast')">Batal</button>
            <button class="p-3 px-6 rounded-lg text-sm bg-green-500 text-white font-medium">Buat</button>
        </div>
    </form>
</div>