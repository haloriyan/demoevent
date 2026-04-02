<div class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-30" id="MailContent">
    <form method="GET" class="bg-white shadow-lg rounded-lg p-10 w-4/12 mobile:w-10/12 flex flex-col gap-4 mt-4">
        <div class="flex items-center gap-4 mb-4">
            <div class="w-8 h-8 rounded-full bg-primary text-white text-sm font-medium flex items-center justify-center" id="initial"></div>
            <div class="flex flex-col gap-1 grow">
                <h3 class="text-lg text-slate-700 font-medium flex grow" id="from_name"></h3>
                <div class="text-xs text-slate-500" id="from_email"></div>
            </div>
            <ion-icon name="close-outline" class="cursor-pointer text-3xl" onclick="toggleHidden('#MailContent')"></ion-icon>
        </div>

        <div id="body" class="max-h-[450px] mobile:max-h-[375px] overflow-y-auto"></div>
        {{-- whitespace-pre-wrap break-words  --}}

        <div id="AttachmentsArea" class="flex flex-col gap-2"></div>

        <div class="flex items-center justify-end gap-4 mt-4">
            <button class="p-3 px-6 rounded-lg text-sm bg-slate-200 text-slate-700" type="button" onclick="toggleHidden('#MailContent')">Tutup</button>
        </div>
    </form>
</div>