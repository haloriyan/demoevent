@extends('layouts.booth')

@section('Scan Booth')

@section('head')
<style>
    .loader {
        width: 48px;
        height: 48px;
        border: 3px solid #FFF;
        border-radius: 50%;
        display: inline-block;
        position: relative;
        box-sizing: border-box;
        animation: rotation 1s linear infinite;
    }
    .loader::after {
        content: '';  
        box-sizing: border-box;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        width: 56px;
        height: 56px;
        border-radius: 50%;
        border: 3px solid;
        border-color: #FF3D00 transparent;
    }

    @keyframes rotation {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
</style>
@endsection
    
@section('content')
<div class="absolute top-0 left-0 right-0 bottom-0 bg-black flex flex-col justify-center text-white" id="container">
    <div class="relative flex flex-col grow bg-blue-400">
        <video id="Scanner" class="w-full h-full object-cover bg-green-500"></video>
        <div id="ScannerOverlay" class="absolute inset-0 pointer-events-none flex items-center justify-center">
            <div class="scanner-box"></div>
        </div>
    </div>
</div>

<div class="absolute top-6 mobile:top-0 left-0 right-0 h-20 flex items-center justify-end gap-4 text-white px-4">
    @csrf
    <a href="#" class="flex items-center gap-4">
        <ion-icon name="arrow-back-outline" class="text-2xl"></ion-icon>
    </a>
    <div class="flex justify-center grow">
        @include('partials.flash_message')
    </div>
    <div class="w-12 h-12 rounded-full flex items-center justify-center border border-white hidden" id="FlashBtn" onclick="toggleFlash()">
        <ion-icon name="flashlight-outline"></ion-icon>
    </div>
</div>
@endsection

@section('ModalArea')

@include('booth.scan_check')
@endsection

@section('javascript')
<script src="/js/qr-scanner.umd.min.js"></script>
<script>
    select("#container").style.height = `${window.innerHeight}px`;
    let qrScanner;

    let flashBtn = select("#FlashBtn");
    let flash = {
        isAvailable: false,
        isOn: false,
        track: null,
    }

    let isProcessing = false;
    const InitScanQR = () => {
        const video = select("#Scanner");

        navigator.mediaDevices.getUserMedia({
            video: {
                facingMode: 'environment'
            },
        })
        .then(stream => {
            let track = stream.getVideoTracks()[0];
            let capabilities = track.getCapabilities();
            flash.isAvailable = "torch" in capabilities;
            flash.track = track;

            if (flash.isAvailable) {
                flashBtn.classList.remove('hidden');
            }
            
            video.srcObject = stream;
            video.onloadedmetadata = () => {
                video.play();

                qrScanner = new QrScanner(
                    video,
                    result => {
                        if (isProcessing) return;
                        isProcessing = true;
                        qrScanner.stop();
                        console.log(result);
                        let data = JSON.parse(atob(result));
                        
                        onScanned(data);
                    },
                );

                qrScanner.start();
            }
        });
        
    }

    const onScanned = async data => {
        console.log('checking scanned data');
        data['token'] = selectAll("input[name='_token']")[0].value;
        toggleHidden('#ScanCheck');
        select("#ScanCheck #LoadingContainer").classList.remove('hidden');
        selectAll(".Response").forEach(item => item.classList.add('hidden'));

        console.log(data);
        
        
        const response = await fetch("/booth/scan/check", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": data.token,
            },
            body: JSON.stringify(data)
        });
        const res = await response.json();
        const user = res.user;

        console.log(user);

        select("#ScanCheck #LoadingContainer").classList.add('hidden');

        if (user === null) {
            toggleHidden('#ScanCheck #Error');
        } else {
            select("#ScanCheck #user_id").value = user.id;
            select("#ScanCheck #name").innerHTML = user.name;
            select("#ScanCheck #instansi").innerHTML = user.instansi ?? "-";
            select("#ScanCheck #initial").innerHTML = Initial(user.name);

            toggleHidden('#ScanCheck #Result');
        }
        setTimeout(() => {
            isProcessing = false;
            qrScanner.start();
        }, 1900);
        
    }
    const toggleFlash = async () => {
        try {
            if (flash.isOn) {
                flashBtn.classList.add('bg-white/30', 'backdrop-blur-sm');
            } else {
                flashBtn.classList.remove('bg-white/30', 'backdrop-blur-sm');
            }
            await flash.track.applyConstraints({ advanced: [{ torch: flash.isOn }] });
            flash.isOn = !flash.isOn;
        } catch (err) {
            // alert(JSON.stringify(err))
            console.log(err);
            
        }
    }

    InitScanQR();
</script>
@endsection