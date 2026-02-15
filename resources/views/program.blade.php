@extends('layouts.page')

@section('title', "Program")

@php
    use Carbon\Carbon;
@endphp
    
@section('content')
<div class="w-full bg-coklat-muda text-white flex flex-col gap-8 justify-end p-20 py-24 text-primary">
    <div class="h-[10vh]"></div>
    <h2 class="text-4xl font-bold">Programs</h2>
    <div class="font-medium">Jadwal dan Rundown.</div>
</div>

<section class="p-20 mobile:p-8 flex flex-col gap-12">
    <div class="grid grid-cols-3 mobile:grid-cols-1 gap-10 w-full">
        @foreach ($schedules as $schedule)
            <div class="rounded-lg border">
                <div class="p-4 bg-secondary rounded-t-lg text-white font-medium">
                    {{ Carbon::parse($schedule->date)->isoFormat('DD MMMM YYYY') }}
                </div>
                <div class="p-4 flex flex-col gap-8">
                    @foreach ($schedule->rundowns as $rundown)
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center gap-8">
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
                            </div>

                            <div class="flex items-center gap-2">
                                @if ($rundown->speakers->count() > 0)
                                    <div class="flex items-center w-full relative cursor-pointer" onclick="ManageSpeaker(event, '{{ $rundown }}')">
                                        <img src="{{ asset('storage/speaker_photos/' . $rundown->speakers[0]->photo) }}" class="w-10 h-10 border-2 border-white rounded-full" />
                                        @isset($rundown->speakers[1])
                                            <img src="{{ asset('storage/speaker_photos/' . $rundown->speakers[1]->photo) }}" class="w-10 h-10 border-2 border-white rounded-full absolute left-6" />
                                        @endisset
                                        @isset($rundown->speakers[2])
                                            <img src="{{ asset('storage/speaker_photos/' . $rundown->speakers[2]->photo) }}" class="w-10 h-10 border-2 border-white rounded-full absolute left-12" />
                                        @endisset

                                        <div class="flex grow"></div>
                                        <div class="text-xs text-slate-500">
                                            {{ $rundown->speakers->count() }} speakers
                                        </div>
                                    </div>
                                @endif
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</section>

@include('partials.footer')
@endsection