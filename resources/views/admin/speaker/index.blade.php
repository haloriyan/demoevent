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

    <div class="bg-white p-8 shadow rounded-lg">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b">
                    <th class="py-4"></th>
                    <th class="text-sm text-slate-800 font-medium py-4">Speaker</th>
                    <th class="text-sm text-slate-800 font-medium py-4">Kredensial</th>
                    <th class="text-sm text-slate-800 font-medium py-4">Tampil di Depan</th>
                    <th class="py-4"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($speakers as $s => $speaker)
                    <tr>
                        <td class="py-4 text-sm text-slate-600">
                            <div class="flex items-center gap-3">
                                <a href="{{ $loop->first ? '#' : route('admin.speaker.priority', [$speaker->id, 'increase']) }}" class="flex items-center {{ $loop->first ? 'opacity-0' : '' }}">
                                    <ion-icon name="arrow-up-outline"></ion-icon>
                                </a>
                                <a href="{{ $loop->last ? '#' : route('admin.speaker.priority', [$speaker->id, 'decrease']) }}" class="flex items-center {{ $loop->last ? 'opacity-0' : '' }}">
                                    <ion-icon name="arrow-down-outline"></ion-icon>
                                </a>
                            </div>
                        </td>
                        <td class="py-4 text-sm text-slate-600">
                            <div class="flex items-center gap-4">
                                <img src="/storage/speaker_photos/{{ $speaker->photo }}" alt="{{ $speaker->name }}" class="h-10 w-10 rounded-full object-cover">
                                {{ $speaker->name }}
                            </div>
                        </td>
                        <td class="py-4 text-sm text-slate-600">
                            {{ $speaker->credential }}
                        </td>
                        <td class="py-4 text-sm text-slate-600">
                            <a href="{{ route('admin.speaker.featured', $speaker->id) }}" class="w-10 rounded-full p-1 flex {{ $speaker->is_featured ? 'bg-green-500 justify-end' : 'bg-slate-200' }}">
                                <div class="h-4 w-4 bg-white rounded-full"></div>
                            </a>
                        </td>
                        <td class="py-4 text-sm text-slate-600">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.speaker.update', $speaker->id) }}" class="flex items-center gap-2 p-2 px-4 text-green-500 hover:bg-slate-100 border rounded-lg" onclick="EditSpeaker(event, '{{ $speaker }}')">
                                    <ion-icon name="create-outline" class="text-lg"></ion-icon>
                                    <div class="text-xs">Edit</div>
                                </a>
                                <a href="{{ route('admin.speaker.delete', $speaker->id) }}" class="flex items-center gap-2 p-2 px-4 text-red-500 hover:bg-slate-100 border rounded-lg" onclick="DeleteSpeaker(event, '{{ $speaker }}')">
                                    <ion-icon name="trash-outline" class="text-lg"></ion-icon>
                                    <div class="text-xs">Hapus</div>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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