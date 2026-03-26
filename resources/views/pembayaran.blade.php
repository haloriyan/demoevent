@extends('layouts.register')

@section('title', "Pembayaran")
    
@section('content')
@if ($request->done == 1)
    <div class="SlideItem flex flex-col items-center justify-center text-center grow gap-4">
        <div class="flex grow"></div>
        <div class="w-24 h-24 flex items-center justify-center text-4xl bg-green-600 rounded-full text-white">
            <ion-icon name="checkmark-outline"></ion-icon>
        </div>
        <h2 class="text-3xl text-slate-700 font-medium mt-8">Pembayaran Berhasil.</h2>
        <div class="text-base text-slate-600 ">
            Terima kasih atas partisipasi Anda. Mohon tunggu hingga 2 x 24 jam hingga pembayaran berhasil kami konfirmasi.
        </div>

        <div class="flex grow"></div>
        <div class="flex items-center justify-end gap-8 text-xs text-slate-500 w-full">
            <div class="flex items-center grow">
                Hubungi Kami melalui :
            </div>
            <a href="tel:{{ env('PHONE') }}" class="flex items-center gap-2">
                <ion-icon name="call-outline" class="text-base"></ion-icon>
                {{ env('PHONE') }}
            </a>
            <a href="mailto:{{ env('EMAIL') }}" class="flex items-center gap-2">
                <ion-icon name="mail-outline" class="text-base"></ion-icon>
                {{ env('EMAIL') }}
            </a>
        </div>
    </form>
@else
    <form action="{{ route('pembayaran', $transaction->id) }}" class="SlideItem flex flex-col grow gap-4" method="POST" enctype="multipart/form-data">
        @csrf

        <h2 class="text-2xl mobile:text-xl text-slate-700 font-medium">Konfirmasi Pembayaran</h2>
        <div class="text-sm text-slate-600">
            Mohon lakukan pembayaran melalui transfer dengan detail berikut ini :
        </div>

        <div class="flex flex-col items-center gap-2 mt-10">
            <div class="text-xs text-slate-500">Nominal</div>
            <div class="text-primary text-4xl mobile:text-xl font-bold">
                {{ currency_encode($transaction->payment_amount) }}
            </div>
        </div>

        <div class="flex items-center gap-8 mt-4">
            <div class="text-xs text-slate-500 mobile:flex mobile:grow">Bank Tujuan</div>
            <div class="h-[1px] bg-slate-300 flex grow mobile:hidden"></div>
            <div class="text-base text-slate-700 font-medium">
                {{ env('BANK_NAME') }}
            </div>
        </div>
        <div class="flex items-center gap-8">
            <div class="text-xs text-slate-500 mobile:flex mobile:grow">No. Rekening</div>
            <div class="h-[1px] bg-slate-300 flex grow mobile:hidden"></div>
            <div class="bg-slate-100 text-slate-700 p-2 px-4 rounded-lg flex items-center gap-4 border">
                {{ env('BANK_NUMBER') }}
                <span class="flex items-center cursor-pointer" onclick="CopyText('{{ env('BANK_NUMBER') }}', 'Nomor Rekening berhasil disalin!')">
                    <ion-icon name="copy-outline" class="text-lg"></ion-icon>
                </span>
            </div>
        </div>
        <div class="flex items-center gap-8">
            <div class="text-xs text-slate-500 mobile:flex mobile:grow">Nama Penerima</div>
            <div class="h-[1px] bg-slate-300 flex grow mobile:hidden"></div>
            <div class="text-base text-slate-700 font-medium">
                {{ env('BANK_ACCOUNT') }}
            </div>
        </div>

        <div class="w-full p-4 border rounded-lg flex mobile:flex-col items-center mobile:items-start gap-4 mt-8">
            <div class="flex flex-col gap-2 grow">
                <div class="text-sm text-slate-600">
                    Kemudian upload bukti pembayaran / transfer Anda di sini
                </div>
                <div class="flex items-center gap-4">
                    <button class="p-3 px-5 rounded-lg text-sm bg-slate-200 text-slate-700" type="button" onclick="PickImage()">
                        Pilih Foto
                    </button>
                    <button class="p-3 px-5 rounded-lg text-sm bg-primary text-white font-medium">
                        Upload
                    </button>
                </div>
            </div>
            <div class="w-24 mobile:w-full aspect-square mobile:aspect-video bg-slate-200 rounded-lg relative flex flex-col gap-1 items-center justify-center" id="ImageArea">
                <ion-icon name="image-outline" class="text-4xl text-slate-700"></ion-icon>
                <input type="file" name="image" id="image" class="absolute top-0 left-0 right-0 bottom-0 opacity-0 cursor-pointer" onchange="onChangeImage(this, '#ImageArea')" required>
            </div>
        </div>
    </form>
@endif
@endsection

@section('javascript')
<script>
    const CopyText = (text, responseText) => {
        navigator.clipboard.writeText(text);
        alert(responseText);
    }
    const PickImage = () => {
        select("#image").click();
    }
</script>
@endsection