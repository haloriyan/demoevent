<div class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-30" id="ScanModal">
    <form action="{{ route('admin.scan') }}" method="POST" class="bg-white shadow-lg rounded-lg p-10 w-4/12 mobile:w-10/12 flex flex-col gap-4 mt-4">
        @csrf
        <div class="flex items-center gap-4 mb-4">
            <h3 class="text-lg text-slate-700 font-medium flex grow">Scan QR</h3>
            <ion-icon name="close-outline" class="cursor-pointer text-3xl" onclick="toggleHidden('#ScanModal')"></ion-icon>
        </div>

        <input type="hidden" name="p" id="p" value="eyJ0cnhfaWQiOjMsInVzZXJfaWQiOjJ9">

        <div class="relative">
            <video id="Scanner" class="w-full aspect-square bg-black/40 rounded-xl"></video>

            <div class="absolute inset-0 pointer-events-none rounded-xl">
                <!-- center frame container -->
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="relative w-6/12 aspect-square z-10">
                        <div class="absolute inset-0 border-2 border-white/60 rounded-md"></div>

                        <div class="absolute -top-1 -left-1 w-10 h-10 border-t-4 border-l-4 border-blue-400 rounded-tl-md"></div>
                        <div class="absolute -top-1 -right-1 w-10 h-10 border-t-4 border-r-4 border-blue-400 rounded-tr-md"></div>
                        <div class="absolute -bottom-1 -left-1 w-10 h-10 border-b-4 border-l-4 border-blue-400 rounded-bl-md"></div>
                        <div class="absolute -bottom-1 -right-1 w-10 h-10 border-b-4 border-r-4 border-blue-400 rounded-br-md"></div>
                    </div>
                </div>

                <!-- overlay panels -->
                <!-- top -->
                <div class="absolute left-0 right-0 top-0" style="height: 25%; background: rgba(0,0,0,0.70);"></div>
                <!-- bottom -->
                <div class="absolute left-0 right-0 bottom-0" style="height: 25%; background: rgba(0,0,0,0.70);"></div>
                <!-- left (between top & bottom) -->
                <div class="absolute" style="top:25%; bottom:25%; left:0; width:25%; background: rgba(0,0,0,0.70);"></div>
                <!-- right -->
                <div class="absolute" style="top:25%; bottom:25%; right:0; width:25%; background: rgba(0,0,0,0.70);"></div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-4 mt-4">
            <button class="p-3 px-6 rounded-lg text-sm bg-slate-200 text-slate-700" type="button" onclick="toggleHidden('#ScanModal')">Batal</button>
            <button class="p-3 px-6 rounded-lg text-sm bg-red-500 text-white font-medium">Hapus</button>
        </div>
    </form>
</div>