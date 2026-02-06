@extends('layouts.page')

@section('title', "Program")

@php
    use Carbon\Carbon;
@endphp
    
@section('content')
<div class="w-full bg-primary text-white flex flex-col gap-8 justify-end p-20 py-24">
    <div class="h-[10vh]"></div>
    <h2 class="text-4xl font-bold">Programs</h2>
    <div class="font-medium">Jadwal dan Rundown.</div>
</div>

<section class="p-20 flex flex-col gap-12">
    @foreach ($schedules as $schedule)
        <div>
            <h3 class="text-slate-500 text-4xl font-bold">{{ Carbon::parse($schedule->date)->isoFormat('DD MMMM YYYY') }}</h3>
            <div class="flex flex-col gap-4 mt-8">
                @foreach ($schedule->rundowns as $rundown)
                    <div class="border rounded-lg p-8 flex items-center gap-4">
                        <div class="flex flex-col gap-2">
                            <h4 class="text-slate-700 font-medium">{{ $rundown->title }}</h4>
                            <div class="text-sm text-slate-500">
                                {{ Carbon::parse($rundown->start_time)->format('H:i') }} -
                                {{ Carbon::parse($rundown->end_time)->format('H:i') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</section>

@include('partials.footer')
@endsection