<div class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-30" id="ManageSpeaker">
    <div class="bg-white shadow-lg rounded-lg p-10 w-7/12 mobile:w-10/12 flex flex-col gap-4 mt-4">
        <div class="flex items-center gap-4 mb-4">
            <h3 class="text-lg text-slate-700 font-medium flex grow">Atur Speaker</h3>
            <ion-icon name="close-outline" class="cursor-pointer text-3xl" onclick="toggleHidden('#ManageSpeaker')"></ion-icon>
        </div>

        <div class="grid grid-cols-2 gap-8">
            <form action="#" method="POST" class="flex flex-col gap-4" id="AddSpeaker">
                @csrf
                <div id="SpeakerSelector"></div>

                <div class="flex items-center justify-end gap-4 mt-4">
                    <button class="p-3 px-6 rounded-lg text-sm bg-slate-200 text-slate-700" type="button" onclick="toggleHidden('#ManageSpeaker')">Batal</button>
                    <button class="p-3 px-6 rounded-lg text-sm bg-green-500 text-white font-medium">Tambahkan</button>
                </div>
            </form>
            <div class="flex flex-col gap-4">
                <div class="text-xs text-slate-500">List Speakers</div>
                <div class="flex flex-col gap-2" id="RenderSpeakerList"></div>
            </div>
        </div>
    </div>
</div>