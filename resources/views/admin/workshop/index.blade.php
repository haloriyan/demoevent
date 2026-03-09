@extends('layouts.admin')

@section('title', "Workshops")
    
@section('content')
<div class="p-10 flex flex-col gap-8">
    @include('partials.flash_message')
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
                            <h4 class="flex grow text-lg text-slate-700">{{ $ws->title }}</h4>
                            @if ($me->role == "admin")
                                <a href="{{ route('admin.workshop.update', $ws->id) }}" class="w-8 h-8 bg-green-500 text-white flex items-center justify-center rounded-lg" onclick="Edit('{{ $ws }}', event)">
                                    <ion-icon name="create-outline" class="text-lg"></ion-icon>
                                </a>
                                <a href="{{ route('admin.workshop.delete', $ws->id) }}" class="w-8 h-8 bg-red-500 text-white flex items-center justify-center rounded-lg" onclick="Del('{{ $ws }}', event)">
                                    <ion-icon name="trash-outline" class="text-lg"></ion-icon>
                                </a>
                            @endif
                        </div>
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

        select("#EditWorkshop form").setAttribute('action', link.href);
        select("#EditWorkshop #title").value = data.title;
        select("#EditWorkshop #quantity").value = data.quantity;

        toggleHidden("#EditWorkshop");
    }
</script>
@endsection