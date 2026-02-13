@extends('layouts.page')

@section('title', "Panduan E-Poster")

@section('head')
<style>
    .active {
        background-color: #1f3989;
        color: #fff;
    }
</style>
@endsection
    
@section('content')
<div class="w-full bg-primary text-white flex flex-col gap-8 justify-end p-20 py-24">
    <div class="h-[10vh]"></div>
    <div class="font-medium text-sm">Panduan</div>
    <h2 class="text-4xl font-bold">Kompetisi Abstrak & E-Poster</h2>
    <div class="flex items-center gap-4">
        <a href="{{ route('submission') }}" class="p-3 px-8 rounded-full font-medium text-sm border border-orange-500 bg-orange-500 hover:bg-orange-800 hover:border-orange-500 text-white">
            Submission Form
        </a>
        <a href="#" class="p-3 px-8 rounded-full font-medium text-sm border border-white hover:bg-white hover:text-orange-500">
            Baca Panduan
        </a>
    </div>
</div>

<section class="p-20 bg-slate-100 flex flex-col gap-8 items-center">
    <h3 class="text-2xl text-slate-700 font-medium">Pengiriman <span class="text-orange-500 underline">Abstrak</span></h3>
    <div class="w-full bg-white shadow-md rounded-lg p-10 flex gap-10">
        <div class="w-3/12 flex flex-col">
            <div class="rounded-full p-4 px-5 cursor-pointer text-sm font-medium AbstrakTab" id="AbstrakTab_PanduanUmum" onclick="switchAbstrak('PanduanUmum')">
                Panduan Umum
            </div>
            <div class="rounded-full p-4 px-5 cursor-pointer text-sm font-medium AbstrakTab" id="AbstrakTab_Research" onclick="switchAbstrak('Research')">
                Research Abstract
            </div>
            <div class="rounded-full p-4 px-5 cursor-pointer text-sm font-medium AbstrakTab" id="AbstrakTab_CaseReport" onclick="switchAbstrak('CaseReport')">
                Case Report
            </div>
        </div>
        <div class="flex flex-col gap-4 basis-32 grow">
            <div class="AbstrakContent hidden" id="AbstrakContent_PanduanUmum">
                <h4 class="text-xl text-slate-700 font-medium">Panduan Pengiriman Abstrak</h4>
                <div class="ps-4 text-sm text-slate-600 leading-8 mt-4">
                    <li>Ditulis dalam bahasa Inggris, menggunakan font Arial ukuran 11pt dan spasi tunggal.</li>
                    <li>Batas kata: 20 kata untuk judul, dan 300 kata untuk isi teks.</li>
                    <li>Penulis utama dicantumkan pertama kali dan diberi garis bawah sebagai presenter (pemapar).</li>
                    <li>Detail afiliasi meliputi departemen, institusi/rumah sakit, kota/provinsi, dan negara.</li>
                    <li>Abstrak hanya boleh berisi teks. Tabel, grafik, atau diagram TIDAK diperbolehkan untuk dimasukkan ke dalam abstrak.</li>
                    <li>Abstrak dikirim melalui website registrasi PIT PERABDIN - ASAR ELC 2026.</li>
                </div>
            </div>
            <div class="AbstrakContent hidden" id="AbstrakContent_Research">
                <h4 class="text-xl text-slate-700 font-medium">Panduan Research</h4>
                <div class="text-sm text-slate-600 leading-8 mt-2">
                    Isi Research Abstract terdiri dari empat paragraf utama yang menjelaskan secara singkat hal-hal berikut :
                </div>
                <div class="text-sm text-slate-600 leading-8 mt-4 ps-4">
                    <li><span class="font-medium text-slate-800">BACKGROUND / OBJECTIVE</span> : Nyatakan secara singkat mengapa penelitian ini dilakukan</li>
                    <li><span class="font-medium text-slate-800">METHOD</span> : Sebutkan lokasi, jumlah sampel, pengujian utama yang dilakukan, dan jenis analisis statistik yang digunakan.</li>
                    <li><span class="font-medium text-slate-800">RESULT</span> : Konfirmasi atau bantah hipotesis yang ada, didukung dengan data statistik jika diperlukan.</li>
                    <li><span class="font-medium text-slate-800">CONCLUSION</span> : Nyatakan dampak dari studi ini terhadap tata laksana pasien di masa depan atau pemahaman terhadap proses-proses dasar.</li>
                </div>
            </div>
            <div class="AbstrakContent hidden" id="AbstrakContent_CaseReport">
                <h4 class="text-xl text-slate-700 font-medium">Panduan Case Report</h4>
                <div class="text-sm text-slate-600 leading-8 mt-2">
                    Isi Case Report Abstract harus terdiri dari :
                </div>
                <div class="text-sm text-slate-600 leading-8 mt-4 ps-4">
                    <li><span class="font-medium text-slate-800">BACKGROUND / OBJECTIVE</span> : Nyatakan secara singkat mengapa kasus ini penting untuk dilaporkan, sisi kebaruannya (novelty), serta implikasi klinisnya.</li>
                    <li><span class="font-medium text-slate-800">CASE</span> : Deskripsi atau gambaran kasus.</li>
                    <li><span class="font-medium text-slate-800">CONCLUSION</span> : Ringkasan implikasi klinis dari kasus ini, saran untuk penerapan klinis, tindakan pencegahan yang perlu diambil, atau topik penelitian lebih lanjut yang diperlukan.</li>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="p-20 pt-0 bg-slate-100 flex flex-col gap-8 items-center">
    <h3 class="text-2xl text-slate-700 font-medium">Pengiriman <span class="text-orange-500 underline">E-Poster</span></h3>
    <div class="w-8/12 mobile:w-full bg-white shadow-md rounded-lg p-10 flex gap-10">
        <div class="text-sm text-slate-600 leading-8 mt-4 ps-4">
            <li>Lomba poster terbuka bagi individu yang telah terdaftar sebagai peserta simposium.</li>
            <li>Tema abstrak adalah “Imaging of Abdominal Oncology” (Pencitraan Onkologi Abdomen).</li>
            <li>Abstrak yang dikirimkan tidak boleh pernah dipresentasikan sebelumnya di acara ilmiah lainnya.</li>
            <li>Batas waktu pengiriman abstrak: 25 Juli 2026.</li>
            <li>Abstrak yang diterima setelah batas waktu tidak akan diproses.</li>
            <li>Abstrak yang dikirimkan dapat berupa laporan kasus (case report) atau penelitian.</li>
            <li>Abstrak akan ditinjau oleh Komite Ilmiah berdasarkan kriteria berikut: kualitas, kejelasan, relevansi, dan signifikansi.</li>
            <li>Pengumuman penerimaan abstrak: 15 Agustus 2026.</li>
            <li>Konfirmasi penerimaan akan dikirim melalui email peserta (mohon hubungi panitia jika Anda belum menerima konfirmasi).</li>
            <li>Tidak ada pengembalian biaya pendaftaran bagi abstrak yang tidak diterima.</li>
            <li>Semua abstrak yang diterima akan mendapatkan Sertifikat Partisipasi E-Poster.</li>
            <li>Pemenang kompetisi E-Poster akan ditentukan berdasarkan Rapat Dewan Juri. Keputusan Juri bersifat mutlak dan tidak dapat diganggu gugat.</li>
            <li>Pemenang akan diumumkan pada hari Sabtu, 10 Oktober 2026, saat Acara Penutupan</li>
            <li>E-Poster dikirim langsung melalui email ke Alamat : asarelcposter2026@gmail.com</li>
        </div>
    </div>
</section>

<section class="p-20 mobile:p-8 bg-slate-100">
    <div class="rounded-xl text-white bg-gradient-to-br from-blue-900 to-blue-500 w-full flex flex-col gap-8 p-20 mobile:p-8">
        <div class="flex mobile:flex-col items-center gap-8">
            <div class="flex flex-col gap-4 grow">
                <h3 class="text-4xl mobile:text-xl font-bold">Tulis Karya Ilmiah dan Buat Poster</h3>
                <div class="font-medium mobile:text-xs">Ikuti kompetisi karya tulis ilmiah dalam topik Kesehatan dan buat poster kampanye</div>
            </div>
            <a href="{{ route('submission') }}" class="bg-orange-500 text-white rounded-full p-3 px-8 font-medium text-sm">
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

@include('partials.footer')
@endsection

@section('javascript')
<script>
    const toggler = (toHide, toShow, classToSwitch = 'hidden', revert = false) => {
        if (revert) {
            selectAll(toHide).forEach(item => item.classList.add(classToSwitch));
            select(toShow).classList.remove(classToSwitch);
        } else {
            selectAll(toHide).forEach(item => item.classList.remove(classToSwitch));
            select(toShow).classList.add(classToSwitch);
        }
    }
    const switchAbstrak = target => {
        toggler(".AbstrakTab", `#AbstrakTab_${target}`, 'active');
        toggler(".AbstrakContent", `#AbstrakContent_${target}`, 'hidden', true);
    }

    switchAbstrak("PanduanUmum");
</script>
@endsection