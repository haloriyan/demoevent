@extends('layouts.register')

@section('title', "Pendaftaran")
    
@section('content')

<form action="{{ route('register', ['step' => "welcome"]) }}" class="SlideItem flex flex-col grow gap-8" method="POST">
    @csrf
    <input type="hidden" name="p" id="payload" value="{{ $request->p }}">
    <input type="hidden" name="ticket_id" id="ticket_id">
    <input type="hidden" name="workshops" id="workshops">
    <div class="flex flex-col gap-1">
        <h2 class="text-xl text-slate-700 font-medium">Paket Registrasi</h2>
        <div class="text-sm text-slate-600">
            Pilih paket registrasi yang ingin Anda ikuti.
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
<script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
<script>
    let maxWorkshops = 2;
    let WSCategories = @json($workshops);

    function like(needle, haystack, reversed = false) {
        return reversed
            ? needle.includes(haystack)
            : haystack.includes(needle);
    }

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
    const ChooseTicket = (data, btn = null) => {
        data = JSON.parse(data);
        
        if (btn == null) {
            btn = select(`#Ticket_${data.id}`);
        }
        
        selectAll(".TicketItem").forEach(item => {
            item.classList.remove('border-primary');
        });
        selectAll(".RadioInner").forEach(item => item.classList.remove('bg-primary'));
        let jumlahWS = getAngka(data.name);
        btn.classList.add('border-primary');
        select(`#Ticket_${data.id} .RadioInner`).classList.add('bg-primary', 'text-white');
        select("#PriceArea").innerHTML = Currency(data.price).encode();
        select("#ticket_id").value = data.id;

        select("#Bottom").classList.remove('hidden');

        selectAll(".workshop-item").forEach(item => item.classList.remove('bg-primary', 'text-white', 'border-primary'));

        let parentCategory = data.category.name;
        
        if (jumlahWS !== null) {
            let ticketCategoryID = data.category_id;
            
            maxWorkshops = jumlahWS;
            selectedWorkshops = {};
            
            WSCategories = WSCategories.map(cat => ({
                ...cat,
                workshops: cat.workshops.filter(ws => {
                    if (ws.ticket_category_id !== ticketCategoryID) {
                        // console.log(ws.title, " eliminated due to ", ws.ticket_category_id);
                        return false;
                    }
                    return true;
                })
            }));
            
            select("#WSCategoryRender").innerHTML = "";
            WSCategories.map((cat, c) => {
                let WSCat = document.createElement('DIV');
                WSCat.classList.add('flex', 'flex-col', 'gap-4');
                WSCat.setAttribute('data-category', cat.id);
                WSCat.setAttribute('data-category-name', cat.name);
                WSCat.innerHTML = `<div class="p-3 px-4 bg-primary text-white text-sm font-medium">
                    ${cat.name}
                </div>
                <div id="WorkshopItemArea_${cat.id}" class='flex flex-col gap-4'></div>`;
                select("#WSCategoryRender").appendChild(WSCat);

                cat.workshops.map((ws, w) => {
                    let WSItem = document.createElement('DIV');
                    WSItem.classList.add('workshop-item', 'cursor-pointer', 'border', 'rounded-lg', 'p-3', 'px-4', 'text-sm', 'flex', 'items-center', 'gap-3');
                    WSItem.setAttribute('data-id', ws.id);
                    WSItem.setAttribute('data-title', ws.title);
                    WSItem.addEventListener('click', function (e) {
                        ChooseWorkshop(e);
                    });
                    // WSItem.innerHTML = ws.title;
                    let speakersContent = "<div class='flex items-center gap-4 text-xs'>";
                    ws.rundown?.speakers?.map((speaker, s) => {
                        speakersContent += `<div class='flex items-center gap-2'>
                            <div class="w-1 h-1 rounded-full bg-primary"></div>
                            ${speaker.name}
                        </div>`;
                    })
                    speakersContent += "</div>";

                    WSItem.innerHTML = `<div class='flex flex-col gap-1 basis-24 grow'>
                        <div class='text-sm font-medium'>${ws.title}</div>
                        ${speakersContent}
                    </div>
                    <div class='text-xs'>${ws.rundown?.start_time.split(':').slice(0, 2).join(':') ?? '-'}</div>`

                    select(`#WorkshopItemArea_${cat.id}`).appendChild(WSItem);
                })
            })

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
        const categoryWrapper = element.closest('[data-category]')

        if (!categoryWrapper) {
            console.error('Workshop category wrapper not found')
            return
        }

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
        console.log(selectedWorkshops);
        
        
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

    const payload = JSON.parse(atob(select("#payload").value));

    if (payload.ticket) {
        ChooseTicket(JSON.stringify(payload.ticket));
        console.log(payload.workshops);
        selectedWorkshops = payload.workshops;
        payload.workshops.forEach(work => {
            select(`.workshop-item[data-id='${work.id}']`).click();
        });
        // select("#WorkshopPicker form").submit();
        select("#WorkshopPicker button[type='submit']").click();
    }
    
</script>
@endsection