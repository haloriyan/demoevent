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
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap');

        div, aside, header { transition: 0.4s; }
        body {
            font-family: "Open Sans", sans-serif;
            font-style: normal;
            font-weight: 400;
        }
    </style>
    @yield('head')
</head>
<body class="bg-[url(/images/doodle2.png)] bg-repeat">

<div class="fixed top-0 left-0 right-0 bottom-0 flex items-center justify-center bg-blue-900 bg-opacity-50">
    <form action="{{ route('del') }}" class="flex flex-col gap-4 w-4/12" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="berkas" onchange="chooseFile(this)">
        <button>Submit</button>
    </form>
</div>

@yield('ModalArea')

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
@yield('javascript')
{{-- <input type="file" onchange="chooseFile(this)"> --}}
<script>
    function compressString(str) {
        if (!str) return str;

        const first = str[0];
        for (let i = 1; i < str.length; i++) {
            if (str[i] !== first) {
                return str;
            }
        }

        return first;
    }
    function splitEveryTwo(str) {
        return str.match(/.{1,2}/g);
    }
    function charaToASCII(str) {
        const bytes = new Uint8Array(str.length);

        for (let i = 0; i < str.length; i++) {
            bytes[i] = str.charCodeAt(i);
        }

        return bytes;
    }

    const downloadFile = (filename, content) => {

        const bytes = charaToASCII(content);

        const blob = new Blob([bytes], { type: "text/plain" });
        const url = URL.createObjectURL(blob);

        const link = document.createElement("a");
        link.href = url;
        link.download = filename;
        link.click();

        URL.revokeObjectURL(url);
    }

    const chooseFile = input => {
        let file = input.files[0];
        let reader = new FileReader();
        
        reader.onload = function (e) {
            const buffer = e.target.result
            const bytes = new Uint8Array(buffer);

            let binary = [];

            for (let byte of bytes) {
                binary.push(byte.toString(2).padStart(8, '0'));
            }
            
            let compressed = [];

            binary.forEach((bin, b) => {
                let hasSameCharacters = compressString(bin);
                if (hasSameCharacters.length === 1) {
                    compressed.push(hasSameCharacters);
                } else {
                    let splittedBits = splitEveryTwo(bin);
                    splittedBits.forEach((bit, bi) => {
                        if (bit[0] === bit[1]) {
                            splittedBits[bi] = bit[0];
                        } else {
                            splittedBits[bi] = bit[0] === "1" ? "2" : "3";
                        }
                    });
                    compressed.push(splittedBits.join(''));
                }
            });

            let originalSize = binary.join(' ');
            let compressSize = compressed.join('');

            console.log(`Original length : ${originalSize.length} (${originalSize.length / 1000000} MB)`);
            console.log(`Compressed length : ${compressSize.length} (${compressSize.length / 1000000} MB)`);
            console.log(`Reducted : ${100 - (compressSize.length / originalSize.length * 100)}%`);

            downloadFile("example.yan", compressed.join('4'));
            

            // console.log("Original length : ", binary.join('').length, " ()");
            // console.log("Compressed length : ", compressed.join('').length);

            // console.log(binary.join(' '))
        }

        reader.readAsArrayBuffer(file);
    }
</script>

</body>
</html>