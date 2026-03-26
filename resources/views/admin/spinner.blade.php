<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/css/Firework.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {!! json_encode(config('tailwind')) !!}
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap');

        div, aside, header, a, nav { transition: 0.4s; }
        body {
            font-family: "Open Sans", sans-serif;
            font-style: normal;
            font-weight: 400;
        }
    </style>
</head>
<body>

<form action="{{ route('admin.spinner.store') }}" method="POST" id="SpinnerStore">
    @csrf
    <input type="hidden" name="user_id" id="user_id">
</form>

<div style="position: fixed;top: 0;left: 0;right: 0;bottom: 0;z-index: 10;display: flex;align-items: center;justify-content: center;">
    <div id="spinner"></div>
</div>

<div class="fixed top-8 right-8 bg-white/30 text-white backdrop-blur-md rounded-xl p-8 z-20">
    <div class="flex items-center gap-3">
        <div class="w-12 h-12 bg-white text-black rounded-full flex items-center justify-center">
            <ion-icon name="podium-outline" class="text-2xl"></ion-icon>
        </div>
    </div>

    <div class="flex flex-col gap-2 mt-8">
        @foreach ($winners as $winner)
            <div class="relative group flex items-center gap-8">
                <div class="mobile:text-sm flex grow">{{ $winner->user->name }}</div>
                <a href="{{ route('admin.spinner.remove', $winner->user_id) }}" class="w-6 h-6 rounded-full bg-white flex items-center justify-center text-black">
                    <ion-icon name="close-outline" class="text-lg"></ion-icon>
                </a>
            </div>
        @endforeach
    </div>
</div>

<div id="FireworkArea" style="display: none">
    @for ($i = 0; $i < 9; $i++)
        <div class="firework"></div>
    @endfor
</div>

<script src="/js/SpinnerWheel.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script>
    const users = @json($users);
    const select = dom => document.querySelector(dom);
    let FireworkArea = select("#FireworkArea");
    let winner = null;

    let spinner = new SpinnerWheel({
        el: '#spinner',
        items: users
    });

    spinner.onPicked = (picked) => {
        FireworkArea.style.display = "flex";
        winner = picked;
    };

    spinner.onClose = () => {
        FireworkArea.style.display = "none";
        select("#SpinnerStore #user_id").value = winner.id;
        select("#SpinnerStore").submit();
    }
</script>
    
</body>
</html>