@extends('layouts.admin')

@section('title', "Booth")
    
@section('content')
<div class="p-8 flex flex-col gap-6">
    <div class="bg-white rounded-lg shadow-sm p-4 flex items-center gap-4">
        <form class="border rounded-lg flex items-center grow px-4">
            <input type="text" name="q" class="w-full h-14 text-sm text-slate-500 outline-0" placeholder="Cari...">
            <button class="flex items-center">
                <ion-icon name="search-outline"></ion-icon>
            </button>
        </form>

        <button class="bg-primary text-white text-sm font-medium h-14 px-8 rounded-lg flex items-center gap-2" onclick="toggleHidden('#CreateBooth')">
            <ion-icon name="add-outline" class="text-xl"></ion-icon>
            Booth
        </button>
    </div>

    @include('partials.flash_message')

    <div class="grid grid-cols-4 gap-8">
        @foreach ($booths as $boo)
            <div class="bg-white rounded-lg shadow p-8 flex flex-col gap-2 relative">
                <img src="{{ asset('storage/booth_icons/' . $boo->icon) }}" alt="{{ $boo->name }}" class="w-full aspect-square object-cover">
                <h4 class="text-slate-700 mt-4">{{ $boo->name }}</h4>
                <div class="text-xs text-slate-600">{{ $boo->description }}</div>

                <div class="absolute top-0 right-0 p-4">
                    <div class="group relative">
                        <div class="w-8 h-8 rounded-full bg-slate-200 text-slate-800 flex items-center justify-center cursor-pointer">
                            <ion-icon name="ellipsis-horizontal-outline" class="text-lg"></ion-icon>
                        </div>

                        <div class="absolute top-0 right-0 flex-col py-2 bg-white rounded-lg shadow hidden group-hover:flex">
                            <a href="{{ route('admin.booth.update', $boo->id) }}" class="flex items-center gap-3 p-2 px-5 hover:bg-slate-100 text-sm text-green-500" onclick="EditBooth(event, '{{ $boo }}')">
                                <ion-icon name="create-outline" class="text-lg"></ion-icon>
                                Edit
                            </a>
                            <a href="{{ route('admin.booth.delete', $boo->id) }}" class="flex items-center gap-3 p-2 px-5 hover:bg-slate-100 text-sm text-red-500" onclick="DeleteBooth(event, '{{ $boo }}')">
                                <ion-icon name="trash-outline" class="text-lg"></ion-icon>
                                Hapus
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@section('ModalArea')
    
@include('admin.booth.create')
@include('admin.booth.delete')
@include('admin.booth.edit')

@endsection

@section('javascript')
<script>
    const EditBooth = (event, data) => {
        event.preventDefault();
        const link = event.currentTarget;
        data = JSON.parse(data);

        select("#EditBooth form").setAttribute('action' , link.href);
        select("#EditBooth #name").value = data.name;
        select("#EditBooth #username").value = data.username;
        select("#EditBooth #description").value = data.description;

        applyImageToDiv(select('#EditBooth #IconArea'), `/storage/booth_icons/${data.icon}`);

        toggleHidden("#EditBooth");
    }
    const DeleteBooth = (event, data) => {
        event.preventDefault();
        const link = event.currentTarget;
        data = JSON.parse(data);

        select("#DeleteBooth form").setAttribute('action', link.href);
        select("#DeleteBooth #name").innerHTML = data.name;

        toggleHidden("#DeleteBooth");
    }
</script>
@endsection