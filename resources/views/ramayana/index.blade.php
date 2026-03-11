@extends('layouts.page')

@section('title', "Tiket Ramayana")
    
@section('content')
<div class="w-full bg-coklat-muda text-primary flex flex-col gap-8 justify-end p-20 mobile:p-8 py-24 text-primary">
    <div class="h-[10vh] mobile:h-[20vh]"></div>
    <h2 class="text-4xl font-bold">Tiket Ramayana</h2>
    <div class="flex">
        <button class="p-3 px-6 rounded-full bg-primary text-white text-sm font-medium" onclick="toggleHidden('#TicketModal')">
            Beli Tiket
        </button>
    </div>
    <div class="mobile:h-[10vh]"></div>
</div>

<div class="p-20 mobile:p-8 grid grid-cols-2 mobile:grid-cols-1 gap-10">
    <div class="flex flex-col gap-4">
        <h3 class="text-4xl text-primary font-bold mt-8">Sendratari Ramayana</h3>
        <div class="flex flex-col gap-2 mt-4">
            @for ($i = 0; $i < 2; $i++)
                <div class="flex items-center gap-2">
                    @for ($j = 0; $j < 6; $j++)
                        <div class="w-2 h-2 rounded-full bg-coklat-muda"></div>
                    @endfor
                </div>
            @endfor
        </div>
    </div>
    <div class="flex flex-col gap-4">
        <div class="mobile:text-sm text-slate-600 leading-7 mobile:leading-8">
            Sendratari Ramayana merupakan salah satu media dalam menyajikan wiracarita atau epos Ramayana, media lain seperti seni sastra, seni rupa, dan berbagai seni pertunjukan. Sendratari mengutamakan gerak-gerak penguat ekspresi sebagai pengganti dialog, sehingga dengan sendratari diharapkan penyampaian wiracarita Ramayana dapat lebih mudah dipahami dengan latar belakang budaya dan bahasa penonton yang berbeda. 
        </div>
    </div>
</div>

<div class="p-20 mobile:p-8 flex flex-col items-center gap-10">
    <h3 class="text-4xl mobile:text-2xl font-bold w-9/12 mobile:w-full text-center">
        <span class="text-primary">Sendratari Ramayana Prambanan.</span>
        Cerita penuh sejak Rama mengikuti sayembara hingga pertemuannya dengan Sinta.
    </h3>
    <img src="/images/ramayana.jpg" alt="Rama" class="w-full aspect-[5/2] mobile:aspect-[16/9] object-cover rounded-xl">
</div>

<div class="p-20 mobile:p-8 grid grid-cols-2 mobile:grid-cols-1 items-center gap-20 mobile:gap-10">
    <div class="flex flex-col gap-2 font-bold text-lg">
        <h4 class="text-primary text-xl">Harmoni Tari dan Drama.</h4>
        <div class="text-slate-800">
            Sendratari Ramayana merupakan sebuah pertunjukan yang menggabungkan tari dan drama tanpa dialog yang mengangkat wiracarita Ramayana karya Walmiki.
        </div>
    </div>
    <div class="flex items-center justify-center">
        <img src="/images/ramayana-2.jpg" alt="Rama2" class="w-full rounded-xl">
    </div>
</div>

<section class="grid grid-cols-4 group relative">
    <img src="/images/ramayana.jpg" alt="Ramayana" class="h-[300px] w-full object-cover">
    <img src="/images/ramayana-2.jpg" alt="Ramayana 2" class="h-[300px] w-full object-cover">
    <img src="/images/ramayana.jpg" alt="Ramayana" class="h-[300px] w-full object-cover">
    <img src="/images/ramayana-2.jpg" alt="Ramayana 2" class="h-[300px] w-full object-cover">

    <div class="absolute top-0 left-0 right-0 bottom-0 backdrop-blur-sm bg-black/30 group-hover:bg-black/50 group-hover:backdrop-blur-md text-white p-20 mobile:p-8 flex flex-col gap-4 items-center justify-center">
        <h4 class="text-3xl font-bold">Dapatkan Tiketnya Sekarang!</h4>
        <button class="p-3 px-6 rounded-full bg-primary text-white text-sm font-medium" onclick="toggleHidden('#TicketModal')">
            Beli Tiket
        </button>
    </div>
</section>


@include('partials.footer')
@endsection

@section('ModalArea')

@include('ramayana.purchase')

@endsection

@section('javascript')
<script>
    const Currency = (amount) => {
        let props = {};
        props.encode = (prefix = 'Rp') => {
            let result = '';
            let amountRev = amount.toString().split('').reverse().join('');
            for (let i = 0; i < amountRev.length; i++) {
                if (i % 3 === 0) {
                    result += amountRev.substr(i,3)+'.';
                }
            }
            return prefix + ' ' + result.split('',result.length-1).reverse().join('');
        }
        props.decode = () => {
            return parseInt(amount.replace(/,.*|[^0-9]/g, ''), 10);
        }
        
        return props;
    } 

    let price = parseInt("{{ env('RAMAYANA_PRICE') }}");

    const qty = (input, action) => {
        if (input === null) {
            input = select("#TicketModal #qty");
        }
        let value = parseInt(input.value);
        let newValue = 0;

        if (action === null) {
            newValue = input.value;
        } else {
            if (action == 'increase') {
                if (value < 5) {
                    newValue = value + 1;
                }
            } else {
                if (value > 1) {
                    newValue = value - 1;
                }
            }
        }

        input.value = newValue;
        select("#TicketModal #TotalPrice").innerHTML = Currency(newValue * price).encode();
    }

    select("#TicketModal #qty").addEventListener('input', (event) => {
        qty(event.currentTarget, null);
    })
</script>
@endsection