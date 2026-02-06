@extends('layouts.admin')

@section('title', "Speakers")
    
@section('content')
<div class="p-8 flex flex-col gap-6">
    <div class="bg-white rounded-lg shadow-sm p-4 flex items-center gap-4">
        <div class="flex grow"></div>
        <button class="bg-primary p-3 px-5 rounded-lg text-white text-xs font-medium flex items-center gap-3" onclick="AddSpeaker()">
            <ion-icon name="add-outline" class="text-lg"></ion-icon>
            Speaker
        </button>
    </div>

    @include('partials.flash_message')
    
    <div class="grid grid-cols-3 gap-4">
        @foreach ($speakers as $speaker)
            <div class="bg-white flex items-center gap-6 bg-white rounded-lg shadow-sm p-6">
                @if ($speaker->photo == null)
                    <div class="w-16 h-16 rounded-full flex items-center justify-center bg-slate-100">
                        <ion-icon name="person-outline" class="text-xl text-slate-700"></ion-icon>
                    </div>
                @else
                    <img src="/storage/speaker_photos/{{ $speaker->photo }}" alt="{{ $speaker->name }}" class="h-16 w-16 rounded-full object-cover">
                @endif
                <div class="flex flex-col grow gap-1">
                    <h3 class="text-slate-700 font-medium">{{ $speaker->name }}</h3>
                    <div class="text-sm text-slate-500">{{ $speaker->credential }}</div>
                </div>
                <div class="group relative">
                    <div class="w-8 h-8 rounded-lg border flex items-center justify-center cursor-pointer">
                        <ion-icon name="ellipsis-horizontal-outline" class="text-lg text-slate-500"></ion-icon>
                    </div>

                    <div class="absolute top-0 right-0 bg-white rounded border py-2 hidden group-hover:flex flex-col">
                        <a href="{{ route('admin.speaker.update', $speaker->id) }}" class="flex items-center gap-2 p-2 px-4 text-green-500 hover:bg-slate-100" onclick="EditSpeaker(event, '{{ $speaker }}')">
                            <ion-icon name="create-outline" class="text-lg"></ion-icon>
                            <div class="text-xs">Edit</div>
                        </a>
                        <a href="{{ route('admin.speaker.delete', $speaker->id) }}" class="flex items-center gap-2 p-2 px-4 text-red-500 hover:bg-slate-100" onclick="DeleteSpeaker(event, '{{ $speaker }}')">
                            <ion-icon name="trash-outline" class="text-lg"></ion-icon>
                            <div class="text-xs">Hapus</div>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@section('ModalArea')
@include('admin.speaker.edit')
@include('admin.speaker.create')
@include('admin.speaker.delete')
@endsection

@section('javascript')
<script>
    const AddSpeaker = () => {
        toggleHidden('#AddSpeaker');
    }

    const DeleteSpeaker = (event, data) => {
        event.preventDefault();
        data = JSON.parse(data);
        const link = event.currentTarget;

        select("#DeleteSpeaker form").setAttribute('action', link.href);
        select("#DeleteSpeaker #name").innerHTML = data.name;

        toggleHidden("#DeleteSpeaker");
    }
    const EditSpeaker = (event, data) => {
        event.preventDefault();
        data = JSON.parse(data);
        const link = event.currentTarget;

        select("#EditSpeaker form").setAttribute('action', link.href);
        select("#EditSpeaker #name").value = data.name;
        select("#EditSpeaker #credential").value = data.credential;

        if (data.photo != null) {
            applyImageToDiv('#EditSpeaker #PhotoArea', `/storage/speaker_photos/${data.photo}`);
        }

        toggleHidden("#EditSpeaker");
    }

</script>
@endsection