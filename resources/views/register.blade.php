@extends('layouts.register')

@section('title', "Pendaftaran")
    
@section('content')

<form action="{{ route('register', ['step' => "welcome"]) }}" class="SlideItem flex flex-col grow gap-8" method="POST">
    @csrf
    <input type="hidden" name="p" value="{{ $request->p }}">
    <input type="hidden" name="ticket_id" id="ticket_id">
    <input type="hidden" name="workshops" id="workshops">
    <div class="flex flex-col gap-1">
        <h2 class="text-xl text-slate-700 font-medium">Paket Registrasi</h2>
        <div class="text-sm text-slate-600">
            Pilih paket pendaftaran yang ingin Anda ikuti.
        </div>
    </div>

    <div class="flex flex-col grow gap-8">
        @foreach ($categories as $category)
            <div class="flex flex-col gap-4">
                <h3 class="text-lg text-slate-500">{{ $category->name }}</h3>
                <div class="flex flex-col gap-2">
                    @foreach ($category->tickets as $ticket)
                        <div class="flex items-center gap-4 border rounded-lg p-4 cursor-pointer TicketItem" id="Ticket_{{ $ticket->id }}" onclick="ChooseTicket('{{ $ticket }}', this)">
                            <div class="w-6 h-6 rounded bg-slate-200 flex items-center justify-center">
                                <div class="w-4 h-4 rounded RadioInner"></div>
                            </div>
                            <div class="text-slate-700 flex grow">{{ $ticket->name }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <div class="flex items-center gap-4 hidden" id="Bottom">
        <div class="flex flex-col gap-1 basis-24 grow">
            <div class="text-xs text-slate-500">Total Pembayaran :</div>
            <div class="text-lg text-primary font-medium" id="PriceArea">{{ currency_encode(0) }}</div>
        </div>
        <button class="p-3 px-5 rounded-lg bg-primary text-white text-sm font-medium">
            Lanjut
        </button>
    </div>
</form>

@endsection

@section('ModalArea')

@include('WorkshopSelector')

@endsection

@section('javascript')
<script>
    let maxWorkshops = 2;

    const getAngka = text => {
        let texts = text.split(' ');
        let toReturn = null;
        
        texts.forEach((txt, t) => {
            if (!isNaN(txt)) {
                toReturn = txt;
            }
        });

        return toReturn !== null ? parseInt(toReturn) : null;
    }
    const ChooseTicket = (data, btn) => {
        data = JSON.parse(data);
        selectAll(".TicketItem").forEach(item => {
            item.classList.remove('border-primary');
        });
        selectAll(".RadioInner").forEach(item => item.classList.remove('bg-primary'));
        let jumlahWS = getAngka(data.name);
        btn.classList.add('border-primary');
        select(`#Ticket_${data.id} .RadioInner`).classList.add('bg-primary');
        select("#PriceArea").innerHTML = Currency(data.price).encode();
        select("#ticket_id").value = data.id;

        select("#Bottom").classList.remove('hidden');

        if (jumlahWS !== null) {
            maxWorkshops = jumlahWS;
            selectedWorkshops = {};
            selectAll(".workshop-item").forEach(item => item.classList.remove('border-primary'));
            select("#WSPickerSubmitArea")?.classList.add('hidden');
            select("#WorkshopPicker #ModalTitle").innerHTML = `Pilih ${jumlahWS} Workshop`;
            toggleHidden('#WorkshopPicker');
        } else {
            select("#Bottom").scrollIntoView({
                behavior: "smooth"
            });
        }
    }

    let selectedWorkshops = {}

    function ChooseWorkshop(event) {

        const element = event.currentTarget
        const categoryWrapper = element.parentNode

        const categoryId = categoryWrapper.dataset.category
        const categoryName = categoryWrapper.dataset.categoryName

        const workshopId = element.dataset.id
        const workshopTitle = element.dataset.title

        const isSelected = element.classList.contains("border-primary")

        // Unselect
        if (isSelected) {
            element.classList.remove("border-primary", "bg-primary", "text-white")
            delete selectedWorkshops[categoryId]
            printOutput?.()
            return
        }

        // Max limit
        const totalSelected = Object.keys(selectedWorkshops).length
        const isReplacingSameCategory = !!selectedWorkshops[categoryId]

        if (totalSelected >= maxWorkshops && !isReplacingSameCategory) {

            const previousCategoryId = Object.keys(selectedWorkshops)[0]

            const previousSelectedElement = document.querySelector(
                `[data-category="${previousCategoryId}"] .border-primary`
            )

            if (previousSelectedElement) {
                previousSelectedElement.classList.remove("border-primary", "bg-primary", "text-white")
            }

            delete selectedWorkshops[previousCategoryId]
        }

        // Replace selection in same category
        if (selectedWorkshops[categoryId]) {
            const previous = categoryWrapper.querySelector(".border-primary")
            if (previous) {
                previous.classList.remove("border-primary", "bg-primary", "text-white")
            }
        }

        // Select current
        element.classList.add("border-primary", "bg-primary", "text-white")

        selectedWorkshops[categoryId] = {
            id: workshopId,
            title: workshopTitle,
            category: {
                id: categoryId,
                name: categoryName
            }
        }
        
        if (Object.keys(selectedWorkshops).length === maxWorkshops) {
            select("#WSPickerSubmitArea")?.classList.remove('hidden');
        }
    }


    const ConfirmWorkshop = (e) => {
        e.preventDefault();
        let output = Object.values(selectedWorkshops)
        output = JSON.stringify(output, null, 2);
        output = JSON.parse(output);
        output = JSON.stringify(output);
        select("input#workshops").value = output;
        toggleHidden("#WorkshopPicker");
    }
</script>
@endsection