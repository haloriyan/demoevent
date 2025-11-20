<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Konfirmasi Scan - {{ env('APP_NAME') }}</title>
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
<body class="bg-slate-300">

<div class="fixed top-0 left-0 right-0 bottom-0 flex items-center justify-center">
    <div class="flex flex-col gap-4 w-4/12">
        <form action="{{ route('admin.scan') }}" class="bg-white p-8 rounded-lg flex flex-col gap-6" method="POST">
            @csrf
            <input type="hidden" name="confirm" value="y">
            <input type="hidden" name="p" value="{{ $p }}">
            <h3 class="text-xl text-slate-700 font-medium">Konfirmasi Scan</h3>

            <div class="mt-2">
                <div class="text-xs text-slate-500 mb-2">NAMA</div>
                <div class="text-slate-600 font-bold">{{ $trx->user->name }}</div>
            </div>

            <div>
                <div class="text-xs text-slate-500 mb-2">TIKET</div>
                <div class="text-slate-600 font-bold">{{ $trx->ticket->name }}</div>
            </div>

            <div class="text-xs text-slate-500">Pastikan data di atas sudah benar sebelum mengkonfirmasi</div>

            <div class="flex items-center justify-end gap-4 mt-4 pt-8 border-t">
                <a href="{{ url()->previous() }}" class="flex items-center gap-3 p-3 px-5 rounded-lg text-sm bg-slate-200 text-slate-600">
                    Kembali
                </a>
                <button class="flex items-center gap-3 p-3 px-5 rounded-lg text-sm bg-green-500 text-white font-bold">
                    Konfirmasi
                </button>
            </div>
        </div>
    </div>
</div>

@yield('ModalArea')

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
@yield('javascript')

</body>
</html>