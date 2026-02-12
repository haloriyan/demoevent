<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - {{ env('APP_NAME') }}</title>
    {{-- <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'> --}}
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
        /* Tailwind plugin or global CSS */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

    </style>
    @yield('head')
</head>
<body class="bg-slate-100">

@php
    $me = me();
    $route = Route::currentRouteName();
    $routes = explode(".", $route);
@endphp

<div class="fixed top-0 left-0 right-0 z-20 flex items-center">
    <a href="{{ route('admin.dashboard') }}" class="w-72 h-16 flex gap-4 items-center justify-center bg-white mobile:hidden" id="LeftHeader">
        {{-- <img src="#" alt="Logo Heaedr" class="h-12 w-12 bg-slate-200 rounded-lg"> --}}
        {{-- {!! logo() !!} --}}
        <h1 class="text-slate-700 font-bold text-sm">{{ env('APP_NAME') }}</h1>
    </a>
    <div class="bg-white h-16 flex items-center gap-2 grow px-10 border-b" id="header">
        <div class="h-12 aspect-square flex items-center justify-start cursor-pointer" onclick="toggleSidebar()">
            <ion-icon name="grid-outline" class="text-slate-700 mobile:text-xl"></ion-icon>
        </div>
        <div class="flex flex-col grow">
            <div class="text-base mobile:text-sm font-medium text-slate-700">@yield('title')</div>
            @yield('subtitle')
        </div>

        <button class="p-3 px-6 rounded-lg bg-primary text-white text-xs font-bold flex items-center justify-center gap-4" onclick="InitScanQR()">
            <ion-icon name="scan-outline" class="text-lg"></ion-icon>
            Scan QR
        </button>
        <a href="{{ route('admin.logout') }}" class="p-3 px-6 rounded-lg bg-white border text-red-400 text-xs font-bold flex items-center justify-center gap-4">
            <ion-icon name="log-out-outline" class="text-lg"></ion-icon>
            Logout
        </a>
        
        @yield('header.right')
    </div>
</div>

<div class="fixed top-16 left-0 mobile:left-[-100%] bottom-0 w-72 mobile:w-full z-20 bg-white shadow p-4 overflow-y-auto" id="sidebar">
    @php
        $routeName = Route::currentRouteName();
        $routes = explode(".", $routeName);
        $masterRoutes = [
            'peserta', 'speaker', 'schedule', 'ticket', 'booth'
        ];
    @endphp

    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 {{ $routeName == 'admin.dashboard' ? 'bg-primary-transparent text-primary' : 'text-slate-500' }}">
        <div class="h-12 w-1 {{ $routeName == 'dashboard' ? 'bg-primary' : 'bg-white' }}"></div>
        <ion-icon name="home-outline"></ion-icon>
        <div class="text-sm flex">Dashboard</div>
    </a>

    <div class="group relative">
        <a href="#" class="flex items-center gap-4 text-slate-500 {{ in_array($routes[1], $masterRoutes) ? 'bg-primary-transparent text-primary' : '' }}">
            <div class="h-12 w-1 {{ in_array($routes[1], $masterRoutes) ? 'bg-primary' : 'bg-white' }}"></div>
            <ion-icon name="cube-outline" class="{{ in_array($routes[1], $masterRoutes) ? 'text-primary' : '' }}"></ion-icon>
            <div class="text-sm flex grow {{ in_array($routes[1], $masterRoutes) ? 'text-primary' : '' }}">Master Data</div>
            <ion-icon name="chevron-down-outline" class="me-4"></ion-icon>
        </a>
        <div class="{{ in_array($routes[1], $masterRoutes) ? 'flex' : 'hidden' }} group-hover:flex flex-col mt-2 mb-2">
            <a href="{{ route('admin.speaker') }}" class="flex items-center gap-4 text-slate-500">
                <div class="h-10 w-1 bg-white"></div>
                <ion-icon name="ellipse-outline" class="text-[8px] {{ @$routes[1] == 'speaker' ? 'text-primary' : '' }}"></ion-icon>
                <div class="text-sm flex grow {{ @$routes[1] == 'speaker' ? 'text-primary' : '' }}">Speaker</div>
            </a>
            <a href="{{ route('admin.schedule') }}" class="flex items-center gap-4 text-slate-500">
                <div class="h-10 w-1 bg-white"></div>
                <ion-icon name="ellipse-outline" class="text-[8px] {{ @$routes[1] == 'schedule' ? 'text-primary' : '' }}"></ion-icon>
                <div class="text-sm flex grow {{ @$routes[1] == 'schedule' ? 'text-primary' : '' }}">Jadwal & Rundown</div>
            </a>
            <a href="{{ route('admin.ticket') }}" class="flex items-center gap-4 text-slate-500">
                <div class="h-10 w-1 bg-white"></div>
                <ion-icon name="ellipse-outline" class="text-[8px] {{ @$routes[1] == 'ticket' ? 'text-primary' : '' }}"></ion-icon>
                <div class="text-sm flex grow {{ @$routes[1] == 'ticket' ? 'text-primary' : '' }}">Tiket</div>
            </a>
            <a href="{{ route('admin.peserta') }}" class="flex items-center gap-4 text-slate-500">
                <div class="h-10 w-1 bg-white"></div>
                <ion-icon name="ellipse-outline" class="text-[8px] {{ @$routes[1] == 'peserta' ? 'text-primary' : '' }}"></ion-icon>
                <div class="text-sm flex grow {{ @$routes[1] == 'peserta' ? 'text-primary' : '' }}">Peserta</div>
            </a>
            <a href="{{ route('admin.booth') }}" class="flex items-center gap-4 text-slate-500">
                <div class="h-10 w-1 bg-white"></div>
                <ion-icon name="ellipse-outline" class="text-[8px] {{ @$routes[1] == 'booth' ? 'text-primary' : '' }}"></ion-icon>
                <div class="text-sm flex grow {{ @$routes[1] == 'booth' ? 'text-primary' : '' }}">Booth</div>
            </a>
        </div>
    </div>

    <div class="group relative">
        <a href="#" class="flex items-center gap-4 text-slate-500 {{ $routes[1] == 'checkin' ? 'bg-primary-transparent text-primary' : '' }}">
            <div class="h-12 w-1 {{ $routes[1] == 'checkin' ? 'bg-primary' : 'bg-white' }}"></div>
            <ion-icon name="checkbox-outline" class="{{ $routes[1] == 'checkin' ? 'text-primary' : '' }}"></ion-icon>
            <div class="text-sm flex grow {{ $routes[1] == 'checkin' ? 'text-primary' : '' }}">Check-in</div>
            <ion-icon name="chevron-down-outline" class="me-4"></ion-icon>
        </a>
        <div class="{{ $routes[1] == 'checkin' ? 'flex' : 'hidden' }} group-hover:flex flex-col mt-2 mb-2">
            <a href="{{ route('admin.checkin.registrasi') }}" class="flex items-center gap-4 text-slate-500">
                <div class="h-10 w-1 bg-white"></div>
                <ion-icon name="ellipse-outline" class="text-[8px] {{ @$routes[2] == 'registrasi' ? 'text-primary' : '' }}"></ion-icon>
                <div class="text-sm flex grow {{ @$routes[2] == 'registrasi' ? 'text-primary' : '' }}">Registrasi</div>
            </a>
            <a href="{{ route('admin.checkin.booth') }}" class="flex items-center gap-4 text-slate-500">
                <div class="h-10 w-1 bg-white"></div>
                <ion-icon name="ellipse-outline" class="text-[8px] {{ @$routes[2] == 'booth' ? 'text-primary' : '' }}"></ion-icon>
                <div class="text-sm flex grow {{ @$routes[2] == 'booth' ? 'text-primary' : '' }}">Booth</div>
            </a>
        </div>
    </div>

    <a href="{{ route('admin.broadcast') }}" class="flex items-center gap-4 {{ in_array('broadcast', $routes) ? 'bg-primary-transparent text-primary' : 'text-slate-500' }}">
        <div class="h-12 w-1 {{ in_array('broadcast', $routes) ? 'bg-primary' : 'bg-white' }}"></div>
        <ion-icon name="volume-high-outline"></ion-icon>
        <div class="text-sm flex">Broadcast</div>
    </a>
    <a href="{{ route('admin.submission') }}" class="flex items-center gap-4 {{ in_array('submission', $routes) ? 'bg-primary-transparent text-primary' : 'text-slate-500' }}">
        <div class="h-12 w-1 {{ in_array('submission', $routes) ? 'bg-primary' : 'bg-white' }}"></div>
        <ion-icon name="file-tray-full-outline"></ion-icon>
        <div class="text-sm flex">Submission</div>
    </a>
    
    {{-- <a href="{{ route('admin.handbook') }}" class="flex items-center gap-4 {{ $routeName == 'admin.handbook' ? 'bg-primary-transparent text-primary' : 'text-slate-500' }}">
        <div class="h-12 w-1 {{ $routeName == 'handbook' ? 'bg-primary' : 'bg-white' }}"></div>
        <ion-icon name="documents-outline"></ion-icon>
        <div class="text-sm flex">Handbook</div>
    </a> --}}

    <div class="group relative">
        <a href="#" class="flex items-center gap-4 text-slate-500 {{ $routes[1] == 'settings' ? 'bg-primary-transparent text-primary' : '' }}">
            <div class="h-12 w-1 {{ $routes[1] == 'settings' ? 'bg-primary' : 'bg-white' }}"></div>
            <ion-icon name="cog-outline" class="{{ $routes[1] == 'settings' ? 'text-primary' : '' }}"></ion-icon>
            <div class="text-sm flex grow {{ $routes[1] == 'settings' ? 'text-primary' : '' }}">Pengaturan</div>
            <ion-icon name="chevron-down-outline" class="me-4"></ion-icon>
        </a>
        <div class="{{ $routes[1] == 'settings' ? 'flex' : 'hidden' }} group-hover:flex flex-col mt-2 mb-2">
            <a href="{{ route('admin.settings.general') }}" class="flex items-center gap-4 text-slate-500">
                <div class="h-10 w-1 bg-white"></div>
                <ion-icon name="ellipse-outline" class="text-[8px] {{ @$routes[2] == 'general' ? 'text-primary' : '' }}"></ion-icon>
                <div class="text-sm flex grow {{ @$routes[2] == 'general' ? 'text-primary' : '' }}">Umum</div>
            </a>
            <a href="{{ route('admin.settings.email') }}" class="flex items-center gap-4 text-slate-500">
                <div class="h-10 w-1 bg-white"></div>
                <ion-icon name="ellipse-outline" class="text-[8px] {{ @$routes[2] == 'email' ? 'text-primary' : '' }}"></ion-icon>
                <div class="text-sm flex grow {{ @$routes[2] == 'email' ? 'text-primary' : '' }}">Email</div>
            </a>
            <a href="{{ route('admin.settings.whatsapp') }}" class="flex items-center gap-4 text-slate-500">
                <div class="h-10 w-1 bg-white"></div>
                <ion-icon name="ellipse-outline" class="text-[8px] {{ @$routes[2] == 'whatsapp' ? 'text-primary' : '' }}"></ion-icon>
                <div class="text-sm flex grow {{ @$routes[2] == 'whatsapp' ? 'text-primary' : '' }}">WhatsApp</div>
            </a>
            <a href="{{ route('admin.settings.admin') }}" class="flex items-center gap-4 text-slate-500">
                <div class="h-10 w-1 bg-white"></div>
                <ion-icon name="ellipse-outline" class="text-[8px] {{ @$routes[2] == 'admin' ? 'text-primary' : '' }}"></ion-icon>
                <div class="text-sm flex grow {{ @$routes[2] == 'admin' ? 'text-primary' : '' }}">Administrator</div>
            </a>
        </div>
    </div>

    {{-- <div class="group relative">
        <a href="#" class="flex items-center gap-4 text-slate-500 {{ in_array(@$routes[0], ['product', 'inventory', 'stock_request']) ? 'bg-primary-transparent text-primary' : '' }}">
            <div class="h-12 w-1 {{ in_array(@$routes[0], ['product', 'inventory', 'stock_request']) ? 'bg-primary' : 'bg-white' }}"></div>
            <ion-icon name="cube-outline" class="{{ in_array(@$routes[0], ['product', 'inventory', 'stock_request']) ? 'text-primary' : '' }}"></ion-icon>
            <div class="text-sm flex grow {{ in_array(@$routes[0], ['product', 'inventory', 'stock_request']) ? 'text-primary' : '' }}">Produk & Inventori</div>
            <ion-icon name="chevron-down-outline" class="me-4"></ion-icon>
        </a>
        <div class="{{ in_array(@$routes[0], ['product', 'inventory', 'stock_request']) ? 'flex' : 'hidden' }} group-hover:flex flex-col mt-2 mb-2">
            <a href="{{ route('product') }}" class="flex items-center gap-4 text-slate-500">
                <div class="h-10 w-1 bg-white"></div>
                <ion-icon name="ellipse-outline" class="text-[8px] {{ @$routes[0] == 'product' ? 'text-primary' : '' }}"></ion-icon>
                <div class="text-sm flex grow {{ @$routes[0] == 'product' ? 'text-primary' : '' }}">Produk</div>
            </a>
        </div>
    </div> --}}

    
</div>

<div class="absolute top-16 left-72 mobile:left-0 right-0 z-10" id="content">
    {{-- {{ $me->branches }} --}}
    @yield('content')
</div>

@include('partials.scan')
@yield('ModalArea')

<script src="{{ asset('js/qr-scanner.umd.min.js') }}"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script>
    const select = dom => document.querySelector(dom);
    const selectAll = dom => document.querySelectorAll(dom);
    const header = select("#header");
    const LeftHeader = select("#LeftHeader");
    const sidebar = select("#sidebar");
    const content = select("#content");
    // const ProfileMenu = select("#ProfileMenu");

    // const randomString = (length) => Array.from({ length }, () => Math.random().toString(36)[2]).join('');
    const randomString = (length) => Array.from({ length }, (_, i) => i < length / 2 ? String.fromCharCode(97 + Math.floor(Math.random() * 26)) : Math.floor(Math.random() * 10)).join('');

    const toggleSidebar = () => {
        if (window.screen.width < 480) {
            toggleSidebarMobile();
        } else {
            toggleSidebarDesktop();
        }
    }
    const toggleSidebarMobile = () => {
        if (sidebar.classList.contains('mobile:left-0')) {
            sidebar.classList.remove('mobile:left-0');
            sidebar.classList.add('mobile:left-[-100%]')
        } else {
            sidebar.classList.remove('mobile:left-[-100%]')
            sidebar.classList.add('mobile:left-0');
        }
    }
    const toggleSidebarDesktop = () => {
        LeftHeader.classList.toggle('w-0');
        
        if (sidebar.classList.contains('w-72')) {
            // close
            sidebar.classList.add('w-0');
            sidebar.classList.remove('w-72');
            content.classList.add('left-0');
            content.classList.remove('left-72');
            setTimeout(() => {
                sidebar.classList.add('hidden');
            }, 210);
        } else  {
            sidebar.classList.remove('hidden');
            sidebar.classList.add('w-72');
            content.classList.remove('left-0');
            content.classList.add('left-72');
            setTimeout(() => {
                sidebar.classList.remove('w-0');
            }, 10)
        }
    }
    const toggleHidden = target => {
        select(target).classList.toggle('hidden');
    }
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
    const onChangeImage = (input, target) => {
        const file = input.files[0];
        const reader = new FileReader();
        const imagePreview = document.querySelector(target);

        reader.onload = function () {
            const source = reader.result;

            // Set image as background
            imagePreview.style.backgroundImage = `url("${source}")`;
            imagePreview.style.backgroundSize = "cover";
            imagePreview.style.backgroundPosition = "center center";

            // Remove placeholder icons (but keep input)
            Array.from(imagePreview.childNodes).forEach(ch => {
                if (ch.tagName !== "INPUT") {
                    ch.remove();
                }
            });

            // If input name ends with [], clone new input
            if (input.name.endsWith("[]")) {
                // Add remove button
                const removeIcon = document.createElement("ion-icon");
                removeIcon.setAttribute("name", "close-circle");
                // removeIcon.className = "text-red-500 text-xl text-white absolute top-1 right-1 cursor-pointer z-10";
                removeIcon.classList.add('text-red-500', 'text-2xl', 'text-white', 'absolute', 'top-1', 'right-1', 'cursor-pointer', 'z-10');
                removeIcon.addEventListener("click", () => {
                    // Only remove if more than one preview exists
                    if (imagePreview.parentNode.querySelectorAll('[id^="imagePreviewEdit"]').length > 1) {
                        imagePreview.remove();
                    }
                });
                imagePreview.appendChild(removeIcon);
                
                const newWrapper = imagePreview.cloneNode(true);
                const newInput = newWrapper.querySelector('input[type="file"]');

                // Reset background and file input
                newWrapper.style.backgroundImage = '';
                newInput.value = '';
                newInput.removeAttribute("required"); // ✅ REMOVE required on clone
                newWrapper.querySelectorAll("*:not(input)").forEach(el => el.remove());

                // Restore placeholder icon
                const placeholderIcon = document.createElement("ion-icon");
                placeholderIcon.setAttribute("name", "image-outline");
                placeholderIcon.className = "text-xl text-slate-700";
                newWrapper.insertBefore(placeholderIcon, newInput);

                // Set new ID and event
                const newId = `imagePreviewEdit-${Date.now()}`;
                newWrapper.id = newId;
                newInput.setAttribute("onchange", `onChangeImage(this, '#${newId}')`);

                // Append new block
                imagePreview.parentNode.appendChild(newWrapper);
            }

        };

        if (file) {
            reader.readAsDataURL(file);
        }
    };

    const applyImageToDiv = (target, src) => {
        if (typeof target === "string") {
            target = select(target);
        }
        target.style.backgroundImage = `url("${src}")`;
        target.style.backgroundSize = "cover";
        target.style.backgroundPosition = "center center";
        
        Array.from(target.childNodes.values()).map(ch => {
            if (ch.tagName !== "INPUT") {
                ch.remove();
            }
        })
    }
    const addFilter = (keyOrObject, value) => {
        const url = new URL(window.location.href);
        const params = url.searchParams;

        if (typeof keyOrObject === 'object' && keyOrObject !== null) {
            // If an object is passed
            Object.entries(keyOrObject).forEach(([key, val]) => {
                if (val === null || val === undefined) {
                    params.delete(key);
                } else {
                    params.set(key, val);
                }
            });
        } else {
            // If single key and value
            if (value === null || value === undefined) {
                params.delete(keyOrObject);
            } else {
                params.set(keyOrObject, value);
            }
        }

        // Build and redirect to the new full URL
        const newUrl = url.origin + url.pathname + '?' + params.toString();
        // console.log(newUrl);
        
        window.location.href = newUrl;
    };

    let qrScanner;

    const InitScanQR = () => {
        const video = select("#Scanner");

        navigator.mediaDevices.getUserMedia({
            video: {
                facing: 'environment'
            },
        })
        .then(stream => {
            video.srcObject = stream;
            video.onloadedmetadata = () => {
                video.play();

                qrScanner = new QrScanner(
                    video,
                    result => {
                        qrScanner.stop();

                        select("#ScanModal #p").value = result.data;
                        select("#ScanModal form").submit();
                    },
                    { /* your options or returnDetailedScanResult: true if you're not specifying any other options */ },
                );

                qrScanner.start();
            }
            
            toggleHidden("#ScanModal");
        });
        
    }

    // InitScanQR();

</script>
@yield('javascript')

</body>
</html>