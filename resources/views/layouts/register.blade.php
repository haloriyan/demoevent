<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - {{ env('APP_NAME') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {!! json_encode(config('tailwind')) !!}
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        div, aside, header { transition: 0.4s; }
        body {
            font-family: "Poppins", sans-serif;
            font-style: normal;
            font-weight: 400;
        }
    </style>
    @yield('head')
</head>
<body class="bg-green-800">

<div class="fixed mobile:overflow-y-auto top-10 mobile:top-0 left-10 mobile:left-0 right-10 mobile:right-0 bottom-10 mobile:bottom-0 flex mobile:flex-col bg-white rounded-xl mobile:rounded-none">
    <div class="flex flex-col w-5/12 mobile:w-full mobile:min-h-[500px] bg-[url(/images/doodle.png)] bg-cover relative rounded-s-xl mobile:rounded-s-none">
        <div class="absolute top-0 left-0 right-0 bottom-0 bg-black/20 backdrop-blur-sm text-white flex flex-col gap-2 mobile:gap-4 justify-end p-10 rounded-s-xl mobile:rounded-s-none">
            <h1 class="text-[42px] mobile:text-[32px] font-bold">PIT PERAMI 2025</h1>
            <div class="text-[18px] mobile:text-[14px]">
                Sheraton Hotel & Towers, 25 - 27 November 2025
            </div>
        </div>
    </div>
    <div class="flex flex-col gap-4 basis-32 grow p-10 desktop:overflow-y-auto">
        @yield('content')
    </div>
</div>

@yield('ModalArea')

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script>
    const select = dom => document.querySelector(dom);
    const selectAll = dom => document.querySelectorAll(dom);

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
</script>
@yield('javascript')

</body>
</html>