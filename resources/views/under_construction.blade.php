<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Under Construction | Medical Portal</title>
    
    <!-- Tailwind CSS (CDN) -->
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

        .medical-float {
            animation: float 6s ease-in-out infinite;
        }

        .ekg-line {
            stroke-dasharray: 1000;
            stroke-dashoffset: 1000;
            animation: drawLine 3s linear infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }

        @keyframes drawLine {
            0% { stroke-dashoffset: 1000; opacity: 0; }
            10% { opacity: 1; }
            80% { stroke-dashoffset: 0; opacity: 1;}
            100% { stroke-dashoffset: 0; opacity: 0;}
        }

        /* Glassmorphism utility for older doctors to read easily */
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
    </style>
</head>

<div class="absolute top-0 left-0 right-0 bottom-0 flex flex-col gap-4 items-center justify-center">
    <div class="p-3 px-7 text-xs font-bold bg-blue-100 text-blue-500 rounded-full">
        UNDER CONSTRUCTION
    </div>
    <svg class="w-64 h-64 md:w-80 md:h-80 medical-float drop-shadow-xl" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
        <!-- Shield Base -->
        <path d="M200 380C200 380 360 300 360 140V60L200 20L40 60V140C40 300 200 380 200 380Z" fill="white"/>
        
        <!-- Cross Shape Background -->
        <rect x="160" y="100" width="80" height="200" rx="10" class="fill-secondary"/>
        <rect x="100" y="160" width="200" height="80" rx="10" class="fill-secondary"/>

        <!-- Animated EKG Line -->
        <path class="ekg-line stroke-primary" 
                d="M60 200 H140 L160 250 L190 130 L220 230 L240 200 H340" 
                stroke-width="12" 
                stroke-linecap="round" 
                stroke-linejoin="round"/>
        
        <!-- Circle Decor -->
        <circle cx="200" cy="200" r="140" stroke="#cbd5e1" stroke-width="2" stroke-opacity="0.3"/>
    </svg>
    <div class="w-7/12 mobile:w-10/12 flex flex-col items-center text-center gap-4">
        <h1 class="text-3xl mobile:text-xl text-slate-700 font-bold leading-[48px]">Kami Sedang Merencanakan<br /><span class="text-blue-500">Pengalaman Terbaik</span> untuk Anda.</h1>
        <div class="text-slate-600 mobile:text-sm">
            Terima kasih atas antusias Anda mengikuti acara ini. Nantikan persembahan terbaik dari Kami.
        </div>
    </div>
</div>

</body>
</html>