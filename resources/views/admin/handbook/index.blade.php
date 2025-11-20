@extends('layouts.admin')

@section('title', "Handbook")

@php
    function bytesToMB($size) {
        return ceil(($size / 1024) / 1024);
    }
@endphp

@section('subtitle')
<div class="text-xs text-slate-500">
    Dokumen untuk Informasi Peserta
</div>
@endsection
    
@section('content')
<div class="p-8 flex flex-col gap-6">
    <div class="bg-white rounded-lg shadow-sm p-4 flex items-center gap-4">
        <form class="border rounded-lg flex items-center grow px-4">
            <input type="text" name="q" class="w-full h-14 text-sm text-slate-500 outline-0" placeholder="Cari...">
            <button class="flex items-center">
                <ion-icon name="search-outline"></ion-icon>
            </button>
        </form>

        <button class="bg-primary text-white text-sm font-medium h-14 px-8 rounded-lg flex items-center gap-2" onclick="toggleHidden('#AddHandbook')">
            <ion-icon name="add-outline" class="text-xl"></ion-icon>
            Dokumen Baru
        </button>
    </div>

    @include('partials.flash_message')

    <div class="flex items-center gap-4">
        <a href="?" class="text-sm rounded-full p-2 px-5 border-[0.5px] text-primary {{ $request->category_id == null ? 'bg-primary-transparent font-medium' : 'bg-white' }}">
            Semua
        </a>
        @foreach ($categories as $cat)
            @php
                $isActive = $cat->id == $request->category_id;
            @endphp
            <div class="text-sm rounded-full p-1 pe-5 border-[0.5px] group relative flex items-center gap-2 text-primary {{ $isActive ? 'bg-primary-transparent font-medium border-primary' : 'bg-white' }}">
                <a href="{{ route('admin.handbook.category.delete', $cat->id) }}" class="flex items-center justify-center w-8 h-8 rounded-full text-red-500 hover:text-white hover:bg-red-500 cursor-pointer" onclick="DeleteCategory(event, '{{ $cat }}')">
                    <ion-icon name="trash-outline"></ion-icon>
                </a>
                <a href="?category_id={{ $cat->id }}">{{ $cat->name }}</a>
            </div>
        @endforeach
        
        <div class="text-sm rounded-full p-1 ps-2 pe-5 border flex items-center gap-1 cursor-pointer bg-primary text-white" onclick="toggleHidden('#AddCategory')">
            <div class="flex items-center justify-center w-8 h-8 rounded-full">
                <ion-icon name="add-outline" class="text-lg"></ion-icon>
            </div>
            Kategori
        </div>
    </div>

    <div class="grid grid-cols-4 gap-4">
        @foreach ($handbooks as $book)
            <div class="rounded-lg bg-white p-2 shadow-sm flex flex-col gap-2 relative">
                <div class="w-full aspect-video bg-primary flex items-center justify-center text-white rounded-lg">
                    <ion-icon name="document-outline" class="text-3xl"></ion-icon>
                </div>

                <h4 class="text-slate-700 font-medium">{{ $book->title }}</h4>
                <div class="text-xs text-slate-500">
                    ~{{ bytesToMB($book->size) }} MB
                </div>

                <div class="flex items-center gap-3">
                    @foreach ($book->categories as $cat)
                        <a href="?category_id={{ $cat->id }}" class="font-bold text-primary text-xs">
                            #{{ $cat->name }}
                        </a>
                    @endforeach
                </div>

                <div class="absolute top-0 right-0 flex p-4">
                    <a href="{{ route('admin.handbook.delete', $book->id) }}" class="w-8 h-8 flex items-center justify-center group relative bg-white rounded" onclick="DeleteHandbook(event, '{{ $book }}')">
                        <ion-icon name="trash-outline" class="text-red-500"></ion-icon>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@section('ModalArea')

@include('admin.handbook.add_category')
@include('admin.handbook.delete_category')
@include('admin.handbook.add')
@include('admin.handbook.delete')

@endsection

@section('javascript')
<script>
    const DeleteCategory = (event, data) => {
        event.preventDefault();
        data = JSON.parse(data);
        const link = event.currentTarget;

        select("#DeleteCategory form").setAttribute('action', link.href);
        select("#DeleteCategory #name").innerHTML = data.name;
        
        toggleHidden("#DeleteCategory");
    }
    const DeleteHandbook = (event, data) => {
        event.preventDefault();
        data = JSON.parse(data);
        const link = event.currentTarget;

        select("#DeleteHandbook form").setAttribute('action', link.href);
        select("#DeleteHandbook #name").innerHTML = data.title;
        
        toggleHidden("#DeleteHandbook");
    }

    const toggleCategory = (prefix, btn, data) => {
        data = JSON.parse(data);
        let categoryIDs = select(`${prefix} #category_ids`);
        let selectedCategories = JSON.parse(categoryIDs.value);

        let index = selectedCategories.indexOf(data.id);
        if (index > -1) {
            selectedCategories.splice(index, 1);
            btn.classList.remove('border-primary', 'text-primary');
        } else {
            selectedCategories.push(data.id);
            btn.classList.add('border-primary', 'text-primary');
        }

        categoryIDs.value = JSON.stringify(selectedCategories);
    }
</script>
@endsection