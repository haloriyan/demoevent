<div class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-30" id="ScanCheck">
    <form action="{{ route('booth.scan.checkin') }}" method="POST" class="bg-white shadow-lg rounded-lg p-10 w-4/12 mobile:w-10/12 flex flex-col gap-4 mt-4">
        @csrf
        <input type="hidden" name="user_id" id="user_id">
        <div class="flex items-center gap-4 mb-4">
            <h3 class="text-lg text-slate-700 font-medium flex grow"></h3>
            <ion-icon name="close-outline" class="cursor-pointer text-3xl" onclick="toggleHidden('#ScanCheck')"></ion-icon>
        </div>

        <div id="LoadingContainer" class="flex justify-center my-8 hidden">
            <span class="loader"></span>
        </div>

        <div id="Error" class="flex flex-col gap-4 hidden Response">
            <div class="bg-red-500 text-white text-sm p-4 rounded-lg">
                Ada masalah saat proses scanning
            </div>

            <button type="button" class="w-full h-12 bg-slate-200 text-slate-600 text-sm font-bold mt-3 rounded-lg" onclick="toggleHidden('#ScanCheck')">
                Tutup
            </button>
        </div>
        <div id="Result" class="flex flex-col gap-4 hidden Response">
            <div class="flex justify-center">
                <div class="w-6/12 aspect-square rounded-full bg-slate-200 text-3xl font-medium text-primary flex items-center justify-center" id="initial">
                    RS
                </div>
            </div>

            <div>
                <div class="text-lg text-slate-700 text-center font-medium" id="name">Riyan Satria</div>
                <div class="text-slate-500 text-sm text-center mt-1" id="instansi">Agendakota</div>
            </div>

            <button class="w-full h-12 bg-green-500 text-white text-sm font-bold mt-3 rounded-lg">
                Cek-in
            </button>
        </div>
    </form>
</div>