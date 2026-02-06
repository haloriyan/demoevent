@extends('layouts.admin')

@section('title', "Event Schedule")

@php
    use Carbon\Carbon;
@endphp

@section('head')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/airbnb.css">
@endsection
    
@section('content')
<div class="p-10 flex flex-col gap-8">
    @include('partials.flash_message')

    <div class="grid grid-cols-3 mobile:grid-cols-1 items-start gap-4">
        @foreach ($schedules as $schedule)
            <div class="border rounded-lg bg-white">
                <div class="flex items-center gap-4 border-b p-3 px-4">
                    <div class="text-slate-600 font-medium flex grow">{{ $schedule->title }}</div>
                    <a href="{{ route('admin.schedule.update', [$schedule->id]) }}" class="flex items-center bg-green-500 text-white p-2 px-3 rounded-lg" onclick="EditSchedule(event, '{{ $schedule }}')">
                        <ion-icon name="create-outline" ></ion-icon>
                    </a>
                    {{-- <a href="{{ route('admin.schedule.delete', [$schedule->id]) }}" class="flex items-center bg-red-500 text-white p-2 px-3 rounded-lg" onclick="DeleteSchedule(event, '{{ $schedule }}')">
                        <ion-icon name="trash-outline" ></ion-icon>
                    </a> --}}
                </div>
                <div class="p-4 flex flex-col gap-4">
                    @foreach ($schedule->rundowns as $rundown)
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center gap-4">
                                <div class="flex flex-col gap-1 grow">
                                    <div class="text-sm text-slate-600">{{ $rundown->title }}</div>
                                    <div class="text-xs text-slate-500">
                                        {{ Carbon::parse($rundown->start_time)->format('H:i') }} -
                                        {{ Carbon::parse($rundown->end_time)->format('H:i') }}
                                    </div>
                                </div>
                                <div class="text-xs text-slate-500">
                                    {{ Carbon::parse($rundown->start_time)->diffInMinutes(
                                        Carbon::parse($rundown->end_time)
                                    ) }} menit
                                </div>
                                <div class="w-8 h-8 flex items-center justify-center group relative">
                                    <ion-icon name="ellipsis-horizontal-outline"></ion-icon>

                                    <div class="absolute top-[-10px] right-0 hidden group-hover:flex items-center gap-2 bg-white border rounded-lg p-2">
                                        <a href="{{ route('admin.rundown.update', [$rundown->id]) }}" class="w-8 h-8 flex items-center justify-center bg-primary text-primary bg-opacity-20 rounded-lg" onclick="ManageSpeaker(event, '{{ $rundown }}')">
                                            <ion-icon name="people-outline"></ion-icon>
                                        </a>
                                        <a href="{{ route('admin.rundown.update', [$rundown->id]) }}" class="w-8 h-8 flex items-center justify-center bg-green-100 text-green-500 rounded-lg" onclick="EditRundown(event, '{{ $rundown }}')">
                                            <ion-icon name="create-outline"></ion-icon>
                                        </a>
                                        <a href="{{ route('admin.rundown.delete', [$rundown->id]) }}" class="w-8 h-8 flex items-center justify-center bg-red-100 text-red-500 rounded-lg" onclick="DeleteRundown(event, '{{ $rundown }}')">
                                            <ion-icon name="trash-outline"></ion-icon>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-center gap-2">
                                <div class="text-xs text-slate-500">
                                    {{ $rundown->speakers->count() }} speaker
                                </div>
                            </div>

                            <div class="flex flex-wrap gap-2">
                                @foreach ($rundown->speakers as $speaker)
                                    <div class="p-1 px-3 rounded border text-xs text-slate-600">
                                        {{ $speaker->name }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    <button class="text-primary hover:bg-primary-transparent rounded-lg w-full h-10 text-xs font-medium flex items-center justify-center gap-4" onclick="AddRundown('{{ $schedule }}')">
                        <ion-icon name="add-outline"></ion-icon>
                        Tambah Rundown
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@section('ModalArea')
    
@include('admin.schedule.create')
@include('admin.schedule.delete')
@include('admin.schedule.edit')

@include('admin.rundown.create')
@include('admin.rundown.delete')
@include('admin.rundown.edit')

@include('admin.rundown.speaker')

@endsection

@section('javascript')
<script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="{{ asset('js/MultiSelectorAPI.js') }}"></script>
<script>
    const flatpickrTimeConfig = {
        dateFormat: "H:i",
        noCalendar: true,
        enableTime: true,
        time_24hr: true,
    };

    const EditSchedule = (event, data) => {
        event.preventDefault();
        data = JSON.parse(data);
        const link = event.currentTarget;

        select("#EditSchedule form").setAttribute('action', link.href);
        select("#EditSchedule #title").value = data.title;
        select("#EditSchedule #description").value = data.description;

        let option = document.createElement('option');
        option.value = data.date;
        option.innerHTML = dayjs(data.date).format('DD MMMM YYYY');
        option.selected = true;
        select("#EditSchedule #date").prepend(option);
        
        toggleHidden("#EditSchedule");
    }
    const DeleteSchedule = (event, data) => {
        event.preventDefault();
        data = JSON.parse(data);
        const link = event.currentTarget;

        select("#DeleteSchedule form").setAttribute('action', link.href);
        
        toggleHidden("#DeleteSchedule");
    }
    const AddRundown = data => {
        data = JSON.parse(data);
        select("#AddRundown #schedule_id").value = data.id;
        toggleHidden('#AddRundown');
    }
    const DeleteRundown = (event, data) => {
        event.preventDefault();
        data = JSON.parse(data);
        const link = event.currentTarget;

        select("#DeleteRundown form").setAttribute('action', link.href);
        
        toggleHidden("#DeleteRundown");
    }
    const EditRundown = (event, data) => {
        event.preventDefault();
        data = JSON.parse(data);
        const link = event.currentTarget;

        select("#EditRundown form").setAttribute('action', link.href);
        select("#EditRundown #title").value = data.title;
        select("#EditRundown #description").value = data.description;
        select("#EditRundown #start_time").value = data.start_time;
        select("#EditRundown #end_time").value = data.end_time;
        
        flatpickr("#EditRundown #start_time_picker", {
            ...flatpickrTimeConfig,
            defaultDate: data.start_time,
            onChange: selectedTime => {
                selectedTime = dayjs(selectedTime).format('HH:mm');
                select("#EditRundown #start_time").value = selectedTime;
                RenderRundownEndTime(selectedTime, '#EditRundown');
            }
        });
        flatpickr("#EditRundown #end_time_picker", {
            ...flatpickrTimeConfig,
            defaultDate: data.end_time,
            minTime: data.start_time,
            onChange: selectedTime => {
                selectedTime = dayjs(selectedTime).format('HH:mm');
                select("#EditRundown #end_time").value = selectedTime;
            }
        });
        
        toggleHidden("#EditRundown");
    }

    const RenderRundownEndTime = (minTime, prefix = '#AddRundown') => {
        flatpickr(`${prefix} #end_time_picker`, {
            ...flatpickrTimeConfig,
            minTime,
            onChange: selectedTime => {
                select(`${prefix} #end_time`).value = dayjs(selectedTime).format('HH:mm');
            }
        });
    }

    flatpickr("#AddRundown #start_time_picker", {
        ...flatpickrTimeConfig,
        onChange: selectedTime => {
            selectedTime = dayjs(selectedTime).format('HH:mm');
            select("#AddRundown #start_time").value = selectedTime;
            RenderRundownEndTime(selectedTime);
        }
    });

    const ManageSpeaker = (e) => {
        e.preventDefault();
        toggleHidden("#ManageSpeaker");
    }

    new MultiSelectorAPI('#SpeakerSelector', [], {
        fetchUrl: '/api/speakers/search?q=',
        name: "speaker_ids",
        label: "Cari Speaker untuk ditambahkan",
        parseResponse: (data) => data.speakers // if the response is { categories: [...] }
    });

</script>
@endsection