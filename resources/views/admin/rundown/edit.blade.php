@php
    use Carbon\Carbon;
@endphp

<div class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-30" id="EditRundown">
    <form action="{{ route('admin.rundown.store') }}" method="POST" class="bg-white shadow-lg rounded-lg p-10 w-4/12 mobile:w-10/12 flex flex-col gap-4 mt-4">
        @csrf
        <input type="hidden" name="start_time" id="start_time">
        <input type="hidden" name="end_time" id="end_time">

        <div class="flex items-center gap-4 mb-4">
            <h3 class="text-lg text-slate-700 font-medium flex grow">Edit Rundown</h3>
            <ion-icon name="close-outline" class="cursor-pointer text-3xl" onclick="toggleHidden('#EditRundown')"></ion-icon>
        </div>

        <div class="group border focus-within:border-primary rounded-lg p-2 relative">
            <label class="text-slate-500 group-focus-within:text-primary text-xs absolute top-2 left-2">Judul</label>
            <input type="text" name="title" id="title" class="w-full h-10 mt-3 outline-none bg-transparent text-sm text-slate-700" value="{{ old('title') }}" required />
        </div>
        <div class="group border focus-within:border-primary rounded-lg p-2 relative">
            <label class="text-slate-500 group-focus-within:text-primary text-xs absolute top-2 left-2">Deskripsi</label>
            <textarea name="description" id="description" class="w-full h-20 pt-6 outline-none bg-transparent text-sm text-slate-700" rows="10">{{ old('description') }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div class="flex flex-col border rounded-lg p-2">
                <div class="text-xs text-slate-500">Mulai</div>
                <div class="flex items-center">
                    <input type="text" id="start_time_picker" class="h-8 outline-0 text-xs text-slate-600 w-full">
                    <ion-icon name="chevron-down-outline"></ion-icon>
                </div>
            </div>
            <div class="flex flex-col border rounded-lg p-2">
                <div class="text-xs text-slate-500">Berakhir</div>
                <div class="flex items-center">
                    <input type="text" id="end_time_picker" class="h-8 outline-0 text-xs text-slate-600 w-full">
                    <ion-icon name="chevron-down-outline"></ion-icon>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-4 mt-4">
            <button class="p-3 px-6 rounded-lg text-sm bg-slate-200 text-slate-700" type="button" onclick="toggleHidden('#EditRundown')">Batal</button>
            <button class="p-3 px-6 rounded-lg text-sm bg-green-500 text-white font-medium">Simpan</button>
        </div>
    </form>
</div>