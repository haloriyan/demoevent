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
    {{-- <div class="absolute top-0 left-0 right-0 bottom-0 flex items-center p-20 mobile:p-8 bg-gradient-to-b from-coklat-muda-transparent via-coklat-muda to-coklat-muda-gradient text-slate-800"> --}}
        <div class="absolute top-0 left-0 right-0 bottom-0 flex items-center p-20 mobile:p-8 text-white">
        <div class="flex flex-col gap-4 w-7/12 mobile:w-full">
            <h1 class="text-[7vh] mobile:text-[4vh] font-bold">{{ env('EVENT_NAME') }}</h1>
            <div>{{ env('EVENT_DATES') }}, {{ env('EVENT_PLACE') }}</div>
            <div class="flex items-center gap-4 mt-4">
                <a href="{{ route('register') }}" class="p-3 px-6 rounded-full text-sm font-medium bg-secondary text-white">
                    Daftar Sekarang
                </a>
                <a href="#" class="p-3 px-6 rounded-full text-sm font-medium border border-white text-white hover:bg-white hover:border-primary hover:text-primary" onclick="selengkapnya(event)">
                    Selengkapnya
                </a>
            </div>
        </div>
    </div>
</div>

<section class="p-14 bg-white mobile:p-8 px-20 mobile:px-8 flex gap-8 mobile:gap-8">
    <div class="flex flex-col gap-4 grow">
        <div class="text-xs text-slate-500">Diselenggarakan oleh</div>
        <img src="/images/penyelenggara.png" alt="Sponsor" class="min-h-64 mobile:h-auto mobile:w-full">
    </div>
    <div class="flex flex-col gap-4 grow">
        <div class="text-xs text-slate-500">Berkolaborasi dengan</div>
        <img src="/images/kolaborator.png" alt="Sponsor" class="min-h-64 mobile:h-auto">
    </div>
</section>

<section class="p-20 mobile:p-8 flex mobile:flex-col gap-10" id="about">
    {{-- <img src="/images/doctors.jpg" alt="dokter" class="w-5/12 mobile:w-full rounded-lg object-cover" style="border-top-right-radius: 80px;border-bottom-left-radius: 80px;"> --}}
    <div class="w-5/12 mobile:w-full flex flex-col gap-4 items-center text-center">
        <img src="/images/Bambang_Purwanto_Utomo.jpg" alt="Bambang Purwanto Utomo" class="w-7/12 rounded-lg" style="border-top-right-radius: 80px;border-bottom-left-radius: 80px;">
        <h3 class="text-3xl text-slate-700 font-bold mt-4">Bambang Purwanto Utomo</h3>
        <div class="text-slate-600">Ketua Panitia</div>
    </div>
    <div class="flex flex-col gap-4 basis-32 grow">
        <h3 class="text-2xl text-slate-800 font-bold flex items-center gap-4">
            <span class="bg-coklat-muda text-primary rounded-full p-2 px-5 text-3xl">Sugeng</span> 
            Rawuh
            <div></div><div></div>
            <div class="flex grow h-[2px] bg-primary"></div>
        </h3>
        
        <div class="text-slate-600 text-sm leading-7 mt-4">
            Di tahun 2026,  PERABDIN bekerjasama dengan Asian Society of Abdominal Radiology (ASAR) dengan bangga akan menyelenggarakan pertemuan ilmiah Radiologi Abdomen bergengsi di tingkat Asia yaitu ASAR Educational Lecture Course yang yang dikolaborasikan dengan Pertemuan Ilmiah PERABDIN di Kota Budaya Yogyakarta. Tema yang diangkat adalah "<i>Harmonizing the knowledge, art, and wisdom in abdominal radiology</i>", harapannya kegiatan ini dapat mewujudkan suatu harmonisasi antara ilmu radiologi, ketrampilan medis, seni dan kearifan dalam mencapai ketepatan diagnosis imaging.
        </div>
        <div class="text-slate-600 text-sm leading-7">
            Kehadiran para pembicara dari ASAR dengan serangkaian kapasitas expert subspesialistik radiologi abdomen, akan semakin menambah nilai pada kegiatan ini. Kami mengajak seluruh teman sejawat untuk hadir dan belajar bersama di kota Yogyakarta yang sangat kaya akan keindahan alam serta nilai kebudayaan nya.
        </div>
        <div class="text-slate-600 text-sm leading-7 mt-4">
            Matur nuwun, sugeng pepanggihan ing pawiwahan
        </div>
    </div>
</section>

<section id="spakers" class="bg-primary p-20 mobile:p-8 flex flex-col gap-8">
    <div class="flex items-center gap-10 text-white">
        <h3 class="text-4xl font-bold"><span class="text-coklat-muda underline">PEMBICARA</span> SPEKTAKULER ACARA INI</h3>
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
    <h3 class="text-4xl font-bold"><span class="text-secondary underline">Programs</span> Acara</h3>
    <div class="grid grid-cols-3 mobile:grid-cols-1 gap-10 w-full">
        @foreach ($schedules as $schedule)
            <div class="rounded-lg border">
                <div class="p-4 bg-secondary rounded-t-lg text-white font-medium">
                    <div>{{ Carbon::parse($schedule->date)->isoFormat('dddd, DD MMMM YYYY') }}</div>
                    <div class="text-xs">{{ $schedule->description }}</div>
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
                                    <div class="flex flex-col gap-2 list-disc ps-4">
                                        @foreach ($rundown->speakers as $speak)
                                            <li class="text-xs text-primary font-medium">{{ $speak->name }}</li>
                                        @endforeach
                                    </div>
                                    {{-- <div class="flex items-center w-full relative cursor-pointer" onclick="ManageSpeaker(event, '{{ $rundown }}')">
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
                                    </div> --}}
                                @endif
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</section>

<section class="p-20 mobile:p-8 py-8">
    <div class="flex items-center gap-8">
        <h3 class="flex grow text-4xl text-slate-700 font-bold">Unduh Panduan Acara</h3>
        <div class="cursor-pointer p-4 px-5 rounded-full text-sm font-medium text-white bg-secondary flex items-center gap-3" onclick="toggleHidden('#GuidelineDownload')">
            <ion-icon name="book-outline" class="text-lg"></ion-icon>
            Unduh Panduan
        </div>
    </div>
</section>

<section class="p-20 mobile:p-8">
    <div class="rounded-xl text-primary bg-gradient-to-br from-coklat-muda to-coklat-muda-gradient w-full flex flex-col gap-4 p-20 mobile:p-8">
        <div class="flex mobile:flex-col items-center gap-8">
            <div class="flex flex-col gap-4 grow">
                <h3 class="text-4xl mobile:text-xl font-bold">Ikutilah Kompetisi E-Poster</h3>
            </div>
            <a href="{{ route('eposter') }}" class="bg-secondary text-white rounded-full p-3 px-8 font-medium text-sm">
                SUBMIT ABSTRAK
            </a>
        </div>
        <div class="font-medium mobile:text-xs">
            Terbuka bagi seluruh peserta dengan hadiah menarik berupa :
            <table class="mt-4">
                <tr>
                    <td>Juara I </td>
                    <td> : Rp 5.000.000</td>
                </tr>
                <tr>
                    <td>Juara II </td>
                    <td> : Rp 3.000.000</td>
                </tr>
                <tr>
                    <td>Juara III </td>
                    <td> : Rp 2.000.000</td>
                </tr>
            </table>
        </div>
    </div>
</section>

<section class="bg-[url(/images/mariott-2.jpeg)] bg-top bg-center relative desktop:aspect-[5/2]">
    <div class="desktop:absolute top-0 left-0 right-0 bottom-0 p-20 mobile:p-8 flex flex-col items-center justify-center">
        <div class="p-20 mobile:p-8 rounded-xl bg-white/15 backdrop-blur-md border border-[#ccc] text-white text-center flex flex-col items-center gap-6">
            <h3 class="text-4xl mobile:text-lg font-bold">Penawaran Eksklusif Yogyakarta Mariott Hotel untuk Peserta {{ env('EVENT_NAME') }}</h3>
            <div class="text-sm mb-2">
                Dapatkan penginapan di Yogyakarta Mariott Hotel dengan harga dan penawaran khusus untuk Peserta {{ env('EVENT_NAME') }}
            </div>
            <a href="{{ env('HOTEL_LINK') }}" class="p-4 px-8 rounded-full bg-secondary text-white text-sm font-bold" target="_blank">
                Cek Ketersediaan
            </a>
        </div>
    </div>
</section>

@include('partials.footer')
@endsection

@section('ModalArea')
<div class="fixed top-0 left-0 right-0 bottom-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-30" id="GuidelineDownload">
    <form method="GET" class="bg-white shadow-lg rounded-lg p-10 w-4/12 mobile:w-10/12 flex flex-col gap-4 mt-4">
        <div class="flex items-center gap-4 mb-4">
            <h3 class="text-lg text-slate-700 font-medium flex grow">Unduh Guideline Acara</h3>
            <ion-icon name="close-outline" class="cursor-pointer text-3xl" onclick="toggleHidden('#GuidelineDownload')"></ion-icon>
        </div>

        <a href="#" class="flex items-center gap-4 border rounded-lg text-sm p-4 px-5 border-primary text-primary hover:bg-primary hover:text-white">
            <ion-icon name="download-outline" class="text-lg"></ion-icon>
            Second Announcement
        </a>
        <a href="#" class="flex items-center gap-4 border rounded-lg text-sm p-4 px-5 border-primary text-primary hover:bg-primary hover:text-white">
            <ion-icon name="download-outline" class="text-lg"></ion-icon>
            Final Announcement
        </a>
    </form>
</div>
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