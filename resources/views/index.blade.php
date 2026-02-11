@extends('layouts.page')

@section('title', "Home")

@php
    use Carbon\Carbon;
@endphp

@section('head')
<style>
    .CustomRadius {
        border-top-right-radius: 64px !important;
        border-bottom-left-radius: 64px !important;
    }
    @media (max-width: 480px) {
        .CustomRadius {
            border-radius: 12px !important;
        }
    }
</style>
@endsection
    
@section('content')
<div class="w-full h-[100vh] relative bg-[url(/images/hero.jpg)] bg-cover bg-center">
    <div class="absolute top-0 left-0 right-0 bottom-0 flex items-center p-20 mobile:p-8 bg-gradient-to-r from-primary via-primary-50 to-transparent text-white">
        <div class="flex flex-col gap-4 w-7/12 mobile:w-full">
            <h1 class="text-[7vh] mobile:text-[4vh] font-bold">{{ env('EVENT_NAME') }}</h1>
            <div>{{ env('EVENT_DATES') }}, {{ env('EVENT_PLACE') }}</div>
            <div class="flex items-center gap-4 mt-4">
                <a href="{{ route('register') }}" class="p-3 px-6 rounded-full text-sm font-medium bg-orange-500 text-white">
                    Daftar Sekarang
                </a>
                <a href="#" class="p-3 px-6 rounded-full text-sm font-medium border border-white text-white hover:bg-orange-500 hover:border-orange-500" onclick="selengkapnya(event)">
                    Selengkapnya
                </a>
            </div>
        </div>
    </div>
</div>

<section class="p-14 mobile:p-8 px-20 mobile:px-8 flex mobile:flex-col items-center gap-20 mobile:gap-8 justify-center">
    <div class="flex flex-col gap-4">
        <div class="text-xs text-slate-500">Supported by</div>
        <div class="flex items-center gap-4">
            <a href="#">
                <img src="/images/logo-sponsor.png" alt="Sponsor" class="h-20">
            </a>
        </div>
    </div>
    <div class="flex flex-col gap-4">
        <div class="text-xs text-slate-500">In collaboration with</div>
        <div class="flex items-center gap-4">
            <a href="#">
                <img src="/images/logo-sponsor.png" alt="Sponsor" class="h-20">
            </a>
        </div>
    </div>
</section>

<section class="p-20 mobile:p-8 flex mobile:flex-col gap-10" id="about">
    <img src="/images/doctors.jpg" alt="dokter" class="w-5/12 mobile:w-full rounded-lg object-cover" style="border-top-right-radius: 80px;border-bottom-left-radius: 80px;">
    <div class="flex flex-col gap-4 grow">
        <h3 class="text-2xl text-slate-800 font-bold flex items-center gap-4">
            <span class="bg-blue-100 text-blue-500 rounded-full p-2 px-5 text-3xl">About</span> 
            This Event
            <div></div><div></div>
            <div class="flex grow h-[2px] bg-blue-500"></div>
        </h3>
        
        <div class="text-slate-600 mobile:text-sm leading-8 mt-4">
            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Itaque accusantium obcaecati assumenda doloribus accusamus qui a molestias sequi consequuntur, beatae cumque architecto perspiciatis nulla at aspernatur, suscipit eligendi quaerat porro.
        </div>
        <div class="text-slate-600 mobile:text-sm leading-8">
            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Itaque accusantium obcaecati assumenda doloribus accusamus qui a molestias sequi consequuntur, beatae cumque architecto perspiciatis nulla at aspernatur, suscipit eligendi quaerat porro.
        </div>
        
    </div>
</section>

<section id="spakers" class="bg-primary p-20 mobile:p-8 flex flex-col gap-8">
    <div class="flex items-center gap-10 text-white">
        <h3 class="text-4xl font-bold">OUR AMAZING <span class="text-orange-500 underline">SPEAKERS</span></h3>
    </div>

    <div class="grid grid-cols-4 mobile:grid-cols-2 gap-8 mobile:gap-4">
        @foreach ($speakers as $speaker)
            <div class="bg-white p-10 mobile:p-4 rounded-xl flex flex-col gap-2 CustomRadius">
                <img src="/storage/speaker_photos/{{ $speaker['photo'] }}" alt="{{ $speaker['name'] }}" class="w-full aspect-square rounded-xl CustomRadius">
                <h4 class="mt-4 text-xl text-slate-700 font-medium">{{ $speaker['name'] }}</h4>
                <div class="text-xs text-slate-600">
                    {{ $speaker['credential'] }}
                </div>
            </div>
        @endforeach
    </div>
</section>

<section id="schedules" class="p-20 mobile:p-8 flex flex-col gap-8 items-center">
    <h3 class="text-4xl font-bold">Event <span class="text-orange-500 underline">Programs & Schedule</span> Plan</h3>
    <div class="text-sm text-slate-500">
        We are arranging the best medical summit. Don't ever miss it!
    </div>
    <div class="grid grid-cols-3 mobile:grid-cols-1 gap-10 w-full">
        @foreach ($schedules as $schedule)
            <div class="rounded-lg border">
                <div class="p-4 bg-orange-500 rounded-t-lg text-white font-medium">
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

<section class="p-20 mobile:p-8">
    <div class="rounded-xl text-white bg-gradient-to-br from-blue-900 to-blue-500 w-full flex flex-col gap-8 p-20 mobile:p-8">
        <div class="flex mobile:flex-col items-center gap-8">
            <div class="flex flex-col gap-4 grow">
                <h3 class="text-4xl mobile:text-xl font-bold">Tulis Karya Ilmiah dan Buat Poster</h3>
                <div class="font-medium mobile:text-xs">Ikuti kompetisi karya tulis ilmiah dalam topik Kesehatan dan buat poster kampanye</div>
            </div>
            <a href="{{ route('eposter') }}" class="bg-orange-500 text-white rounded-full p-3 px-8 font-medium text-sm">
                SUBMIT ABSTRAK
            </a>
        </div>

        <div class="overflow-x-scroll flex mt-4">
            <div class="flex flex-col gap-2 basis-32 mobile:basis-72 mobile:min-w-56 grow">
                <div class="flex items-center">
                    <div class="w-4 h-4 rounded-full bg-white"></div>
                    <div class="flex grow h-1 bg-white"></div>
                </div>
                <h4 class="mt-4 mobile:text-sm">Pengiriman Abstrak</h4>
                <div class="text-xs">25 Juli 2026</div>
            </div>
            <div class="flex flex-col gap-2 basis-32 mobile:basis-72 mobile:min-w-56 grow">
                <div class="flex items-center">
                    <div class="w-4 h-4 rounded-full bg-white"></div>
                    <div class="flex grow h-1 bg-white"></div>
                </div>
                <h4 class="mt-4 mobile:text-sm">Pengumuman Penerimaan Abstrak</h4>
                <div class="text-xs">15 Agustus 2026</div>
            </div>
            <div class="flex flex-col gap-2 basis-32 mobile:basis-72 mobile:min-w-56 grow">
                <div class="flex items-center">
                    <div class="w-4 h-4 rounded-full bg-white"></div>
                    <div class="flex grow h-1 bg-white"></div>
                </div>
                <h4 class="mt-4 mobile:text-sm">Pengiriman E-Poster</h4>
                <div class="text-xs">15 Agustus 2026</div>
            </div>
            <div class="flex flex-col gap-2 basis-32 mobile:basis-72 mobile:min-w-56 grow">
                <div class="flex items-center">
                    <div class="w-4 h-4 rounded-full bg-white"></div>
                    <div class="flex grow h-1 bg-white bg-opacity-0"></div>
                </div>
                <h4 class="mt-4 mobile:text-sm">Pengumuman Pemenang</h4>
                <div class="text-xs">10 Oktober 2026</div>
            </div>
        </div>
    </div>
</section>

<section id="programs" class="p-20 flex flex-col gap-8 items-center hidden">
    <h3 class="text-4xl font-bold">Amankan <span class="text-orange-500 underline">Tiket</span> Anda!</h3>
    <div class="text-sm text-slate-500">
        Beli Tiket dan Daftar sebagai...
    </div>
    <div class="flex items-center gap-4 w-full">
        <div class="p-8 rounded-lg cursor-pointer flex flex-col gap-2 basis-32 grow bg-orange-500 text-white border border-[#ffffff00]">
            <div class="w-16 h-16 border border-white text-orange-500 bg-white rounded-full flex items-center justify-center">
                <ion-icon name="medkit-outline" class="text-xl"></ion-icon>
            </div>
            <h4 class="text-lg font-medium mt-4">Spesialis Radiologi</h4>
            <div class="text-sm">
                Simposium + Full Day Workshop
            </div>
        </div>
        <div class="p-8 rounded-lg cursor-pointer flex flex-col gap-2 basis-32 grow bg-orange-100 text-orange-500 border border-[#ffffff00]">
            <div class="w-16 h-16 border border-orange-500 rounded-full flex items-center justify-center">
                <ion-icon name="id-card-outline" class="text-xl"></ion-icon>
            </div>
            <h4 class="text-lg font-medium mt-4">Residen Radiologi</h4>
            <div class="text-sm">
                Simposium + Workshop Oncology Report
            </div>
        </div>
        <div class="p-8 rounded-lg cursor-pointer flex flex-col gap-2 basis-32 grow text-orange-500 border border-orange-500">
            <div class="w-16 h-16 border border-orange-500 rounded-full flex items-center justify-center">
                <ion-icon name="people-outline" class="text-xl"></ion-icon>
            </div>
            <h4 class="text-lg font-medium mt-4">Lainnya</h4>
            <div class="text-sm">
                Simposium
            </div>
        </div>
    </div>
</section>

@include('partials.footer')
@endsection

@section('javascript')
<script>
    const toggleDate = theDate => {
        alert(theDate)
    }
    const selengkapnya = e => {
        e.preventDefault();
        select("section#about").scrollIntoView({
            behavior: 'smooth'
        })
    }
</script>
@endsection