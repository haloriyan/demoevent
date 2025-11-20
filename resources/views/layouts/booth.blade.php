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
        /* scanner overlay square + dimming outside */
        #ScannerOverlay { 
            /* overlay container covers whole area and centers the box */
            inset: 0;
        }

        /* the centered square "hole" */
        #ScannerOverlay .scanner-box {
            --size: 40vmin;                 /* change this for square size, or use px */
            width: var(--size);
            aspect-ratio: 1 / 1;            /* ALWAYS a perfect square */
            background: transparent;
            border-radius: 12px;            /* rounded corners if you want */
            border: 2px solid rgba(255,255,255,0.85);  /* visible frame */
            box-shadow: 0 0 0 100vmax rgba(0,0,0,0.7);
            /* pointer-events none on parent already prevents blocking interactions */
        }

        /* optional: make square smaller on small screens */
        @media (max-width: 480px) {
            #ScannerOverlay .scanner-box { --size: 65vmin; }
        }

        

    </style>
    @yield('head')
</head>
<body class="bg-slate-100">

<div class="absolute top-0 left-0 right-0 flex justify-center">
    <div class="w-4/12 mobile:w-full mobile:p-8 desktop:py-8 relative">
        @yield('content')
    </div>
</div>

@php
    $route = Route::currentRouteName();
    $routes = explode(".", $route);
@endphp

<div class="fixed bottom-0 left-0 right-0 flex justify-center">
    <div class="bg-white rounded-t-lg border border-b-0 h-16 flex items-center justify-center px-4 w-4/12 mobile:w-full relative">
        <a href="{{ route('booth.dashboard') }}" class="flex flex-col items-center justify-center gap-1 grow {{ $routes[1] == 'dashboard' ? 'text-primary' : 'text-slate-500' }}">
            <ion-icon name="home-outline" class="text-xl"></ion-icon>
            <span class="text-xs">Home</span>
        </a>
        <a href="{{ route('booth.scan') }}" class="w-[82px] aspect-square rounded-full flex items-center justify-center bg-primary text-white text-xl absolute top-[-41px] border-[10px] border-slate-100">
            <ion-icon name="scan-outline"></ion-icon>
        </a>
        <div class="flex grow"></div>
        <a href="{{ route('booth.profile') }}" class="flex flex-col items-center justify-center gap-1 grow {{ $routes[1] == 'profile' ? 'text-primary' : 'text-slate-500' }}">
            <ion-icon name="create-outline" class="text-xl"></ion-icon>
            <span class="text-xs">Profil</span>
        </a>
    </div>
</div>

@yield('ModalArea')

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script>
    const select = dom => document.querySelector(dom);
    const selectAll = dom => document.querySelectorAll(dom);
    const toggleHidden = target => {
        select(target).classList.toggle('hidden');
    }
    const Initial = (name) => {
        const words = name.trim().split(' ');                        

        if (words.length === 1) {
            return words[0][0].toUpperCase() + (words[0][1] ? words[0][1].toUpperCase() : '');
        } else {
            return words[0][0].toUpperCase() + words[words.length - 1][0].toUpperCase();
        }
    }

</script>
@yield('javascript')

</body>
</html>