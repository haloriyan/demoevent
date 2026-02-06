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

        div, aside, header, a { transition: 0.4s; }
        body {
            font-family: "Poppins", sans-serif;
            font-style: normal;
            font-weight: 400;
        }
    </style>
    @yield('head')
</head>
<body>

<header id="header" class="fixed top-0 left-0 right-0 h-20 px-20 flex items-center gap-4 z-20 default">
    <div class="flex grow basis-24">
        <a href="#">
            <img src="/images/logo.png" alt="Header logo" class="h-12">
        </a>
    </div>
    <div class="flex items-center justify-center gap-8 w-6/12">
        <a href="/" class="flex items-center gap-3 p-2 px-4">
            <ion-icon name="home-outline" class="text-lg"></ion-icon>
            <div class="text-xs">Home</div>
        </a>
        <a href="{{ route('program') }}" class="flex items-center gap-3 p-2 px-4">
            <ion-icon name="calendar-outline" class="text-lg"></ion-icon>
            <div class="text-xs">Programs</div>
        </a>
        <a href="{{ route('eposter') }}" class="flex items-center gap-3 p-2 px-4">
            <ion-icon name="images-outline" class="text-lg"></ion-icon>
            <div class="text-xs">E-Poster</div>
        </a>
        <a href="{{ route('contact') }}" class="flex items-center gap-3 p-2 px-4">
            <ion-icon name="call-outline" class="text-lg"></ion-icon>
            <div class="text-xs">Hubungi Kami</div>
        </a>
    </div>
    <div class="flex grow basis-24 justify-end">
        <a href="#" class="bg-orange-500 text-white text-xs font-bold rounded-full p-3 px-6">
            Daftar Sekarang
        </a>
    </div>
</header>

<div class="absolute top-0 left-0 right-0">
    @yield('content')
</div>

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script>
    const select = dom => document.querySelector(dom);
    const selectAll = dom => document.querySelectorAll(dom);

    const activateHeader = () => {
        let header = select("#header");
        if (!header.classList.contains('default')) {
            header.classList.add('default');

            header.classList.remove('top-12', 'text-white');
            header.classList.add('bg-white', 'border-b', 'text-slate-700');
        }
    }
    const muteHeader = () => {
        let header = select("#header");
        if (header.classList.contains('default')) {
            header.classList.remove('default');

            header.classList.add('top-12', 'text-white');
            header.classList.remove('bg-white', 'border-b', 'text-slate-700');
        }
    }

    const handleScroll = (e) => {
        let position = window.scrollY;
        if (position > 100) {
            activateHeader();
        } else {
            muteHeader();
        }
    }

    document.addEventListener("scroll", handleScroll);
    handleScroll();
    muteHeader();
</script>
@yield('javascript')

</body>
</html>