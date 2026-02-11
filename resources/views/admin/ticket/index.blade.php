@extends('layouts.admin')

@section('title', "Tiket")

@php
    use Carbon\Carbon;
@endphp

@section('head')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/airbnb.css">
@endsection
    
@section('content')
<div class="p-8 flex flex-col gap-10">
    @include('partials.flash_message')

    @foreach ($categories as $category)
        <div class="flex flex-col gap-6">
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-4 grow">
                    <h3 class="text-xl text-slate-700 font-medium">{{ $category->name }}</h3>
                    @if ($me->role == "admin")
                        <a href="{{ route('admin.ticket.category.update', $category->id) }}" class="flex items-center gap-1 p-1 px-3 border-[0.3px] bg-green-100 text-green-500 border-green-500 rounded-full text-xs" onclick="EditCategory(event, '{{ $category }}')">
                            <ion-icon name="create-outline"></ion-icon>
                            Edit
                        </a>
                        <a href="{{ route('admin.ticket.category.delete', $category->id) }}" class="flex items-center gap-1 p-1 px-3 border-[0.3px] bg-red-100 text-red-500 border-red-500 rounded-full text-xs" onclick="DeleteCategory(event, '{{ $category }}')">
                            <ion-icon name="trash-outline"></ion-icon>
                            Hapus
                        </a>
                    @endif
                </div>
                @if ($me->role == "admin")
                    <button class="bg-primary p-3 px-5 rounded-lg text-white text-xs font-medium flex items-center gap-3" onclick="AddTicket(event, '{{ $category }}')">
                        <ion-icon name="add-outline" class="text-lg"></ion-icon>
                        Tambah Tiket
                    </button>
                @endif
            </div>

            <div class="grid grid-cols-3 gap-8">
                @foreach ($category->tickets as $ticket)
                    @php
                        $salesAmount = $ticket->start_quantity - $ticket->quantity;
                        $salesPercentage = $salesAmount / 100 * $ticket->start_quantity ?? 0;
                    @endphp
                    <div class="bg-white p-8 rounded-lg shadow-sm flex flex-col gap-3">
                        <div class="flex items-center gap-4">
                            <h4 class="text-lg text-slate-700 font-medium flex basis-24 grow">{{ $ticket->name }}</h4>
                            @if ($me->role == "admin")
                                <div class="w-10 h-10 border rounded-lg flex items-center justify-center cursor-pointer group relative">
                                    <ion-icon name="ellipsis-horizontal-outline" class="text-xl"></ion-icon>

                                    <div class="absolute top-[-10px] right-[-10px] rounded-lg bg-white py-4 border hidden group-hover:flex flex-col">
                                        <a href="{{ route('admin.ticket.update', $ticket->id) }}" class="flex items-center gap-3 p-2 px-5 hover:bg-slate-100 text-sm text-green-500" onclick="EditTicket(event, '{{ $ticket }}')">
                                            <ion-icon name="create-outline" class="text-lg"></ion-icon>
                                            Edit
                                        </a>
                                        @if ($ticket->quantity == $ticket->start_quantity)
                                            <a href="{{ route('admin.ticket.delete', $ticket->id) }}" class="flex items-center gap-3 p-2 px-5 hover:bg-slate-100 text-sm text-red-500" onclick="DeleteTicket(event, '{{ $ticket }}')">
                                                <ion-icon name="trash-outline" class="text-lg"></ion-icon>
                                                Hapus
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div></div>
                        <div class="flex items-center gap-3 text-slate-500 text-xs">
                            <ion-icon name="pricetags-outline" class="text-base"></ion-icon>
                            {{ currency_encode($ticket->price) }}
                        </div>
                        {{-- <div class="flex items-center gap-3 text-slate-500 text-xs">
                            <ion-icon name="calendar-outline" class="text-base"></ion-icon>
                            {{ Carbon::parse($ticket->start_date)->isoFormat('DD MMM Y') }}
                        </div> --}}

                        <div class="flex bg-slate-200 mt-4">
                            <div class="h-2 w-[{{ $salesPercentage }}%] bg-gradient-to-r from-blue-900 to-blue-500"></div>
                        </div>

                        <div class="text-right text-xs text-slate-500">
                            {{ $salesAmount }} dari {{ $ticket->start_quantity }} Terjual
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
    @if ($me->role == "admin")
        <div class="p-8 relative">
            <div class="w-full h-[1px] bg-primary"></div>
            <div class="absolute top-0 left-0 right-0 bottom-0 flex items-center justify-center">
                <div class="flex items-center justify-center gap-3 bg-slate-100 p-4 px-5 cursor-pointer text-primary text-sm" onclick="toggleHidden('#AddCategory')">
                    <ion-icon name="add-circle-outline" class="text-lg"></ion-icon>
                    Kategori Tiket Baru
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@section('ModalArea')

@include('admin.ticket.category_add')
@include('admin.ticket.category_edit')
@include('admin.ticket.category_delete')
@include('admin.ticket.create')
@include('admin.ticket.delete')
@include('admin.ticket.edit')

@endsection

@section('javascript')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
<script>
    const EditCategory = (event, data) => {
        event.preventDefault();
        data = JSON.parse(data);
        const link = event.currentTarget;

        select("#EditCategory form").setAttribute('action', link.href);
        select("#EditCategory #name").value = data.name;

        toggleHidden("#EditCategory");
    }
    const DeleteCategory = (event, data) => {
        event.preventDefault();
        data = JSON.parse(data);
        const link = event.currentTarget;

        select("#DeleteCategory form").setAttribute('action', link.href);
        select("#DeleteCategory #name").innerHTML = data.name;

        toggleHidden("#DeleteCategory");
    }

    const AddTicket = (event, data) => {
        event.preventDefault();
        data = JSON.parse(data);

        select("#AddTicket #category_name").innerHTML = data.name;
        select("#AddTicket #category_id").value = data.id;

        flatpickr("#AddTicket #date", {
            dateFormat: 'Y-m-d',
            onChange: dt => {
                let theDate = dayjs(dt);
                console.log(theDate.format('YYYY-MM-DD'));
                
            }
        })

        toggleHidden("#AddTicket");
    }
    const DeleteTicket = (event, data) => {
        event.preventDefault();
        data = JSON.parse(data);
        const link = event.currentTarget;

        select("#DeleteTicket form").setAttribute('action', link.href);
        select("#DeleteTicket #name").innerHTML = data.name;

        toggleHidden("#DeleteTicket");
    }
    const EditTicket = (event, data) => {
        event.preventDefault();
        data = JSON.parse(data);
        const link = event.currentTarget;

        select("#EditTicket form").setAttribute('action', link.href);
        select("#EditTicket #name").value = data.name;
        select("#EditTicket #price").value = data.price;
        select("#EditTicket #price_type").value = Currency(data.price).encode();
        select("#EditTicket #quantity").value = data.quantity;
        select("#EditTicket #date").value = data.start_date;

        flatpickr("#EditTicket #date", {
            dateFormat: 'Y-m-d',
            onChange: dt => {
                let theDate = dayjs(dt);
                console.log(theDate.format('YYYY-MM-DD'));
            }
        })

        toggleHidden("#EditTicket");
    }

    const TypePrice = (input, target = null) => {
        let val = Currency(input.value).decode();
        if (isNaN(val)) {
            val = 0;
        }

        if (target == null) {
            target = input;
        } else {
            target = select(target);
        }

        input.value = Currency(val).encode();
        target.value = val;

        if (modules.length > 0) {
            calculate();
        }
    }

</script>
@endsection