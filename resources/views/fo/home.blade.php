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
<body class="bg-slate-200 mobile:bg-white">

<div class="absolute top-0 left-0 right-0 flex items-center justify-center">
    <div class="bg-white rounded-lg w-4/12 mobile:w-full desktop:shadow relative">
        {{-- <video class="w-full aspect-square mobile:aspect-[3/4] bg-black rounded-b-lg" id="Scanner"></video> --}}
        <div class="relative">
            <video id="Scanner" class="w-full aspect-square bg-black/40 rounded-xl"></video>

            <div class="absolute inset-0 pointer-events-none rounded-xl">
                <!-- center frame container -->
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="relative w-6/12 aspect-square z-10">
                        <div class="absolute inset-0 border-2 border-white/60 rounded-md"></div>

                        <div class="absolute -top-1 -left-1 w-10 h-10 border-t-4 border-l-4 border-blue-400 rounded-tl-md"></div>
                        <div class="absolute -top-1 -right-1 w-10 h-10 border-t-4 border-r-4 border-blue-400 rounded-tr-md"></div>
                        <div class="absolute -bottom-1 -left-1 w-10 h-10 border-b-4 border-l-4 border-blue-400 rounded-bl-md"></div>
                        <div class="absolute -bottom-1 -right-1 w-10 h-10 border-b-4 border-r-4 border-blue-400 rounded-br-md"></div>
                    </div>
                </div>

                <!-- overlay panels -->
                <!-- top -->
                <div class="absolute left-0 right-0 top-0" style="height: 25%; background: rgba(0,0,0,0.70);"></div>
                <!-- bottom -->
                <div class="absolute left-0 right-0 bottom-0" style="height: 25%; background: rgba(0,0,0,0.70);"></div>
                <!-- left (between top & bottom) -->
                <div class="absolute" style="top:25%; bottom:25%; left:0; width:25%; background: rgba(0,0,0,0.70);"></div>
                <!-- right -->
                <div class="absolute" style="top:25%; bottom:25%; right:0; width:25%; background: rgba(0,0,0,0.70);"></div>
            </div>
        </div>
        
        <form action="#" method="POST" class="p-8 bg-white rounded-lg mt-[-30px] flex flex-col gap-4 absolute w-full" id="FormContent">
            @csrf
            <input type="hidden" id="trx_id" name="trx_id">

            <div class="flex flex-col gap-1">
                <div class="text-xs text-slate-500 italic">NAMA</div>
                <div class="text-sm text-slate-700 font-medium" id="name"></div>
            </div>
        </form>
        <div class="p-8 bg-white rounded-lg mt-[-30px] flex flex-col gap-4 absolute w-full" id="DefaultContent">
            <div class="flex items-center gap-4 rounded-lg border px-4">
                <input type="text" class="w-full h-14 outline-0 text-sm text-slate-600 bg-none rounded-lg" placeholder="Cari nama peserta..." oninput="handleSearchUsers(this)">
                <ion-icon name="search-outline" class="text-lg"></ion-icon>
            </div>

            <div class="flex flex-col gap-3" id="RenderUsersArea"></div>
        </div>

        <div class="absolute bottom-12 right-4 left-4 flex items-center gap-4" onclick="toggleFacing()">
            <div class="bg-white text-xs text-slate-700 flex items-center gap-2 p-1 pe-4 rounded-full hidden" id="Alert">
                <div class="w-8 h-8 flex items-center justify-center bg-green-500 text-white rounded-full AlertIcon" id="AlertCheck">
                    <ion-icon name="checkmark-outline" class="text-lg"></ion-icon>
                </div>
                <div class="w-8 h-8 flex items-center justify-center bg-red-500 text-white rounded-full AlertIcon" id="AlertFailed">
                    <ion-icon name="close-outline" class="text-lg"></ion-icon>
                </div>
                <div class="text-xs text-slate-600" id="AlertMessage">Berhasil Melakukan Scan</div>
            </div>
            <div class="flex grow"></div>
            <div class="w-12 h-12 rounded-full bg-white/30 backdrop-blur-sm border-[0.5px] flex items-center justify-center">
                <ion-icon name="camera-reverse-outline" class="text-xl text-white"></ion-icon>
            </div>
        </div>
    </div>
</div>

@yield('ModalArea')

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="/js/qr-scanner.umd.min.js"></script>
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

    let debounceTimer = null;
    const debounce = (callback, timer = 1000) => {
        clearTimeout(debounceTimer);

        debounceTimer = setTimeout(() => {
            callback();
        }, timer);
    }
    
    let users = [];

    const handleSearchUsers = input => {
        let q = input.value;
        if (q !== "") {
            debounce(() => {
                SearchUsers(q);
            })
        } else {
            SearchUsers(q, true);
        }
    }
    const SearchUsers = async (q, makeEmpty = false) => {
        if (makeEmpty) {
            await new Promise(resolve => setTimeout(resolve, 100)); // 300ms delay
            users = [];
        } else {
            const response = await axios.post("/api/users/search", {
                q,
                with: ['transaction.ticket']
            });
            const res = await response.data;
            users = res.users;
        }

        RenderUsers();
    }
    const RenderUsers = () => {
        let area = select("#RenderUsersArea");
        area.innerHTML = "";

        users.map((user, u) => {
            let item = document.createElement('div');
            item.classList.add('flex', 'items-center', 'gap-3');
            item.innerHTML = `<div class="flex flex-col gap-1 grow">
                <div class="text-sm text-slate-600 font-medium">${user.name}</div>
                <div class="text-xs text-slate-500">${user.email ?? '-'} </div>
            </div>
            <button class="text-xs text-white bg-primary rounded-full font-medium p-2 px-3" data-user='${JSON.stringify(user)}' onclick="chooseUser(this)">Cek</button>`;
            area.appendChild(item);
        })
    }
    const chooseUser = (btn) => {
        let user = JSON.parse(btn.getAttribute('data-user'));
        let payload = {
            trx_id: user.transaction.id,
            user_id: user.id,
        };

        checkUser(
            btoa(JSON.stringify(payload))
        );
    }

    let facingMode = "environment";
    let qrScanner = null;
    let holdScanner = false;
    const InitScanQR = () => {
        const video = select("#Scanner");

        navigator.mediaDevices.getUserMedia({
            video: {
                facingMode,
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
                        holdScanner = true;
                        checkUser(result.data);
                        
                    },
                    { /* your options or returnDetailedScanResult: true if you're not specifying any other options */ },
                );

                qrScanner.start();
            }
        });   
    }

    setInterval(() => {
        if (!holdScanner && qrScanner !== null) {
            qrScanner.start();
        }
    }, 3000);

    const checkUser = async (p) => {
        const response = await axios.post("/admin/scan", {
            p,
            confirm: "y",
            response_type: "api"
        });
        const res = await response.data;
        let alertArea = select("#Alert");

        select("#AlertMessage").innerHTML = res.message;
        selectAll(".AlertIcon").forEach(item => item.classList.add('hidden'));
        if (res.scan === null) {
            select("#AlertFailed").classList.remove('hidden');
        } else {
            select("#AlertCheck").classList.remove('hidden');
        }

        alertArea.classList.remove('hidden');
        setTimeout(() => {
            holdScanner = false;
            qrScanner.start();
            alertArea.classList.add('hidden');
            users = [];
            RenderUsers();
        }, 4000);
    }

    InitScanQR();

    const toggleFacing = () => {
        facingMode = facingMode === "user" ? "environment" : "user";
        InitScanQR();
    }
</script>
@yield('javascript')

</body>
</html>