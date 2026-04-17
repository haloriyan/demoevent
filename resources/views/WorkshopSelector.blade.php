<div class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-75 flex items-center justify-center hidden" id="WorkshopPicker">
    <form class="bg-white shadow-lg rounded-lg w-5/12 mobile:w-10/12 flex flex-col gap-0 mt-4 max-h-[90vh]" onsubmit="ConfirmWorkshop(event)">
        @csrf

        <div class="sticky top-0 bg-white rounded-t-lg p-10 pb-4 border-b border-slate-200 z-10 flex items-center gap-4 mb-0">
            <div class="flex flex-col gap-1 grow">
                <h3 class="text-lg text-slate-700 font-medium" id="ModalTitle">Pilih Workshop</h3>
                <div class="text-xs text-slate-500" id="category_name"></div>
            </div>
        </div>

        <div class="overflow-y-auto flex-1 p-10 pt-4">
            <div class="grid grid-cols-2 gap-6" id="WSCategoryRender"></div>
        </div>

        <div class="sticky bottom-0 bg-white rounded-b-lg p-10 pt-4 border-t border-slate-200 flex items-center justify-end gap-4 hidden" id="WSPickerSubmitArea">
            <button type="submit" class="p-3 px-6 rounded-lg text-sm bg-green-500 text-white font-medium">Konfirmasi</button>
        </div>
    </form>
</div>