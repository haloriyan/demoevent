@extends('layouts.admin')

@section('title', "Workshops")
    
@section('content')
<div class="p-10 flex flex-col gap-8">
    @include('partials.flash_message')
    <div class="flex items-center gap-4">
        <div class="text-sm text-slate-700">Jenis Tiket</div>
        <a href="{{ route('admin.workshop') }}" class="p-2 px-5 rounded-full text-sm {{ $request->ticket_category == '' ? 'bg-primary text-white' : 'text-primary bg-primary bg-opacity-25' }}">
            Semua
        </a>
        @foreach ($ticketCategories as $cat)
            @php
                $isSelected = $request->ticket_category == $cat->id;
            @endphp
            <a href="?ticket_category={{ $cat->id }}" class="p-2 px-5 rounded-full text-sm {{ $isSelected ? 'bg-primary text-white' : 'text-primary bg-primary bg-opacity-25' }}">
                {{ $cat->name }}
            </a>
        @endforeach
    </div>

    <div class="grid grid-cols-2 gap-10">
        @foreach ($categories as $cat)
            <div class="flex flex-col gap-4">
                <h3 class="text-2xl text-slate-700 font-medium">{{ $cat->name }}</h3>
                <button class="w-full h-12 bg-primary text-white text-xs font-medium rounded-lg flex items-center justify-center gap-2" onclick="CreateWorkshop('{{ $cat }}')">
                    <ion-icon name="add-outline" class="text-lg"></ion-icon>
                    Workshop Baru
                </button>
                @foreach ($cat->workshops as $ws)
                    @php
                        $totalSales = $ws->count + $ws->quantity;
                        $salesPercentage = $ws->count / 100 * $totalSales;
                    @endphp

                    <div class="bg-white rounded-lg p-8 shadow flex flex-col gap-4">
                        <div class="flex items-center gap-4">
                            <h4 class="flex basis-32 grow text-lg text-slate-700">{{ $ws->title }}</h4>
                            @if ($me->role == "admin")
                                <a href="{{ route('admin.workshop.update', $ws->id) }}" class="w-8 h-8 bg-green-500 text-white flex items-center justify-center rounded-lg" onclick="Edit('{{ $ws }}', event)">
                                    <ion-icon name="create-outline" class="text-lg"></ion-icon>
                                </a>
                                <a href="{{ route('admin.workshop.delete', $ws->id) }}" class="w-8 h-8 bg-red-500 text-white flex items-center justify-center rounded-lg" onclick="Del('{{ $ws }}', event)">
                                    <ion-icon name="trash-outline" class="text-lg"></ion-icon>
                                </a>
                            @endif
                        </div>
                        @if ($ws->rundown_id != null)
                            <div class="flex items-center gap-3 text-xs">
                                @foreach (@$ws->rundown->speakers as $speaker)
                                    <li class="text-primary flex items-center gap-1">
                                        <div class="w-1 h-1 rounded-full bg-primary"></div>
                                        {{ $speaker->name }}
                                    </li>
                                @endforeach
                            </div>
                        @endif
                        <div class="text-xs text-slate-500">Kapastas : {{ $ws->count }} dari {{ $totalSales }}</div>
                        <div class="flex bg-slate-200">
                            <div class="h-2 w-[{{ $salesPercentage }}%] bg-gradient-to-r from-blue-900 to-blue-500"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
@endsection

@section('ModalArea')
    
@include('admin.workshop.create')
@include('admin.workshop.delete')
@include('admin.workshop.edit')

@endsection

@section('javascript')
<script>
    let schedules = @json($schedules);
    let rundown = null;

    const CreateWorkshop = cat => {
        cat = JSON.parse(cat);

        select("#CreateWorkshop #CategoryName").innerHTML = ' ' + cat.name;
        select("#CreateWorkshop #category_id").value = cat.id;
        toggleHidden('#CreateWorkshop');
    }
    const Del = (data, e) => {
        e.preventDefault();
        data = JSON.parse(data);
        let link = e.currentTarget;

        select("#DeleteWorkshop form").setAttribute('action', link.href);
        select("#DeleteWorkshop #title").innerHTML = data.title;

        toggleHidden("#DeleteWorkshop");
    }
    const Edit = (data, e) => {
        e.preventDefault();
        data = JSON.parse(data);
        let link = e.currentTarget;
        rundown = data.rundown;

        select("#EditWorkshop form").setAttribute('action', link.href);
        select("#EditWorkshop #title").value = data.title;
        select("#EditWorkshop #quantity").value = data.quantity;
        select("#EditWorkshop #rundown_id").value = data.rundown_id;
        select(`#EditWorkshop #schedule_id option[value='${data?.rundown?.schedule_id}']`).selected = true;
        renderRundown(rundown.schedule_id, "#EditWorkshop");

        toggleHidden("#EditWorkshop");
    }

    const renderRundown = (scheduleID, prefix) => {
        let rundowns = [];
        schedules.map((sched, s) => {
            if (sched.id == scheduleID) {
                rundowns = sched.rundowns;
            }
        });

        select(`${prefix} #RundownArea`).innerHTML = "";
        select(`${prefix} #rundown_id`).value = "";
        rundowns.map((rund, r) => {
            let item = document.createElement('div');
            item.classList.add('border', 'rounded-lg', 'p-4', 'flex', 'items-center', 'gap-3', 'cursor-pointer', 'rundown-item');
            if (rundown?.id == rund.id) {
                item.classList.add('border-primary');
                select(`${prefix} #rundown_id`).value = rundown?.id;
            }
            item.addEventListener('click', () => selectRundown(rund, prefix));
            item.setAttribute('id', `rundown_${rund.id}`);
            item.innerHTML = `<h4 class="text-sm text-slate-600 flex grow">${rund.title}</h4>
            <div class="text-xs text-slate-500">${rund.start_time} - ${rund.end_time}</div>`;

            select(`${prefix} #RundownArea`).appendChild(item);
        });
    }
    const handleSchedule = (prefix, event) => {
        let input = event.currentTarget;
        renderRundown(input.value, prefix);
    }
    const selectRundown = (rundown, prefix) => {
        let item = select(`${prefix} #rundown_${rundown.id}`);
        
        selectAll(`${prefix} .rundown-item`).forEach(div => div.classList.remove('border-primary'));
        item.classList.add('border-primary');

        select(`${prefix} #rundown_id`).value = rundown.id;
    }
</script>
@endsection