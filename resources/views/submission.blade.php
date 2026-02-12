@extends('layouts.page')

@section('title', "Submission Form")
    
@section('content')
<div class="w-full h-[28vw] mobile:h-[86vw] bg-primary text-white flex flex-col gap-8 justify-end"></div>
<div class="flex flex-col items-center mt-[-200px] mobile:mt-[-150px]">
    <div class="w-5/12 mobile:w-10/12 flex flex-col gap-8">
        <h2 class="text-4xl text-white font-bold">Submission Form</h2>
        <form action="{{ route('submission.submit') }}" method="POST" class="p-10 bg-white rounded-lg border-b-8 border-b-primary shadow-lg flex flex-col gap-6" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" id="type">
            <div class="flex items-center gap-4 mobile:justify-center">
                <div class="flex items-center">
                    <div class="type-item cursor-pointer text-sm text-primary font-medium p-4 px-8 rounded-lg" id="abstract" onclick="changeType('abstract', this)">
                        Abstrak
                    </div>
                    <div class="type-item cursor-pointer text-sm text-primary font-medium p-4 px-8 rounded-lg" id="poster" onclick="changeType('poster', this)">
                        Poster
                    </div>
                </div>
            </div>

            @include('partials.flash_message')

            <div class="group border focus-within:border-primary rounded-lg p-2 relative">
                <label class="text-slate-500 group-focus-within:text-primary text-xs absolute top-2 left-2">Nama</label>
                <input type="text" name="name" id="name" class="w-full h-10 mt-3 outline-none bg-transparent text-sm text-slate-700" value="{{ old('name') }}" required />
            </div>
            <div class="group border focus-within:border-primary rounded-lg p-2 relative">
                <label class="text-slate-500 group-focus-within:text-primary text-xs absolute top-2 left-2">Email</label>
                <input type="email" name="email" id="email" class="w-full h-10 mt-3 outline-none bg-transparent text-sm text-slate-700" value="{{ old('email') }}" required />
            </div>

            <div class="border rounded-lg p-4 flex items-center gap-4 group relative">
                <div class="text-xs text-slate-500 flex grow" id="filenameArea">Pilih File</div>
                <button type="button" class="bg-primary text-white text-xs font-medium p-3 px-5 rounded-lg mobile:hidden">Pilih dari Komputer</button>
                <button type="button" class="bg-primary text-white text-xs font-medium p-3 px-5 rounded-lg desktop:hidden">Pilih</button>
                <input type="file" name="file" id="file" accept="application/vnd.openxmlformats-officedocument.wordprocessingml.document" class="absolute top-0 left-0 right-0 bottom-0 opacity-0 cursor-pointer" onchange="chooseFile(this)" required>
            </div>

            <div class="text-xs text-slate-500">
                Dengan mengirimkan submission, Anda berarti mematuhi dan tunduk pada <a href="{{ route('eposter') }}" class="text-primary underline">Syarat dan Ketentuan</a> yang telah Kami tetapkan.
            </div>

            <div class="flex justify-end">
                <button class="p-3 px-5 rounded-lg bg-primary text-white text-sm font-medium">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>

<div class="h-24"></div>
@include('partials.footer')
@endsection

@section('javascript')
<script>
    const changeType = (type, btn) => {
        let input = select("input#file");
        selectAll(".type-item").forEach(item => {
            item.classList.remove('bg-primary', 'text-white');
        });
        btn.classList.add('bg-primary', 'text-white');
        select("input#type").value = type;

        input.setAttribute(
            'accept', 
            type === "abstract" ? "application/vnd.openxmlformats-officedocument.wordprocessingml.document" : "application/pdf"
        );
    }
    changeType('abstract', select(".type-item#abstract"));

    const chooseFile = input => {
        let file = input.files[0];
        select("#filenameArea").innerHTML = file.name;
    }
</script>
@endsection