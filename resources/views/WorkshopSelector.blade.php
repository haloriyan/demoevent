<div class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-75 flex items-center justify-center hidden" id="WorkshopPicker">
    <form class="bg-white shadow-lg rounded-lg p-10 w-5/12 mobile:w-10/12 flex flex-col gap-4 mt-4" onsubmit="ConfirmWorkshop(event)">
        @csrf

        <div class="flex items-center gap-4 mb-4">
            <div class="flex flex-col gap-1 grow">
                <h3 class="text-lg text-slate-700 font-medium" id="ModalTitle">Pilih Workshop</h3>
                <div class="text-xs text-slate-500" id="category_name"></div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6">
            @foreach ($workshops as $cat)
                <div 
                    class="flex flex-col gap-4" 
                    data-category="{{ $cat->id }}"
                    data-category-name="{{ $cat->name }}"
                >
                    
                    <div class="p-3 px-4 bg-primary text-white text-sm font-medium">
                        {{ $cat->name }}
                    </div>

                    @foreach ($cat->workshops as $ws)
                        <div 
                            class="workshop-item cursor-pointer border rounded-lg p-3 px-4 text-sm"
                            data-id="{{ $ws->id }}"
                            data-title="{{ $ws->title }}"
                            onclick="ChooseWorkshop(event)"
                        >
                            {{ $ws->title }}
                        </div>
                    @endforeach

                </div>
            @endforeach
        </div>

        <div class="flex items-center justify-end gap-4 mt-4 hidden" id="WSPickerSubmitArea">
            <button class="p-3 px-6 rounded-lg text-sm bg-green-500 text-white font-medium">Konfirmasi</button>
        </div>
    </form>
</div>